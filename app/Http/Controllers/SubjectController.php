<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Repositories\SubjectRepository;
use Illuminate\Support\Facades\Redirect;

class SubjectController extends Controller
{
    public function __construct(private SubjectRepository $subjectsRepository) {}

    public function index()
    {
        return view('subjects.index');
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(StoreSubjectRequest $request)
    {
        $subject = $this->subjectsRepository->storeSubject($request->validated());
        $this->subjectsRepository->attachStudents($subject, $request->input('student_ids', []));

        return Redirect::route('subjects.index');
    }

    public function update(UpdateSubjectRequest $request, int $id)
    {
        $subject = $this->subjectsRepository->updateSubject($request->validated(), $this->subjectsRepository->getSubjectById($id));
        $this->subjectsRepository->attachStudents($subject, $request->input('student_ids', []));

        return Redirect::route('subjects.index');
    }
}
