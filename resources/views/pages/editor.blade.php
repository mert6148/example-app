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
