<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Company;
use App\Http\Requests\StoreEmployeeRequest; 

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::paginate(1);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create', Employee::class);
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
        $this->authorize('create', Employee::class);
        Employee::create($request->all());
        return redirect()->route('employees.index')->with(['message' => 'Employee added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Employee::class);
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeRequest $request, $id)
    {
        //
        $this->authorize('update', Employee::class);
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return redirect()->route('employees.index')->with(['message' => 'Employee updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Employee::class);
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with(['message' => 'Employee deleted successfully']);
    }

    public function massDestroy(Request $request)
    {
        $this->authorize('delete', Employee::class);
        $employees = explode(',', $request->input('ids'));
        foreach ($employees as $employee_id) {
            $employee = Employee::findOrFail($employee_id);
            $employee->delete();
        }
        return redirect()->route('employees.index')->with(['message' => 'Employees deleted successfully']);
    }
}
