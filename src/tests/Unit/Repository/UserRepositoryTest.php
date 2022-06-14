<?php

namespace Tests\Unit\Repository;

use App\Models\User;
use App\Repositories\UserRepository;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private LegacyMockInterface|User|Mockery\MockInterface $modelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = Mockery::mock(User::class);
    }

    public function test_should_create_user()
    {
        $data = [
            'name' => 'Guiro Pereira',
            'cpf_cnpj' => 123456789,
            'email' => 'guiro@guiro.com',
            'password' => 'guiro123',
            'type' => 'lojista'
        ];

        $this->modelMock->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturnSelf();

        $repository = new UserRepository($this->modelMock);
        $response = $repository->create($data);

        self::assertInstanceOf(User::class, $response);
    }

    public function test_should_get_user()
    {
        $userId = 1;

        $this->modelMock->shouldReceive('find')
            ->with($userId)
            ->once()
            ->andReturn(new User([
                'id' => 1,
                'name' => 'Guiro',
                'email' => 'guiro@guiro.com',
                'type' => 'lojista'
            ]));

        $repository = new UserRepository($this->modelMock);
        $response = $repository->getById($userId);

        self::assertInstanceOf(User::class, $response);
    }

    public function test_should_get_user_by_cpf_or_cnpj()
    {
        $cpfCnpj = 1;

        $this->modelMock->shouldReceive('where')
            ->withArgs(['cpf_cnpj', $cpfCnpj])
            ->once()
            ->andReturnSelf();

        $this->modelMock->shouldReceive('get')
            ->withNoArgs()
            ->once()
            ->andReturn(new User([
                    'id' => 1,
                    'name' => 'Guiro',
                    'email' => 'guiro@guiro.com',
                    'type' => 'lojista'
                ])
            );

        $repository = new UserRepository($this->modelMock);
        $response = $repository->getUserByCPForCNPJ($cpfCnpj);

        self::assertInstanceOf(User::class, $response);
    }
}
