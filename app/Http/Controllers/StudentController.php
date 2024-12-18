<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    public function __construct(private StudentRepository $studentsRepository) {}

    public function index()
    {
        return view('students.index');
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(StoreStudentRequest $request)
    {
        $this->studentsRepository->storeStudent($request->validated());

        return Redirect::route('students.index');
    }

    public function update(UpdateStudentRequest $request, int $id)
    {
        $this->studentsRepository->updateStudent($request->validated(), $this->studentsRepository->getStudentById($id));

        return Redirect::route('students.index');
    }
}
