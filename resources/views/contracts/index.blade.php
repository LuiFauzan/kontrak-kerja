<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kontrak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                    <label for="create-modal" class="btn btn-outline btn-accent mb-4">Tambah Kontrak</label>
                    <!-- Table Data Kontrak -->
                    <table class="table w-full">
                        <thead>
                            <tr class="bg-accent text-black">
                                <th>#</th>
                                <th>Nomor Transisi</th>
                                <th>Nama Karyawan</th>
                                <th>Transisi Karir</th>
                                <th>Posisi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                                <th>Lama Kontrak(Bulan)</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $contract)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contract->transition_no }}</td>
                                    <td>{{ $contract->employee->name }}</td>
                                    <td>{{ $contract->career_transition }}</td>
                                    <td>{{ $contract->position }}</td>
                                    <td>{{ $contract->start_date }}</td>
                                    <td>{{ $contract->end_date }}</td>
                                    <td>{{ $contract->duration }}</td>
                                    <td>{{ $contract->remark }}</td>
                                    <td>
                                        <!-- Button untuk membuka modal Edit -->
                                        <label for="edit-modal-{{ $contract->id }}"
                                            class="btn btn-warning btn-sm">Edit</label>
                                        <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <input type="checkbox" id="create-modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Tambah Kontrak</h3>
            <form action="{{ route('contracts.store') }}" method="POST">
                @csrf
                <!-- Form Fields -->
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Karyawan</span>
                    </label>
                    <select name="employee_id" class="select select-bordered w-full" id="employeeSelect">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Nomor Transisi</span>
                    </label>
                    <input type="text" name="transition_no" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Transisi Karir</span>
                    </label>
                    <input type="text" name="career_transition" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Jenis Transisi</span>
                    </label>
                    <input type="text" name="transition_type" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Posisi</span>
                    </label>
                    <input type="text" name="position" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Tanggal Mulai</span>
                    </label>
                    <input type="date" name="start_date" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Tanggal Akhir</span>
                    </label>
                    <input type="date" name="end_date" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mb-2">
                    <label class="label">
                        <span class="label-text">Catatan</span>
                    </label>
                    <textarea name="remark" class="textarea textarea-bordered w-full"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="modal-action">
                    <label for="create-modal" class="btn btn-secondary">Batal</label>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach ($contracts as $contract)
        <input type="checkbox" id="edit-modal-{{ $contract->id }}" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Edit Kontrak</h3>
                <form action="{{ route('contracts.update', $contract->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Form Fields -->
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Karyawan</span>
                        </label>
                        <select name="employee_id" class="select select-bordered w-full">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ $contract->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Nomor Transisi</span>
                        </label>
                        <input type="text" name="transition_no" class="input input-bordered w-full"
                            value="{{ $contract->transition_no }}" required />
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Transisi Karir</span>
                        </label>
                        <input type="text" name="career_transition" class="input input-bordered w-full"
                            value="{{ $contract->career_transition }}" required />
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Jenis Transisi</span>
                        </label>
                        <input type="text" name="transition_type" class="input input-bordered w-full"
                            value="{{ $contract->transition_type }}" required />
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Posisi</span>
                        </label>
                        <input type="text" name="position" class="input input-bordered w-full"
                            value="{{ $contract->position }}" required />
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Tanggal Mulai</span>
                        </label>
                        <input type="date" name="start_date" class="input input-bordered w-full"
                            value="{{ $contract->start_date }}" required />
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Tanggal Akhir</span>
                        </label>
                        <input type="date" name="end_date" class="input input-bordered w-full"
                            value="{{ $contract->end_date }}" required />
                    </div>
                    <div class="form-control mb-2">
                        <label class="label">
                            <span class="label-text">Catatan</span>
                        </label>
                        <textarea name="remark" class="textarea textarea-bordered w-full">{{ $contract->remark }}</textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-action">
                        <label for="edit-modal-{{ $contract->id }}" class="btn btn-secondary">Batal</label>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    <script>
        $(document).ready(function() {
            $('#employeeSelect').select2({
                placeholder: "Pilih Karyawan",
                allowClear: true
            });
        });
    </script>

</x-app-layout>
