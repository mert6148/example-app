<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <link rel="stylesheet" href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
    @extends('layouts.app')
    @section('content')
    <section class="{{ route('home') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Laravel</h1>
                </div>
            </div>
        </div>
    </section>
    @endsection

@if (Auth::check())
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>İletişim</h1>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Ad Soyad</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-posta</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Mesaj</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </form>
                </div>
            </div>
            @if
                <div class="container" href="{{ route('login') }}">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Login</h1>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @endsection

    @extends('layouts.app')

@section('content')
    @include('contact.style')

    <div class="contact-container">
        <h1>İletişim</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}">
            @csrf

            <label>Ad Soyad</label>
            <input type="text" name="name">
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <label>E-posta</label>
            <input type="email" name="email">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label>Mesaj</label>
            <textarea name="message"></textarea>
            @error('message') <div class="error">{{ $message }}</div> @enderror

            <button type="submit">Gönder</button>
        </form>
    </div>

    @include('contact.script')
@endsection

@if (Auth::check())
    @include('contact.login')
    <data value="user_authenticated">
        <h1><a href="{{ route('login') }}">Login</a></h1>
        <p>Kullanıcı giriş yapmış durumda.</p>
        <strong><a href="{{ route('login') }}">Login</a></strong>
    </data>

@else
    @include('contact.guest')
    <data value="user_guest">
        <h1><a href="{{ route('login') }}">Login</a></h1>
        <p>Kullanıcı giriş yapmamış durumda.</p>
        <strong><a href="{{ route('login') }}">Login</a></strong>
    </data>
@endelse

    @include('contact.form')
    <data value="user_form">
        <h1><a href="{{ route('login') }}">Login</a></h1>
        <p>Kullanıcı formu görüntülüyor.</p>
        <strong><a href="{{ route('login') }}">Login</a></strong>
    </data>
@endif


</body>
</html>
