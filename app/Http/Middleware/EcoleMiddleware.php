<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EcoleMiddleware
{
    /**
     * Middleware classique pour routes
     */
    public function handle(Request $request, Closure $next)
    {
        $this->validateLoginData($request);

        return $next($request);
    }

    /**
     * Fonction de validation que l'on peut appeler depuis le controller
     */
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
