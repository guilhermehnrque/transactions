<?php

namespace Tests\Unit\Repository;

use App\Models\Transaction;
use App\Repositories\TransactionsRepository;
use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

class TransactionsRepositoryTest extends TestCase
{
    private LegacyMockInterface|Transaction|Mockery\MockInterface $modelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = Mockery::mock(Transaction::class);
    }

    public function test_should_create_transaction()
    {
        $data = [
            'value' => 0,
            'status' => 'active',
            'payer' => '1',
            'payee' => 2
        ];

        $this->modelMock->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturnSelf();

        $repository = new TransactionsRepository($this->modelMock);
        $response = $repository->createTransaction($data);

        self::assertInstanceOf(Transaction::class, $response);
    }

    public function test_should_get_transaction()
    {
        $transactionId = 1;
        $data = [
            'id' => 1,
            'value' => 2000,
            'status' => 'active',
            'payer' => '1',
            'payee' => 2
        ];

        $this->modelMock->shouldReceive('find')
            ->with($transactionId)
            ->once()
            ->andReturn(new Transaction($data));

        $repository = new TransactionsRepository($this->modelMock);
        $response = $repository->getTransactionById($transactionId);

        self::assertInstanceOf(Transaction::class, $response);
    }

}
