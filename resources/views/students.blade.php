@extends('layout.app')

@section('content')
<div class="container">
    {{-- Mostrar el mensaje de error si existe --}}
    @if (session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif

    <h1>Lista de Estudiantes</h1>

    {{-- Mostrar los estudiantes si están disponibles --}}
    @if (isset($students) && count($students) > 0)
        <ul>
            @foreach ($students as $student)
                <li>{{ $student['name'] }} - {{ $student['email'] }}</li>
            @endforeach
        </ul>
    @else
        <p>No se han encontrado estudiantes.</p>
    @endif
</div>
@endsection
