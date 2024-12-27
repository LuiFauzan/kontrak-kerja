<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan QR Code Kontrak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-center text-accent">Scan QR Code</h1>

                <!-- Camera Section -->
                <div id="reader" class="mb-6 w-full h-64 border rounded-lg shadow-md"></div>

                <!-- Hidden Form Section -->
                <form action="{{ route('qrcodes.save') }}" method="POST" id="qrCodeForm">
                    @csrf
                    <input type="hidden" name="data" id="qrCodeData">

                    <button type="submit"
                        class="w-full bg-accent text-white font-bold py-3 rounded-md hover:bg-accent-focus focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                        Simpan Data
                    </button>
                </form>

                <!-- Display QR Code Data -->
                <div id="qrDataDisplay" class="mt-6 text-center p-4 bg-gray-100 border rounded-lg hidden">
                    <h3 class="font-bold text-lg">Data QR Code:</h3>
                    <p id="qrCodeText" class="text-lg"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Tampilkan data QR Code yang dipindai
            document.getElementById('qrCodeText').innerText = decodedText;
            document.getElementById('qrDataDisplay').classList.remove('hidden');

            // Masukkan data ke input hidden untuk form
            document.getElementById('qrCodeData').value = decodedText;

            // Submit form secara otomatis setelah menampilkan data
            document.getElementById('qrCodeForm').submit();
        }

        function onScanFailure(error) {
            // Jika diperlukan, tangani kegagalan pemindaian
            console.warn(`Scan error: ${error}`);
        }

        // Inisialisasi pemindai QR Code
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</x-app-layout>
