<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahun dan Periode</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <!-- Card Container -->
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Form Pilih Tahun & Periode</h2>

        <form class="space-y-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Select Tahun -->
                <div class="w-full sm:w-1/3 px-4">
                    <label for="selectTahun" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tahun</label>
                    <select id="selectTahun"
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">--Pilih Tahun--</option>
                        <script>
                            const currentYear = new Date().getFullYear();
                            for (let year = currentYear; year >= 2000; year--) {
                                document.write(`<option value="${year}">${year}</option>`);
                            }
                        </script>
                    </select>
                </div>

                <!-- Input Periode Awal -->
                <div class="w-full sm:w-1/3 px-4">
                    <label for="periodeAwal" class="block text-sm font-medium text-gray-700 mb-2">Periode Awal</label>
                    <input type="text" id="periodeAwal" placeholder="Pilih tanggal awal"
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Input Periode Akhir -->
                <div class="w-full sm:w-1/3 px-4">
                    <label for="periodeAkhir" class="block text-sm font-medium text-gray-700 mb-2">Periode Akhir</label>
                    <input type="text" id="periodeAkhir" placeholder="Pilih tanggal akhir"
                        class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Clear Button and Submit Button -->
            <div class="flex justify-start space-x-4 mt-4">
                <button type="button" id="clearPeriode"
                    class="bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Clear
                    Periode</button>
                <button type="submit"
                    class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const periodeAwal = document.getElementById('periodeAwal');
        const periodeAkhir = document.getElementById('periodeAkhir');
        const selectTahun = document.getElementById('selectTahun');
        const clearPeriodeButton = document.getElementById('clearPeriode');

        // Inisialisasi flatpickr untuk periode awal dan akhir
        flatpickr(periodeAwal, {});
        flatpickr(periodeAkhir, {});

        selectTahun.addEventListener('change', function() {
            const selectedYear = selectTahun.value;

            if (selectedYear) {
                flatpickr(periodeAwal, {
                    dateFormat: 'Y-m-d',
                    minDate: `${selectedYear}-01-01`,
                    maxDate: `${selectedYear}-12-31`
                });

                flatpickr(periodeAkhir, {
                    dateFormat: 'Y-m-d',
                    minDate: `${selectedYear}-01-01`,
                    maxDate: `${selectedYear}-12-31`
                });
            } else {
                flatpickr(periodeAwal, {});
                flatpickr(periodeAkhir, {});
            }
        });

        // Clear the periode input fields
        clearPeriodeButton.addEventListener('click', function() {
            periodeAwal.value = ''; // Mengosongkan input Periode Awal
            periodeAkhir.value = ''; // Mengosongkan input Periode Akhir
        });
    </script>

</body>

</html>
