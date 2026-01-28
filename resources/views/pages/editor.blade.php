@extends('layouts.app')

@section('title', 'Laravel Editor')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Code Output -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-3">Output</h2>

            <div class="invalid-feedback" id="en">
                <pre class="code-block bg-gray-900 text-green-400 p-4 rounded" id="export">
                    <!-- JS ile doldurulacak -->
                </pre>
            </div>
        </div>

        <!-- Editor -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-3">Editor</h2>

            <div class="editor-link border rounded p-3 min-h-[300px]"
                 contenteditable="true"
                 virtualkeyboardpolicy="false">
            </div>
        </div>

    </div>
@endsection

@if(session('success'))
    <div class="{{ session('success') }}">
        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">Başarılı</a>
            <span class="navbar-text">
                {{ session('success') }}
            </span>
        </nav>
    </div>

    <div class="{{ section('scripts') }}">
        <script>
            setTimeout(function() {
                document.querySelector('.{{ session('success') }}').style.display = 'none';
            }, 3000);
        </script>

    </div>
@endif

@section('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection
