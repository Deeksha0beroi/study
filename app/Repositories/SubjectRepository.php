<?php

namespace App\Repositories;

use App\Data\SubjectData;
use App\Models\Subject;

class SubjectRepository
{
    public function getSubjectById(int $id, $relations = []): Subject
    {
        return Subject::with($relations)->findOrFail($id);
    }

    public function storeSubject(SubjectData $subjectsData): Subject
    {
        $subject = new Subject;
        $subject->fill($subjectsData->except('id')->toArray());
        $subject->name = $subjectsData->name;
        $subject->save();

        return $subject;
    }

    public function updateSubject(SubjectData $subjectsData, Subject $subject)
    {
        $subject->fill($subjectsData->except('id')->toArray());
        $subject->update();

        return $subject;
    }

    public function deleteSubject(Subject $subject): bool
    {
        return $subject->delete();
    }

    public function attachStudents(Subject $subject, array $studentIds)
    {
        $subject->students()->sync($studentIds);
    }
}
