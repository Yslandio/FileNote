<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
        $search = $request->search;

        return view('admin.dashboard', ['users' => User::where(function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'LIKE', "%$search%");
                $query->orWhere('email', 'LIKE', "%$search%");
            }
        })->orderBy('id', 'desc')->paginate(10)]);
    }

    public function disableUser(Request $request) {
        return User::find($request->id)->update(['status' => false])
            ? back()->with('success', 'Usuário desativado com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar desativar o usuário!');
    }

    public function activeUser(Request $request) {
        return User::find($request->id)->update(['status' => true])
            ? back()->with('success', 'Usuário ativado com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar ativar o usuário!');
    }
}
