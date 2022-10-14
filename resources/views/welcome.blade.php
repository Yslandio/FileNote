<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FileNote</title>

        <!-- Bootstrap - CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="bg-light">
        @if (Route::has('login'))
            <header class="d-flex flex-wrap justify-content-between p-2 shadow">
                @include('components.application-logo')
                <div class="d-flex flex-wrap align-items-center gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 btn btn-outline-success">Register</a>
                        @endif
                    @endauth
                </div>
            </header>
        @endif

        <div class="container">
            <div class="row flex-wrap my-4 shadow-lg p-5">
                <div class="col-12 col-md-6 order-2 order-md-1 d-flex align-items-center">
                    <h1 class="py-2 text-center">Faça as suas anotações diárias sem perder tempo!</h1>
                </div>
                <div class="col-12 col-md-6 order-1 order-md-2">
                    <img class="img-fluid" src="{{ asset('img/fundo2.png') }}" alt="">
                </div>
            </div>
            <section class="row flex-wrap my-4 shadow-lg p-5">
                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="{{ asset('img/praticidade.png') }}">
                    <h3 class="py-2 text-center">Anotações de forma rápida, fácil  e inteligente através de uma ferramenta simples e prática.</h3>
                </div>
                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="{{ asset('img/associacao.png') }}">
                    <h3 class="py-2 text-center">Associe arquivos as suas anotações, possibilitando uma nova forma diferente e mais completa para a criação de suas notas.</h3>
                </div>
            </section>
        </div>
    </body>
</html>
