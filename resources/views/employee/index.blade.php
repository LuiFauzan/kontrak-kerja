<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Button to open the "Tambah Karyawan" modal -->
                <label for="create-modal" class="btn btn-outline btn-accent mb-4">
                    Tambah Karyawan
                </label>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table w-full border border-gray-300">
                        <thead>
                            <tr class="bg-accent text-white">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Nomor Karyawan</th>
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Catatan</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr class="hover:bg-gray-100 text-gray-800">
                                    <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4">{{ $employee->employee_no }}</td>
                                    <td class="py-3 px-4">{{ $employee->name }}</td>
                                    <td class="py-3 px-4">{{ $employee->remark ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex gap-2">
                                            <!-- Edit button -->
                                            <label for="edit-modal-{{ $employee->id }}" class="btn btn-sm btn-warning hover:shadow-lg">
                                                Edit
                                            </label>

                                            <!-- Delete button -->
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error hover:shadow-lg">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <input type="checkbox" id="edit-modal-{{ $employee->id }}" class="modal-toggle" />
                                <div class="modal">
                                    <div class="modal-box">
                                        <h3 class="font-bold text-lg mb-4">Edit Karyawan</h3>
                                        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4">
                                                <label for="employee_no" class="block font-bold">Nomor Karyawan</label>
                                                <input type="text" name="employee_no" id="employee_no" class="input input-bordered w-full" value="{{ old('employee_no', $employee->employee_no) }}" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="name" class="block font-bold">Nama Karyawan</label>
                                                <input type="text" name="name" id="name" class="input input-bordered w-full" value="{{ old('name', $employee->name) }}" required>
                                            </div>

                                            <div class="mb-4">
                                                <label for="remark" class="block font-bold">Catatan</label>
                                                <textarea name="remark" id="remark" class="textarea textarea-bordered w-full">{{ old('remark', $employee->remark) }}</textarea>
                                            </div>

                                            <div class="modal-action">
                                                <button type="submit" class="btn btn-primary hover:shadow-lg">Simpan</button>
                                                <label for="edit-modal-{{ $employee->id }}" class="btn">Batal</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-3">Tidak ada data karyawan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <input type="checkbox" id="create-modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Tambah Karyawan</h3>
            <form action="" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="employee_no" class="block font-bold">Nomor Karyawan</label>
                    <input type="text" name="employee_no" id="employee_no" class="input input-bordered w-full" value="{{ old('employee_no') }}" required>
                </div>

                <div class="mb-4">
                    <label for="name" class="block font-bold">Nama Karyawan</label>
                    <input type="text" name="name" id="name" class="input input-bordered w-full" value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label for="remark" class="block font-bold">Catatan</label>
                    <textarea name="remark" id="remark" class="textarea textarea-bordered w-full">{{ old('remark') }}</textarea>
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary hover:shadow-lg">Simpan</button>
                    <label for="create-modal" class="btn">Batal</label>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>