<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $attributes)
    {
        return $this->user->create($attributes);
    }

    public function getById(int $id)
    {
        return $this->user->find($id);
    }

    public function getUserByCPForCNPJ(int $cpfCnpj)
    {
        return $this->user->where('cpf_cnpj', $cpfCnpj)->get();
    }
}
