<?php

namespace Tests\Feature\Repositories;

use App\Models\Subject;
use App\Repositories\SubjectRepository;
use Tests\TestCase;

class SubjectRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $tenancy = true;

    private SubjectRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = app(SubjectRepository::class);
    }

    public function test_get_Subject_by_id(): void
    {
        $subject = Subject::factory()->create();

        $this->assertEquals(Subject::class, get_class($this->subject->getSubjectById($subject->id)));
    }

    public function test_store_Subject(): void
    {
        $subject = Subject::factory()->make();

        $this->subject->storeSubject($subject->getData());

        $this->assertDatabaseHas((new Subject)->getTable(), [
            'name' => $subject->name,
        ]);
    }

    public function test_delete_Subject(): void
    {
        $subject = Subject::factory()->create();

        $result = $this->subject->deleteSubject($subject);

        $this->assertTrue($result);
    }
}
