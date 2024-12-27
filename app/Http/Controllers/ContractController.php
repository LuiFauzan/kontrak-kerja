<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('employee')->get(); // Ambil semua data kontrak beserta data karyawan
        $employees = Employee::all(); // Ambil semua data karyawan untuk dropdown
        return view('contracts.index', compact('contracts', 'employees'));
    }

    /**
     * Menyimpan kontrak baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'transition_no' => 'required|string|max:255',
            'career_transition' => 'required|string|max:255',
            'transition_type' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'remark' => 'nullable|string',
        ]);

        // Hitung duration (lama kontrak dalam bulan)
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $duration = $startDate->diffInMonths($endDate);

        Contract::create([
            'employee_id' => $request->employee_id,
            'transition_no' => $request->transition_no,
            'career_transition' => $request->career_transition,
            'transition_type' => $request->transition_type,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $duration,
            'remark' => $request->remark,
        ]);

        return redirect()->route('contracts.index')->with('success', 'Kontrak berhasil ditambahkan!');
    }

    /**
     * Memperbarui data kontrak.
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'transition_no' => 'required|string|max:255',
            'career_transition' => 'required|string|max:255',
            'transition_type' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'remark' => 'nullable|string',
        ]);

        // Hitung duration (lama kontrak dalam bulan)
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $duration = $startDate->diffInMonths($endDate);

        $contract->update([
            'employee_id' => $request->employee_id,
            'transition_no' => $request->transition_no,
            'career_transition' => $request->career_transition,
            'transition_type' => $request->transition_type,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $duration,
            'remark' => $request->remark,
        ]);

        return redirect()->route('contracts.index')->with('success', 'Kontrak berhasil diperbarui!');
    }

    /**
     * Menghapus kontrak.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Kontrak berhasil dihapus.');
    }

    // generate qrcode

    public function toQr()
    {
        $employees = Employee::all();
        return view('contracts.qrcode', compact('employees'));
    }
    
}
