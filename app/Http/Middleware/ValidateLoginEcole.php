<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateLoginEcole
{
    public function handle(Request $request, Closure $next)
    {
        // Appeler une fonction de validation interne
        $this->validateLoginData($request);

        return $next($request);
    }

    public function validateLoginData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'mot_de_passe' => 'required|string',
        ]);

        if ($validator->fails()) {
            abort(response()->json([
                'success' => false,
                'message' => 'Les champs email et mot_de_passe sont requis.',
                'errors' => $validator->errors(),
            ], 422));
        }
    }
}
