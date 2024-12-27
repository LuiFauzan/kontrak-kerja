<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate QR Code Kontrak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-center text-accent">Form Buat Kontrak</h1>

                <!-- Form Section -->
                <form action="{{ route('qrcodes.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Karyawan</label>
                        <select name="employee_id"
                            class="select select-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="transition_no" class="block text-sm font-medium text-gray-800">Transition
                            No:</label>
                        <input type="text" name="transition_no" required
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="career_transition" class="block text-sm font-medium text-gray-800">Career
                            Transition:</label>
                        <input type="text" name="career_transition" required
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="transition_type" class="block text-sm font-medium text-gray-800">Transition
                            Type:</label>
                        <input type="text" name="transition_type" required
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-800">Position:</label>
                        <input type="text" name="position" required
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-800">Start Date:</label>
                        <input type="date" name="start_date" required
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-800">End Date:</label>
                        <input type="date" name="end_date" required
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-800">Duration:</label>
                        <input type="number" name="duration"
                            class="input input-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent">
                    </div>

                    <div>
                        <label for="remark" class="block text-sm font-medium text-gray-800">Remark:</label>
                        <textarea name="remark" rows="4"
                            class="textarea textarea-bordered w-full bg-gray-100 border-accent focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-accent text-white font-bold py-3 rounded-md hover:bg-accent-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                        Simpan
                    </button>
                </form>

                <!-- QR Code Section -->
                @isset($fileName)
                    <div class="mt-12 bg-gray-50 p-6 shadow-inner rounded-lg text-center">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-6">QR Code Kontrak</h3>
                        <div class="flex justify-center border border-accent p-6 rounded-lg shadow-md bg-white">
                            <img src="{{ asset('storage/qr-codes/' . $fileName) }}" alt="QR Code" class="w-64 h-64">
                        </div>

                        <div class="mt-6">
                            <div class="mt-6">
                                <!-- Tampilkan nama file QR Code -->
                                <p class="text-sm text-gray-600 mb-2">Nama File: <span
                                        class="font-semibold">{{ $fileName }}</span></p>

                                <!-- Tombol Download -->
                                <a href="{{ asset('storage/qr-codes/' . $fileName) }}" download="{{ $fileName }}"
                                    class="inline-block bg-accent text-white font-bold py-2 px-6 rounded-md hover:bg-accent-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                                    Download QR Code
                                </a>
                            </div>

                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</x-app-layout>
