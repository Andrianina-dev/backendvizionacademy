<?php

namespace App\Services;

use App\Repositories\EcoleRepository;

class EcoleService
{
    protected $repository;

    public function __construct(EcoleRepository $repository)
    {
        $this->repository = $repository;
    }

  public function loginEcole(string $email, string $motDePasse): array
{
    // Test simple sans vérification de mot de passe
    $ecole = $this->repository->findByEmail($email);

    if (!$ecole) {
        return [
            'success' => false,
            'message' => 'Email non trouvé'
        ];
    }

    // Pour tester, acceptez n'importe quel mot de passe
    return [
        'success' => true,
        'message' => 'Connexion réussie (test)',
        'ecole' => [
            'id_ecole' => $ecole->id_ecole,
            'nom_ecole' => $ecole->nom_ecole,
            'email' => $ecole->email
        ]
    ];
}
}