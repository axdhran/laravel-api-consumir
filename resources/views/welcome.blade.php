<!-- resources/views/welcome.blade.php -->
@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Usuarios Registrados</h1>
    @if (isset($users) && count($users) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d-m-Y H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay usuarios disponibles.</p>
    @endif
</div>
@endsection
