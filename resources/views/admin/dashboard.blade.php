@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-wrap justfy-content-between bg-light shadow aborder border-2 rounded p-3 my-4">
            <form class="d-flex flex-wrap gap-2 w-auto px-0" action="{{ route('admin.dashboard') }}" method="get">
                <input class="form-control w-auto" type="text" name="search" placeholder="Pesquisar"
                    value="{{ request()->get('search') }}">
                <button class="btn btn-outline-dark d-flex align-items-center" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        <div class="row">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('fail'))
                <div class="alert alert-danger text-center">
                    {{ session('fail') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="row justify-content-center my-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Criação</th>
                        <th>Edição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->status ? 'Ativado' : 'Desativado' }}</td>
                            <td>{{ $user->type }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($user->created_at)) }}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($user->updated_at)) }}</td>
                            <td class="d-flex flex-wrap justify-content-center gap-2">
                                @if ($user->type != 'admin')
                                    @if ($user->status)
                                        <form action="{{ route('disable.user') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button class="btn btn-outline-danger" type="submit">Desativar</button>
                                        </form>
                                    @else
                                        <form action="{{ route('active.user') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button class="btn btn-outline-primary" type="submit">Ativar</button>
                                        </form>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        @if (request()->get('search') == '')
                            <tr>
                                <td class="alert alert-danger text-center" colspan="7">Nenhum usuário cadastrado!</td>
                            </tr>
                        @else
                            <tr>
                                <td class="alert alert-danger text-center" colspan="7">Nenhum usuário encontrado!</td>
                            </tr>
                        @endif
                    @endforelse

                    {{ $users->appends(['search' => request()->get('search', '')])->links('vendor.pagination.bootstrap-4') }}
                </tbody>
            </table>
        </div>
    </div>
@endsection
