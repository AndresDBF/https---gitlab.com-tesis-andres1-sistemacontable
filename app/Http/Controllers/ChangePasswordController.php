<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        // Validamos que se hayan enviado todos los datos necesarios
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Obtenemos el usuario autenticado
        $user = auth()->user();

        // Validamos que la contraseña actual sea correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        // Actualizamos la contraseña del usuario
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'La contraseña ha sido cambiada exitosamente');
    }
}