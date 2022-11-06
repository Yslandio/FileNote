<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $dados = $this->rules($request);
        $dados['user_id'] = Auth::user()->id;

        return Note::create($dados)
            ? back()->with('success', 'Anotação criada com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar criar a anotação!');
    }

    public function read(Request $request) {
        $search = $request->search;

        return view('user.dashboard', ['notes' => Note::where('user_id', Auth::user()->id)->where(function ($query) use ($search) {
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
        // Excluir arquivos associados
        $files = File::where('note_id', $request->id)->get();

        foreach ($files as $file) {
            if (Storage::exists($file->directory))
                Storage::delete($file->directory); // Exclusão de arquivo
        }

        return Note::find($request->id)->delete()
            ? back()->with('success', 'Anotação excluída com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar excluir a anotação!');
    }

    public function storeFile(Request $request) {
        $request->validate([
            'note_id' => ['required', 'numeric'],
            'file' => ['required', 'file', 'max:4096'],
        ],[
            'file.required' => 'Selecione um arquivo!',
            'file' => 'Selecione um arquivo válido!',
            'max' => 'O arquivo não pode ser maior que 4096Kb!',
        ]);

        $file = $request->file->store('files'); // Upload de arquivo

        return File::create(['note_id' => $request->note_id, 'directory' => $file])
            ? back()->with('success', 'Arquivo enviado com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar enviar o arquivo!');
    }

    public function deleteFile(Request $request) {
        $request->validate([
            'note_id' => ['required', 'numeric'],
            'id' => ['required', 'numeric'],
            'directory' => ['required'],
        ]);

        if (Storage::exists($request->directory))
            Storage::delete($request->directory); // Exclusão de arquivo

        return File::find($request->id)->delete()
            ? back()->with('success', 'Arquivo excluído com sucesso!')
            : back()->with('fail', 'Ocorreu um erro ao tentar excluir o arquivo!');
    }
}
