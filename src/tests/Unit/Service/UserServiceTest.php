<?php

namespace Tests\Unit\Service;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Exception;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private LegacyMockInterface|UserRepository|Mockery\MockInterface $modelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = Mockery::mock(UserRepository::class);
    }

    /**
     * @throws Exception
     */
    public function test_should_create_user()
    {
        $data = [
            'name' => 'Guiro Pereira',
            'cpf_cnpj' => 123456789,
            'email' => 'guiro@guiro.com',
            'password' => 'guiro123',
            'type' => 'lojista'
        ];

        $this->modelMock->shouldReceive('getUserByCPForCNPJ')
            ->with($data['cpf_cnpj'])
            ->once()
            ->andReturnNull();

        $this->modelMock->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn(new User($data));

        $service = new UserService($this->modelMock);
        $response = $service->registerUser($data);

        self::assertInstanceOf(User::class, $response);
    }

    /**
     * @throws Exception
     */
    public function test_should_not_create_user_user_already_exists_and_throw_exception()
    {
        $data = [
            'name' => 'Guiro Pereira',
            'cpf_cnpj' => 123456789,
            'email' => 'guiro@guiro.com',
            'password' => 'guiro123',
            'type' => 'lojista'
        ];

        $this->modelMock->shouldReceive('getUserByCPForCNPJ')
            ->with($data['cpf_cnpj'])
            ->once()
            ->andReturn(new User($data));

        $this->expectException(Exception::class);

        $service = new UserService($this->modelMock);
        $service->registerUser($data);
    }

    /**
     * @throws Exception
     */
    public function test_should_not_create_user_and_throw_exception()
    {
        $data = [
            'name' => 'Guiro Pereira',
            'cpf_cnpj' => 123456789,
            'email' => 'guiro@guiro.com',
            'password' => 'guiro123',
            'type' => 'lojista'
        ];

        $this->modelMock->shouldReceive('getUserByCPForCNPJ')
            ->with($data['cpf_cnpj'])
            ->once()
            ->andReturnNull();

        $this->modelMock->shouldReceive('create')
            ->with($data)
            ->once()
            ->andThrows(Exception::class, 'Erro ao criar usuário');

        $this->expectException(Exception::class);

        $service = new UserService($this->modelMock);
        $service->registerUser($data);
    }
}
