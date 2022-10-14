<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile() {
        return view('profile');
    }

    public function changePhoto(Request $request) {
        $request->validate([
            'photo' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
        ],[
            'photo.required' => 'É obrigatório selecionar uma foto!',
            'photo.mimes' => 'Os formatos de imagem permitidos são: jpg, jpeg, png!',
            'photo.max' => 'A foto não pode ser maior que 1024Kb!',
        ]);

        if (Auth::user()->photo != 'users/user_default.png' && Storage::exists('users/'.$request->photo->getClientOriginalName()))
            Storage::delete(Auth::user()->photo); // Exclusão de foto

        $photo = $request->photo->store('users'); // Upload de foto

        return User::find(Auth::user()->id)->update(['photo' => $photo])
            ? back()->with('success', 'Foto alterada com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar alterar a foto!');
    }

    public function changeName(Request $request) {
        return User::find(Auth::user()->id)->update(['name' => $request->name])
            ? back()->with('success', 'Nome alterado com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar alterar o nome!');
    }

    public function changePassword(Request $request) {
        $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required'],
        ],[
            'current_password.required' => 'O campo senha atual é obrigatório!',
            'current_password.current_password' => 'A senha atual está incorreta!',
            'password.required' => 'O campo nova senha é obrigatório!',
            'password.confirmed' => 'O campo de repetir senha não corresponde!',
            'password.min' => 'A quantidade mínima de caracteres é 8!',
            'password_confirmation.required' => 'O campo repetir senha é obrigatório!',
        ]);

        return User::find(Auth::user()->id)->update(['password' => Hash::make($request->password)])
            ? back()->with('success', 'Senha alterada com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar alterar a senha!');
    }
}
