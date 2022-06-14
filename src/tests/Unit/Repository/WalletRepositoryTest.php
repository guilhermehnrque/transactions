<?php

namespace Tests\Unit\Repository;

use App\Models\User;
use App\Models\Wallet;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class WalletRepositoryTest extends TestCase
{
    private LegacyMockInterface|Wallet|Mockery\MockInterface $modelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = Mockery::mock(Wallet::class);
    }

    public function test_should_create_wallet()
    {
        $data = [
            'current_balance' => 0,
            'status' => 'active',
            'user_id' => '1',
        ];

        $this->modelMock->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturnSelf();

        $repository = new WalletRepository($this->modelMock);
        $response = $repository->create($data);

        self::assertInstanceOf(Wallet::class, $response);
    }

    public function test_should_get_user_wallet()
    {
        $userId = 1;

        $this->modelMock->shouldReceive('where')
            ->withArgs(['user_id', $userId])
            ->once()
            ->andReturnSelf();
        $this->modelMock->shouldReceive('first')
            ->withNoArgs()
            ->once()
            ->andReturn(new Wallet([
                'current_balance' => 100,
                'status' => 'active',
                'user_id' => '1',
            ]));

        $repository = new WalletRepository($this->modelMock);
        $response = $repository->getUserWallet($userId);

        self::assertInstanceOf(Wallet::class, $response);
    }

    public function test_should_update_user_balance()
    {
        $userId = 1;
        $walletId = 1;
        $newBalance = 266.77;

        $this->modelMock->shouldReceive('where')
            ->withArgs(['id', $walletId])
            ->once()
            ->andReturnSelf();

        $this->modelMock->shouldReceive('where')
            ->withArgs(['user_id', $userId])
            ->once()
            ->andReturnSelf();

        $this->modelMock->shouldReceive('update')
            ->withArgs([['current_balance' => $newBalance]])
            ->once()
            ->andReturnSelf();

        $repository = new WalletRepository($this->modelMock);
        $response = $repository->updateBalance(
            walletId: $walletId,
            userId: $userId,
            newBalance: $newBalance
        );

        self::assertInstanceOf(Wallet::class, $response);
    }
}
