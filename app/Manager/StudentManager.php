<?php

namespace App\Manager;

use App\Data\StudentData;
use App\Data\SubjectData;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;

class StudentManager
{
    public StudentRepository $studentsRepository;

    public SubjectRepository $subjectsRepository;

    public function __construct(StudentRepository $studentsRepository, SubjectRepository $subjectsRepository)
    {
        $this->studentsRepository = $studentsRepository;

        $this->subjectsRepository = $subjectsRepository;
    }

    public function saveStudentWithRelations(StudentData $studentData): Student
    {

        $student = $this->studentsRepository->storeStudent($studentData);

        $subjectData = new SubjectData;
        $subjectData->id = $studentData->subject_id;
        $this->subjectsRepository->storeSubject($subjectData, $student);

        return $student;
    }
}
