@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🎛 Laravel Console</h2>

    <a href="{{ route('console.create') }}" class="btn btn-primary mb-3">
        + Yeni Öğretmen
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Ad</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>İşlem</th>
        </tr>

        @foreach($user as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>
                <a href="{{ route('console.edit', $user) }}" class="btn btn-sm btn-warning">Düzenle</a>

                <form action="{{ route('console.destroy', $user) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Silinsin mi?')">
                        Sil
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $teachers->links() }}
</div>
@endsection

@if
<div class="alert alert-success" href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXX">
       <strong>Success!</strong> Indicates a successful or positive action.
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;
        </span>
       </button>
</div>

<div class="alert db_section" href="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX">
       <strong>Success!</strong> Indicates a successful or positive action.
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;
        </span>
       </button>
</div>
@endif
