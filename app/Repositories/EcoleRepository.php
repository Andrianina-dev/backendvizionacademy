<?php

namespace App\Repositories;

use App\Models\Ecole;
use Illuminate\Support\Facades\Log;  // ← Import ici aussi

class EcoleRepository
{
    public function findByEmail(string $email)
    {
        try {
            Log::info('findByEmail appelée', ['email' => $email]);

            $ecole = Ecole::where('email', $email)->first();

            Log::info('Résultat findByEmail', ['ecole' => $ecole ? $ecole->id_ecole : 'null']);

            return $ecole;
        } catch (\Exception $e) {
            Log::error('Erreur dans findByEmail', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function checkPassword($ecole, string $motDePasse): bool
    {
        Log::info('checkPassword', [
            'mot_de_passe_saisi' => $motDePasse,
            'mot_de_passe_bdd' => $ecole->mot_de_passe,
            'comparaison' => $motDePasse === $ecole->mot_de_passe
        ]);

        return $motDePasse === $ecole->mot_de_passe;
    }

    public function updateLastLogin(string $id_ecole): void
    {
        try {
            Ecole::where('id_ecole', $id_ecole)
                ->update(['date_derniere_connexion' => now()]);
        } catch (\Exception $e) {
            Log::error('Erreur updateLastLogin', [
                'id_ecole' => $id_ecole,
                'error' => $e->getMessage()
            ]);
        }
    }
}
