<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate QR Code Kontrak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Form Generate QR Code</h3>

                    <!-- Form untuk generate QR Code -->
                    <form action="{{ route('contracts.generateQr') }}" method="POST" class="text-white">
                        @csrf
                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Pilih Karyawan</span>
                            </label>
                            <select name="employee_id" class="select select-bordered w-full" required>
                                <option value="" disabled selected>Pilih karyawan...</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Nomor Transisi</span>
                            </label>
                            <input type="text" name="transition_no" class="input input-bordered w-full"
                                placeholder="Contoh: TRX001" required>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Jenis Transisi</span>
                            </label>
                            <select name="career_transition" class="select select-bordered w-full" required>
                                <option value="" disabled selected>Pilih jenis transisi...</option>
                                <option value="Promosi">Promosi</option>
                                <option value="Rotasi">Rotasi</option>
                                <option value="Perpanjangan">Perpanjangan</option>
                                <option value="Penurunan Jabatan">Penurunan Jabatan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Jenis Kontrak</span>
                            </label>
                            <select name="transition_type" class="select select-bordered w-full" required>
                                <option value="" disabled selected>Pilih jenis kontrak...</option>
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Magang">Magang</option>
                                <option value="Outsourcing">Outsourcing</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Posisi</span>
                            </label>
                            <input type="text" name="position" class="input input-bordered w-full"
                                placeholder="Contoh: Manager IT" required>
                        </div>

                        <!-- Input Tanggal Mulai dan Akhir -->
                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Tanggal Mulai Kontrak</span>
                            </label>
                            <input type="date" id="start_date" name="start_date" class="input input-bordered w-full"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Tanggal Akhir Kontrak</span>
                            </label>
                            <input type="date" id="end_date" name="end_date" class="input input-bordered w-full"
                                required>
                        </div>

                        <!-- Input Durasi Kontrak -->
                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Durasi Kontrak (Bulan)</span>
                            </label>
                            <input type="number" id="duration" name="duration" class="input input-bordered w-full"
                                placeholder="Contoh: 12" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Catatan Tambahan</span>
                            </label>
                            <textarea name="remark" class="textarea textarea-bordered w-full" placeholder="Tambahkan catatan jika ada..."
                                rows="4"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Generate QR Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Menghitung Durasi Kontrak -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const durationInput = document.getElementById('duration');

            // Fungsi untuk menghitung durasi
            function calculateDuration() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (!isNaN(startDate) && !isNaN(endDate) && endDate > startDate) {
                    const diffTime = Math.abs(endDate - startDate);
                    const diffMonths = Math.ceil(diffTime / (1000 * 60 * 60 * 24 * 30)); // Konversi ke bulan
                    durationInput.value = diffMonths;
                } else {
                    durationInput.value = '';
                }
            }

            // Event listener untuk perhitungan otomatis
            startDateInput.addEventListener('change', calculateDuration);
            endDateInput.addEventListener('change', calculateDuration);
        });
    </script>
</x-app-layout>
