<?php

namespace App\Repositories;

use App\Data\StudentData;
use App\Models\Student;

class studentRepository
{
    public function getStudentById(int $id, $relations = []): Student
    {
        return Student::with($relations)->findOrFail($id);
    }

    public function storeStudent(StudentData $studentsData): Student
    {
        $student = new Student;
        $student->fill($studentsData->toArray());
        $student->save();

        return $student;
    }

    public function updateStudent(StudentData $studentsData, Student $student)
    {
        $student->fill($studentsData->toArray());
        $student->update();

        return $student;
    }

    public function deleteStudent(Student $student): bool
    {
        return $student->delete();
    }
}