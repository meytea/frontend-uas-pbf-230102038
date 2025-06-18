<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-blue-100">


    <div id="formModal" class="flex items-center justify-center bg-gray-800 bg-opacity-50 fixed inset-0">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4 text-center">Tambah Data Buku</h2>
            <form action="{{route('Buku.store')}}" method="post">
                @csrf

                <label class="block">Id</label>
                <input type="text" id="id" class="border w-full p-2 mb-2 rounded" name="id">

                <label class="block">Judul Buku</label>
                <input type="text" id="judul_buku" class="border w-full p-2 mb-2 rounded" name="judul_buku">

                <label class="block">Pengarang</label>
                <input type="text" id="pengarang" class="border w-full p-2 mb-2 rounded" name="pengarang">

                <label class="block">Penerbit</label>
                <input type="text" id="penerbit" class="border w-full p-2 mb-2 rounded" name="penerbit">

                <label class="block">Tahun_Terbit</label>
                <input type="text" id="tahun_terbit" class="border w-full p-2 mb-2 rounded" name="tahun_terbit">

              

                <div class="flex justify-center space-x-4 mt-4">
                    <a href="{{route('Buku.index')}}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200 active:scale-95">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="successModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <div class="flex justify-center items-center mb-4">
                <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500"></div>
            </div>
            <h2 class="text-lg font-bold mb-4">Data berhasil ditambahkan!</h2>
            <button onclick="redirectToDataDosen()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                OK
            </button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById("formModal").classList.add("hidden");
        }

        function showSuccessModal() {
            document.getElementById("successModal").classList.remove("hidden");
            setTimeout(() => {
                document.querySelector(".animate-spin").classList.add("hidden");
            }, 1000);
        }

        function redirectToDataDosen() {
            window.location.href = "Buku";
        }
    </script>

</body>

</html>