<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'employee_no' => 'required|unique:employees,employee_no|max:20',
            'name' => 'required|max:255',
            'remark' => 'nullable|max:500',
        ]);

        Employee::create($request->all()); // Menyimpan data baru ke database

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_no' => 'required|unique:employees,employee_no,' . $employee->id . '|max:20',
            'name' => 'required|max:255',
            'remark' => 'nullable|max:500',
        ]);

        $employee->update($request->all()); // Mengupdate data karyawan

        return redirect()->back()->with('success', 'Karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete(); // Menghapus data karyawan

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dihapus!');
    }
}
