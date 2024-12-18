<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::all();
        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        return view('fees.create');
    }

    public function store(FeeRequest $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required',
        ]);

        Fee::create($request->validate());
        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }
}
