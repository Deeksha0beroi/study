<?php

namespace App\Manager;

use App\Data\FeeData;
use App\Data\StudentData;
use App\Data\SubjectData;
use App\Models\Student;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;

class StudentManager
{
    public StudentRepository $studentsRepository;

    public SubjectRepository $subjectsRepository;

    public FeeRepository $feesRepository;

    public function __construct(StudentRepository $studentsRepository, SubjectRepository $subjectsRepository, FeeRepository $feesRepository)
    {
        $this->studentsRepository = $studentsRepository;

        $this->subjectsRepository = $subjectsRepository;

        $this->feesRepository = $feesRepository;
    }

    public function saveStudentWithRelations(StudentData $studentData): Student
    {

        $student = $this->studentsRepository->storeStudent($studentData);

        $subjectData = new SubjectData;
        $subjectData->id = $studentData->subject_id;
        $this->subjectsRepository->storeSubject($subjectData, $student);

        return $student;
    }

    public function saveStudentWithFees(StudentData $studentData): Student
    {
        $student = $this->studentsRepository->storeStudent($studentData);

        $feesData = new FeeData;
        $feesData->id = $studentData->fee_id;
        $this->feesRepository->storeFee($feesData, $student);

        return $student;
    }
}
