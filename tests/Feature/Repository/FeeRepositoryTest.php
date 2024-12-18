<?php

namespace Tests\Feature\Repositories;

use App\Models\Fee;
use App\Repositories\FeeRepository;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $tenancy = true;

    private FeeRepository $fees;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fees = app(FeeRepository::class);
    }

    public function test_get_fee_by_id(): void
    {
        $fees = Fee::factory()->create();

        $this->assertEquals(Fee::class, get_class($this->fees->getFeeById($fees->id)));
    }

    public function test_store_fee(): void
    {
        $fee = Fee::factory()->make();

        $this->fees->storeFee($fee->getData());

        $this->assertDatabaseHas((new Fee)->getTable(), [
            'amount' => $fee->position,
            'due_date' => $fee->due_date,
        ]);
    }

    public function test_update_fee(): void
    {
        $fee = Fee::factory()->create();

        $fee->amount = '5000';

        $this->fees->updateFee($fee->getData(), $fee);

        $this->assertDatabaseHas((new Fee)->getTable(), [
            'id' => $fee->id,
            'amount' => '5000',
        ]);
    }

    public function test_delete_fee(): void
    {
        $fee = Fee::factory()->create();

        $result = $this->fees->deleteFee($fee);

        $this->assertTrue($result);
    }
}
