<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function registerUser(array $data)
    {
        $userExists = $this->userRepository->getUserByCPForCNPJ($data['cpf_cnpj']);

        if (!empty($userExists)) {
            throw new Exception('Usuário já registrado no sistema', 400);
        }

        try {
           return $this->userRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Erro ao criar usuário', 422);
        }

    }


}
