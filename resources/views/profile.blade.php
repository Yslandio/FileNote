@extends('layouts.app')

@section('header_dropdown_li')
    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
@endsection

@section('content')
    <div class="container d-flex flex-column align-items-center my-4 gap-3">
        <div class="col-12">
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

        <div class="card shadow col-12 col-md-6">
            <div class="card-body d-flex justify-content-center">
                <img class="img-fluid rounded-circle" style="max-width: 400px;" src="{{ asset('storage/'.Auth::user()->photo) }}" alt="Foto do usuário">
            </div>
            <div class="card-footer">
                <form class="d-flex flex-wrap justify-content-end justify-content-md-between gap-2"
                    action="{{ route('change.photo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control w-auto" type="file" name="photo">
                    <button class="btn btn-success" type="submit">Salvar</button>
                </form>
            </div>
        </div>

        <div class="card shadow col-12 col-md-6">
            <form action="{{ route('change.name') }}" method="post">
                @csrf
                <div class="card-body d-flex flex-wrap gap-2">
                    <label>E-mail:</label>
                    <input class="form-control" type="text" value="{{ Auth::user()->email }}" readonly disabled>
                    <label>Nome:</label>
                    <input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}">
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-success" type="submit">Salvar</button>
                </div>
            </form>
        </div>

        <div class="card shadow col-12 col-md-6">
            <form action="{{ route('change.password') }}" method="post">
                @csrf
                <div class="card-body d-flex flex-wrap gap-2">
                    <label>Senha Atual:</label>
                    <input class="form-control" type="password" name="current_password">
                    <label>Nova Senha:</label>
                    <input class="form-control" type="password" name="password">
                    <label>Repetir Senha:</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-success" type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
