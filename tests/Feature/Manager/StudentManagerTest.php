<?php

namespace Tests\Feature\Manager;

use App\Data\FeeData;
use App\Data\StudentData;
use App\Data\SubjectData;
use App\Manager\StudentManager;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagerTest extends TestCase
{
    use RefreshDatabase;

    private StudentManager $studentManager;

    private StudentRepository $studentRepository;

    private SubjectRepository $subjectRepository;

    private FeeRepository $feesRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentRepository = new StudentRepository;

        $this->subjectRepository = new SubjectRepository;

        $this->feesRepository = new FeeRepository;

        $this->studentManager = new StudentManager(
            $this->studentRepository,
            $this->subjectRepository,
            $this->feesRepository,
        );
    }

    public function test_save_student_with_relations()
    {
        $studentData = new StudentData;
        $studentData->name = 'John Doe';
        $studentData->email = 'johndoe@gmail.com';

        $subjectData = new SubjectData;
        $subjectData->name = 'Mathematics';
        $subject = $this->subjectRepository->storeSubject($subjectData);
        $studentData->subject_id = $subject->id;

        $student = $this->studentManager->saveStudentWithRelations($studentData);

        $this->assertEquals($studentData->name, $student->name);
        $this->assertEquals($studentData->email, $student->email);
        $this->assertEquals($studentData->subject_id, $student->subject_id);

        $this->assertDatabaseHas('students', [
            'name' => $studentData->name,
            'email' => $studentData->email,
            'subject_id' => $studentData->subject_id,
        ]);

        $this->assertDatabaseHas('subjects', [
            'id' => $studentData->subject_id,
        ]);

    }

    public function test_save_student_with_fees()
    {
        $studentData = new StudentData;
        $studentData->name = 'John Doe';
        $studentData->email = 'johndoe@gmail.com';

        $subjectData = new SubjectData;
        $subjectData->name = 'Mathematics';
        $subject = $this->subjectRepository->storeSubject($subjectData);
        $studentData->subject_id = $subject->id;

        $feesData = new FeeData;
        $feesData->amount = 1000;
        $feesData->due_date = '2022-12-12';
        $fee = $this->feesRepository->storeFee($feesData);

        $studentData->fee_id = $fee->id;

        $student = $this->studentManager->saveStudentWithRelations($studentData);

        $this->assertEquals($studentData->name, $student->name);
        $this->assertEquals($studentData->email, $student->email);
        $this->assertEquals($studentData->subject_id, $student->subject_id);
        $this->assertEquals($studentData->fee_id, $student->fee_id);

        $this->assertDatabaseHas('students', [
            'name' => $studentData->name,
            'email' => $studentData->email,
            'subject_id' => $studentData->subject_id,
            'fee_id' => $fee->id,
        ]);

        $this->assertDatabaseHas('subjects', [
            'id' => $studentData->subject_id,
        ]);

        $this->assertDatabaseHas('fees', [
            'id' => $fee->id,
        ]);

    }
}
