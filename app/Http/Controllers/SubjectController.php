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
        $this->subjectsRepository->storeSubject($request->validated());

        return Redirect::route('subjects.index');
    }

    public function update(UpdateSubjectRequest $request, int $id)
    {
        $this->subjectsRepository->updateSubject($request->validated(), $this->subjectsRepository->getSubjectById($id));

        return Redirect::route('subjects.index');
    }
}
