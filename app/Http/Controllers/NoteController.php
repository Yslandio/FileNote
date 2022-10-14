<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function rules($request) {
        return $request->validate([
            'title' => ['required', 'max:160'],
            'content' => ['required'],
            'color' => ['required', 'max:20'],
        ],[
            'title.required' => 'O campo título é obrigatório!',
            'title.max' => 'O campo título não pode conter mais que 160 caracteres!',
            'content.required' => 'O campo conteúdo é obrigatório!',
            'color.required' => 'O campo cor é obrigatório!',
            'color.max' => 'O campo cor não pode conter mais que 20 caracteres!',
        ]);
    }

    public function create(Request $request) {
        // $dados = $request->except('_token');
        $dados = $this->rules($request);
        $dados['user_id'] = Auth::user()->id;

        return Note::create($dados)
            ? back()->with('success', 'Anotação criada com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar criar a anotação!');
    }

    public function read(Request $request) {
        $search = $request->search;

        return view('dashboard', ['notes' => Note::where('user_id', Auth::user()->id)->where(function ($query) use ($search) {
            if ($search) {
                $query->where('title', 'LIKE', "%$search%");
                $query->orWhere('content', 'LIKE', "%$search%");
            }
        })->orderBy('id', 'desc')->paginate(6)]);
    }

    public function update(Request $request) {
        $dados = $this->rules($request);
        $dados['user_id'] = Auth::user()->id;

        return Note::find($request->id)->update($dados)
            ? back()->with('success', 'Anotação editada com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar editar a anotação!');
    }

    public function delete(Request $request) {
        return Note::find($request->id)->delete()
            ? back()->with('success', 'Anotação excluída com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar excluir a anotação!');
    }
}
