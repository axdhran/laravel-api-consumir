<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        try {
            // URL del endpoint de la API
            $apiUrl = 'http://127.0.0.1:8000/api/users';

            $response = Http::withToken('tu_token_aqui')->get($apiUrl);
            // Realiza la solicitud GET a la API
            $response = Http::get($apiUrl);

            // Lanza una excepción si la solicitud falla
            $response->throw();

            // Extrae los datos de la respuesta
            $users = $response->json()['users'];

            // Retorna los datos a la vista
            return view('welcome', compact('users'));
        } catch (RequestException $e) {
            // Manejo de errores
            return back()->withErrors('No se pudo conectar con la API: ' . $e->getMessage());
        }
    }

    public function estudiantes(Request $request)
    {
        // Verificar si el token existe en la sesión
        $token = session('sanctum_token'); // O también puedes usar Cookie::get('sanctum_token');

        if (!$token) {
            // Si el token no existe, redirige al login con un mensaje de error
            return redirect()->route('login')->with('error', 'Por favor, inicie sesión para continuar.');
        }

        // URL del endpoint de la API
        $apiUrl = 'http://127.0.0.1:8000/api/students';

        // Realizar la solicitud GET a la API con el token de autenticación en el encabezado
        $response = Http::withToken($token)->get($apiUrl);

        // Verifica si la respuesta es exitosa
        if ($response->successful()) {
            // Obtener los estudiantes desde la respuesta
            $students = $response->json()['students'] ?? []; // Accede a 'students'

            // Retorna la vista con los estudiantes
            return view('students', compact('students'));
        }

        // Si la solicitud falla (por ejemplo, 401), maneja el error
        return redirect()->route('login')->with('error', 'No se pudo obtener la lista de estudiantes. Por favor, intente nuevamente.');
    }

}
