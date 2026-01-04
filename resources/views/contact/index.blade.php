@extends('layouts.app')

@section('content')
<div class="contact-container">
    <h1>İletişim</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.send') }}" method="POST">
        @csrf

        <label>Ad Soyad</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name') <small>{{ $message }}</small> @enderror

        <label>E-posta</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email') <small>{{ $message }}</small> @enderror

        <label>Mesaj</label>
        <textarea name="message">{{ old('message') }}</textarea>
        @error('message') <small>{{ $message }}</small> @enderror

        <button type="submit">Gönder</button>
    </form>
</div>
@endsection
