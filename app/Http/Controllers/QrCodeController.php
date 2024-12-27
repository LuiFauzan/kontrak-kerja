<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;  // Tambahkan ini

class QrCodeController extends Controller
{
    public function create()
    {
        $employees = Employee::all(); // Menampilkan data karyawan
        return view('qrcode.create', compact('employees'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'transition_no' => 'required',
            'career_transition' => 'required|string',
            'transition_type' => 'required|string',
            'position' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'nullable|integer',
            'remark' => 'nullable|string',
        ]);

        // Gabungkan data untuk QR Code
        $qrData = implode(', ', $validated); // Data dipisahkan dengan koma

        // Generate QR Code dan simpan di folder storage
        $fileName = 'qr_code_' . $request->employee_id . '_' . now()->format('Ymd_His') . '.png';
        $path = storage_path('app/public/qr-codes/' . $fileName);
        QrCode::format('png')->size(250)->generate($qrData, $path);

        // Kirim data karyawan dan nama file QR ke view
        $employees = Employee::all();
        return view('qrcode.create', compact('employees', 'fileName', 'qrData'));
    }

    public function save(Request $request)
    {
        // Validasi data dari QR Code
        $request->validate([
            'data' => 'required|string', // Data QR Code dalam format string
        ]);

        // Mengambil data QR Code yang dipindai
        $decodedData = explode(', ', $request->data); // Memisahkan data yang di-implode

        // Debugging: periksa isi data QR Code
        Log::info('Decoded QR Code Data:', $decodedData);

        // Pastikan data QR Code memiliki format yang benar (misalnya 8 bagian data)
        if (count($decodedData) < 8) {
            return redirect()->back()->withErrors(['data' => 'Format data QR Code tidak valid!']);
        }

        // Menyusun data untuk disimpan ke tabel contracts
        $data = [
            'employee_id' => $decodedData[0],
            'transition_no' => $decodedData[1],
            'career_transition' => $decodedData[2],
            'transition_type' => $decodedData[3],
            'position' => $decodedData[4],
            'start_date' => $decodedData[5],
            'end_date' => $decodedData[6],
            'duration' => $decodedData[7],
            'remark' => $decodedData[8] ?? null, // Menggunakan null jika remark kosong
        ];

        // Validasi dan simpan data kontrak
        $validatedData = $this->validateContractData($data);

        // Simpan data ke tabel contracts
        Contract::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data kontrak berhasil disimpan!');
    }


    private function validateContractData(array $data)
    {
        // Menggunakan Validator untuk validasi
        $validator = Validator::make($data, [
            'employee_id' => 'required|exists:employees,id',
            'transition_no' => 'required|unique:contracts,transition_no',
            'career_transition' => 'required|string|max:255',
            'transition_type' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'nullable|integer',
            'remark' => 'nullable|string',
        ]);

        // Periksa apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return $validator->validated(); // Mengembalikan data yang tervalidasi
    }

    public function scan()
    {
        return view('qrcode.confirm');
    }
}
