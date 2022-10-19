@extends('layouts.app')

@section('header_dropdown_li')
    <li><a class="dropdown-item" href="{{ route('profile') }}">Perfil</a></li>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex  flex-wrap justify-content-between gap-2 bg-light rounded shadow-sm border border-2 p-3 my-4">
            <form class="d-flex flex-wrap gap-2 w-auto px-0" action="{{ route('user.dashboard') }}" method="get">
                <input class="form-control w-auto" type="text" name="search" placeholder="Pesquisar"
                    value="{{ request()->get('search') }}">
                <button class="btn btn-outline-dark d-flex align-items-center" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </form>
            <!-- Button trigger modal - Criar anotação -->
            <button type="button" class="btn btn-warning d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createNote">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </button>
            <!-- Modal - Criar anotação -->
            <div class="modal fade" id="createNote" tabindex="-1" aria-labelledby="createNoteLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createNoteLabel">Criar Anotação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('create.note') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <label>Título:</label>
                                <input class="form-control" type="text" name="title">
                                <label>Conteúdo:</label>
                                <textarea class="form-control" name="content" cols="30" rows="10"></textarea>
                                <label>Cor:</label>
                                <input class="form-control" type="color" name="color">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-warning">Criar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row flex-wrap justify-content-start my-4 g-2">
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

            @forelse ($notes as $note)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <h5 class="card-header" style="background-color: {{ $note->color }}80;">{{ $note->title }}</h5>
                        <div class="card-body" style="background-color: {{ $note->color }}50;">
                            <textarea class="card-text form-control mb-3" readonly>{{ $note->content }}</textarea>
                            <div class="d-flex flex-wrap">
                                <div class="d-flex flex-wrap gap-2 bg-light border border-1 rounded p-2 w-75">
                                    <form class="d-flex gap-2" action="{{ route('storeFile.note') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="note_id" value="{{ $note->id }}">
                                        <input class="form-control" type="file" name="file">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                                <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <div class="d-flex flex-wrap gap-2 border border-1 rounded w-100 p-2 overflow-auto">
                                        @forelse ($note->files as $file)
                                            <div class="d-flex align-items-center gap-2 shadow p-2">
                                                <form action="{{ route('deleteFile.note') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="note_id" value="{{ $note->id }}">
                                                    <input type="hidden" name="id" value="{{ $file->id }}">
                                                    <input type="hidden" name="directory" value="{{ $file->directory }}">
                                                    <button class="btn btn-outline-danger" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <a class="btn btn-outline-info" href="{{ asset('storage/'.$file->directory) }}" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                    </svg>
                                                </a>
                                                <p class="mb-0" style="font-size: 10pt;">{{ $file->directory }}</p>
                                            </div>
                                        @empty
                                            <h6 class="alert alert-warning text-center m-0 w-100 h-100">Nenhum arquivo anexado!</h6>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap flex-column align-items-end gap-2 ps-2 w-25">
                                    <div>
                                        <!-- Button trigger modal - Editar anotação -->
                                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#updateNote" data-bs-note="{{ json_encode($note) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('delete.note') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $note->id }}">
                                        <button class="btn btn-outline-danger" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @if (request()->get('search') == '')
                    <h5 class="alert alert-danger text-center">Nenhuma anotação criada!</h5>
                @else
                    <h5 class="alert alert-danger text-center">Nenhuma anotação encontrada!</h5>
                @endif
            @endforelse

            {{ $notes->appends(['search' => request()->get('search', '')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

    <!-- Modal - Editar anotação -->
    <div class="modal fade" id="updateNote" tabindex="-1" aria-labelledby="updateNoteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="modal-header-update">
                    <h5 class="modal-title" id="updateNoteLabel">Editar Anotação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.note') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="modal-id-update">
                    <div class="modal-body d-flex flex-wrap gap-2" id="modal-body-update">
                        <label>Título:</label>
                        <input class="form-control" id="modal-title-update" type="text" name="title">
                        <label>Conteúdo:</label>
                        <textarea class="form-control" id="modal-content-update" name="content" cols="30" rows="10"></textarea>
                        <label>Cor:</label>
                        <input class="form-control" id="modal-color-update" type="color" name="color">
                    </div>
                    <div class="modal-footer" id="modal-footer-update">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/update_note.js') }}"></script>
@endpush
