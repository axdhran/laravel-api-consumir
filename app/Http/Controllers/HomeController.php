<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        // Verificar si el token existe en la sesión
        $token = session('sanctum_token'); // O también puedes usar Cookie::get('sanctum_token');

        if (!$token) {
            // Si el token no existe, redirige al login con un mensaje de error
            return redirect()->route('login')->with('error', 'Por favor, inicie sesión para continuar.');
        }

        // URL del endpoint de la API
        $apiUrl = 'http://127.0.0.1:8000/api/users';

        // Realizar la solicitud GET a la API con el token de autenticación en el encabezado
        $response = Http::withToken($token)->get($apiUrl);

        // Verifica si la respuesta es exitosa
        if ($response->successful()) {
            // Obtener los estudiantes desde la respuesta
            $user = $response->json()['users'] ?? []; // Accede a 'users'

            // Retorna la vista con los usuarios
            return view('welcome', compact('user'));
        }

        // Si la solicitud falla (por ejemplo, 401), maneja el error
        return redirect()->route('login')->with('error', 'No se pudo obtener la lista de estudiantes. Por favor, intente nuevamente.');
    }
    

    // public function estudiantes(Request $request)
    // {
    //     // Verificar si el token existe en la sesión
    //     $token = session('sanctum_token'); // O también puedes usar Cookie::get('sanctum_token');

    //     if (!$token) {
    //         // Si el token no existe, redirige al login con un mensaje de error
    //         return redirect()->route('login')->with('error', 'Por favor, inicie sesión para continuar.');
    //     }

    //     // URL del endpoint de la API
    //     $apiUrl = 'http://127.0.0.1:8000/api/students';

    //     // Realizar la solicitud GET a la API con el token de autenticación en el encabezado
    //     $response = Http::withToken($token)->get($apiUrl);

    //     // Verifica si la respuesta es exitosa
    //     if ($response->successful()) {
    //         // Obtener los estudiantes desde la respuesta
    //         $students = $response->json()['students'] ?? []; // Accede a 'students'

    //         // Retorna la vista con los estudiantes
    //         return view('students', compact('students'));
    //     }

    //     // Si la solicitud falla (por ejemplo, 401), maneja el error
    //     return redirect()->route('login')->with('error', 'No se pudo obtener la lista de estudiantes. Por favor, intente nuevamente.');
    // }

}
