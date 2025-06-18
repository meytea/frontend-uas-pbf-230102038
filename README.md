# Tutorial Frontend Laravel Sistem Bimbingan Tugas AKhir(CRUD API CodeIgniter 4)
Sistem ini dibuat untuk memudahkan proses bimbingan Tugas Akhir antara mahasiswa dan dosen secara terintegrasi. Aplikasi ini dibangun menggunakan framework Laravel untuk sisi frontend dan mengonsumsi data dari REST API backend.

---

## 🛠️ Teknologi

- **Laravel 12**
- **PHP 8.2**
- **Tailwind CSS**
- **Laravel HTTP Client**
- **REST API (backend terpisah)**

---

## 🖥️ Database
**Import database**
**🔗 https://github.com/tiaradinda020/PBF_KELOMPOK3_BIMBINGAN.git **

### 📦 BACKEND
1.  Cara Clone Repository
   git clone https://github.com/AnayAilirpa/PBF_BackendSBTA.git <br>
   cd SBTA-Backend
2. Install Dependency CodeIgniter
   composer install
3. Copy File Environment
   cp .env.example .env
4. Menjalankan CodeIgniter
   php spark serve
5.  Cek EndPoint menggunakan Postman

### 🎨 FRONTEND
1.  Cara Clone Repository
   git clone https://github.com/meytea/frontend-sistem-bimbingan.git <br>
2. Install Laravel
   Melalui Terminal
    composer create-priject laravel/laravel (nama-projek)
   Melalui Laragon
    - Buka Laragon
    - Klik kanan
    - Quick app
    - Laravel
4. Install Dependency Laravel
   ```php
   composer install
   ```
6. Menjalankan Laravel
   ```php
   php artisan serve
   ```

## 📂 Routing
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('Dashboard.index');

Route::resource('Mahasiswa', MahasiswaController::class);
Route::get('/Mahasiswa/{npm}/edit', [MahasiswaController::class, 'edit'])->name('Mahasiswa.edit');

Route::resource('Dosen', DosenController::class);
Route::get('/Dosen/{nidn}/edit', [DosenController::class, 'edit'])->name('Dosen.edit');

```
## 📂 Controller
```php
php artisan make:controller MahasiswaController
php artisan make:controller DosenController
```
**Mahasiswa Controller**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return view ('Mahasiswa');

        $response = Http::get('http://localhost:8080/Mahasiswa');


        if ($response->successful()) {
            $mahasiswa = collect($response->json())->sortBy('npm')->values();

            return view('Mahasiswa', compact('mahasiswa'));
        } else {
            return back()->with('error', 'Gagal ambil data');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tambahMahasiswa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validate = $request->validate([
                'npm' => 'required',
                'nama' => 'required',
                'angkatan' => 'required',
                'email' => 'required',
                'no_telp' => 'required'

            ]);

            Http::post('http://localhost:8080/Mahasiswa', $validate);

            response()->json([
                'success' => true,
                'message' => 'Mahasiswa berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('Mahasiswa.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $npm)
    {
        //
        $response = Http::get("http://localhost:8080/Mahasiswa/$npm");

    if ($response->successful()) {
        $mahasiswa = $response->json();
        return view('editMahasiswa', compact('mahasiswa'));
    } else {
        return redirect()->route('Mahasiswa.index')->with('error', 'Data tidak ditemukan');
    }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $mahasiswa)
    {
        //
         try {
            $validate = $request->validate([
                'npm' => 'required',
                'nama' => 'required',
                'angkatan' => 'required',
                'email' => 'required',
                'no_telp' => 'required'

            ]);

            Http::put("http://localhost:8080/Mahasiswa/$mahasiswa", $validate);

            response()->json([
                'success' => true,
                'message' => 'Mahasiswa berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('Mahasiswa.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $mahasiswa)
    {
        //
        Http::delete("http://localhost:8080/Mahasiswa/$mahasiswa");
        return redirect()->route('Mahasiswa.index');
    }
}

```
**DosenController**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return view ('Dosen');

         $response = Http::get('http://localhost:8080/Dosen');


        if ($response->successful()) {
            $dosen = collect($response->json())->sortBy('nidn')->values();

            return view('Dosen', compact('dosen'));
        } else {
            return back()->with('error', 'Gagal ambil data');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view ('tambahDosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validate = $request->validate([
                'nidn' => 'required',
                'nama' => 'required',
                'email' => 'required',
                'no_telp' => 'required'

            ]);

            Http::post('http://localhost:8080/Dosen', $validate);

            response()->json([
                'success' => true,
                'message' => 'Dosen berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('Dosen.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $nidn)
    {
        //
        $response = Http::get("http://localhost:8080/Dosen/$nidn");

    if ($response->successful()) {
        $dosen = $response->json();
        return view('editDosen', compact('dosen'));
    } else {
        return redirect()->route('Dosen.index')->with('error', 'Data tidak ditemukan');
    }

    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $dosen)
    {
        try {
            $validate = $request->validate([
                'nidn' => 'required',
                'nama' => 'required',
                'email' => 'required',
                'no_telp' => 'required'

            ]);

            Http::put("http://localhost:8080/Dosen/$dosen", $validate);

            response()->json([
                'success' => true,
                'message' => 'Dosen berhasil ditambahkan!',
                'data' => $request
            ], 201);

            return redirect()->route('Dosen.index');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($dosen)
    {
        Http::delete("http://localhost:8080/Dosen/$dosen");
        return redirect()->route('Dosen.index');
    }
}

```

## View
**Generate View**
```php
php artisan make:view Prodi
```
1. Mahasiswa.blade.php
   ```php
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>

<body class="bg-gray-100" data-page="datamahasiswa">
    <div class="flex">

        <aside class="w-64 bg-blue-700 min-h-screen text-white p-4">
            <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
            <h1 class="text-center text-3xl font-bold mb-6" style="font-family: 'Lobster', cursive;">SISTEM BIMBINGAN TA</h1>
            <nav>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('Dashboard.index') }}" class="flex items-center space-x-2 text-white font-semibold hover:bg-blue-800 p-2 rounded">
                            🏠 Dashboard
                        </a>
                    </li>
                    <li class="mb-4 relative">
                        <button id="dropdownButton" class="w-full flex items-center justify-between text-white font-semibold hover:bg-blue-800 p-2 rounded">
                            📊 Pengolahan Data
                            <span id="arrow">▼</span>
                        </button>
                        <ul id="dropdown" class="hidden bg-blue-600 mt-2 rounded-lg">
                            <li>
                                <a href="{{route('Mahasiswa.index')}}" class="block px-4 py-2 hover:bg-blue-700"> Data Mahasiswa</a>
                            </li>
                            <li>
                                <a href="{{route('Dosen.index')}}" class="block px-4 py-2 hover:bg-blue-700"> Data Dosen</a>
                            </li>
                       
                    </li>

                </ul>
            </nav>
        </aside>


        <main class="flex-1 p-6">
            <h2 class="text-center text-4xl font-bold">.::Data Mahasiswa::.</h2>
            <div class="bg-white shadow-md p-4 rounded-lg mt-4">
                <div class="flex justify-between mb-4">
                    <a href="{{route('Mahasiswa.create')}}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Data</a>
                    <input type="text" id="searchInput" placeholder="Cari..." class="border p-2 rounded w-1/3">
                </div>
                <table class="w-full mt-4 border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">No</th>
                            <th class="border p-2">Npm</th>
                            <th class="border p-2">Nama Mahasiswa</th>
                            <th class="border p-2">Angkatan</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">No. Telepon</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTable">
                        @foreach($mahasiswa as $index => $mhs)

                        <tr>
                            <td class="border p-2 text-center">{{ $index + 1 }}</td>
                            <td class="border p-2">{{ $mhs['npm']}}</td>
                            <td class="border p-2">{{ $mhs['nama']}}</td>
                            <td class="border p-2">{{ $mhs['angkatan']}}</td>
                            <td class="border p-2">{{ $mhs['email']}}</td>
                            <td class="border p-2">{{ $mhs['no_telp']}}</td>


                            <td class="border p-2 text-center flex gap-2 justify-center">
                                <a href="{{ route('Mahasiswa.edit', $mhs['npm']) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Edit</a>

                                <form action="{{ route('Mahasiswa.destroy', $mhs['npm']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-4">
                    <button id="prevPage" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Previous</button>
                    <span id="pageInfo" class="text-gray-700">Page 1</span>
                    <button id="nextPage" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Next</button>
                </div>
            </div>
        </main>
    </div>


    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="mt-4 flex justify-center space-x-4">
                <button onclick="deleteData()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, Hapus</button>
                <button onclick="closeDeleteModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const button = document.getElementById("dropdownButton");
            const dropdown = document.getElementById("dropdown");
            const arrow = document.getElementById("arrow");

            button.addEventListener("click", function() {
                dropdown.classList.toggle("hidden");
                arrow.textContent = dropdown.classList.contains("hidden") ? "▼" : "▲";
            });
        });
        
        let currentPage = 1;
        const rowsPerPage = 10;
        const table = document.getElementById("mahasiswaTable");
        const rows = table.getElementsByTagName("tr");
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function showPage(page) {
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = "none";
            }
            let start = (page - 1) * rowsPerPage;
            let end = start + rowsPerPage;
            for (let i = start; i < end && i < rows.length; i++) {
                rows[i].style.display = "";
            }
            document.getElementById("pageInfo").textContent = Page ${page} of ${totalPages};
        }

        document.getElementById("prevPage").addEventListener("click", function() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.getElementById("nextPage").addEventListener("click", function() {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        showPage(currentPage);

        document.addEventListener("DOMContentLoaded", function() {
            let currentPage = document.body.getAttribute("data-page");
            let dropdownMenu = document.getElementById("dropdown-menu");
            let dropdownBtn = document.getElementById("dropdown-btn");
            let arrow = document.getElementById("arrow");
            let activeLink = document.querySelector(a[href='${currentPage}']);

            let pages = ["penilaian", "datadosen", "datamahasiswa", "datamatkul", "dataprodi", "datakelas"];

            if (pages.includes(currentPage)) {
                dropdownMenu.classList.remove("hidden");
                arrow.innerHTML = "▲";
            }

            if (activeLink) {
                activeLink.classList.add("bg-blue-800", "text-white");
            }

            dropdownBtn.addEventListener("click", function() {
                if (dropdownMenu.classList.contains("hidden")) {
                    dropdownMenu.classList.remove("hidden");
                    arrow.innerHTML = "▲";
                } else {
                    dropdownMenu.classList.add("hidden");
                    arrow.innerHTML = "▼";
                }
            });
        });


        function openDeleteModal(event, element) {
            event.preventDefault();
            deleteElement = element.closest("tr");
            document.getElementById("deleteModal").classList.remove("hidden");
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
            deleteElement = null;
        }

        function deleteData() {
            if (deleteElement) {
                deleteElement.remove();
                deleteElement = null;
            }
            closeDeleteModal();
        }

        //seacrh
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#mahasiswaTable tr");

            rows.forEach(row => {
                let namaDosen = row.cells[2].textContent.toLowerCase();
                if (namaDosen.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>
   ```
2. Dosen.Blade.php
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-100" data-page="datamahasiswa">
    <div class="flex">

        <aside class="w-64 bg-blue-700 min-h-screen text-white p-4">
            <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
            <h1 class="text-center text-3xl font-bold mb-6" style="font-family: 'Lobster', cursive;">SISTEM BIMBINGAN TA</h1>
            <nav>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('Dashboard.index') }}" class="flex items-center space-x-2 text-white font-semibold hover:bg-blue-800 p-2 rounded">
                            🏠 Dashboard
                        </a>
                    </li>
                    <li class="mb-4 relative">
                        <button id="dropdownButton" class="w-full flex items-center justify-between text-white font-semibold hover:bg-blue-800 p-2 rounded">
                            📊 Pengolahan Data
                            <span id="arrow">▼</span>
                        </button>
                        <ul id="dropdown" class="hidden bg-blue-600 mt-2 rounded-lg">
                            <li>
                                <a href="{{route('Mahasiswa.index')}}" class="block px-4 py-2 hover:bg-blue-700"> Data Mahasiswa</a>
                            </li>
                            <li>
                                <a href="{{route('Dosen.index')}}" class="block px-4 py-2 hover:bg-blue-700"> Data Dosen</a>
                            </li>
                           
                    </li>

                </ul>
            </nav>
        </aside>


        <main class="flex-1 p-6">
            <h2 class="text-center text-4xl font-bold">.::Data Dosen::.</h2>
            <div class="bg-white shadow-md p-4 rounded-lg mt-4">
                <div class="flex justify-between mb-4">
                    <a href="{{route('Dosen.create')}}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Data</a>
                    <input type="text" id="searchInput" placeholder="Cari..." class="border p-2 rounded w-1/3">
                </div>
                <table class="w-full mt-4 border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">No</th>
                            <th class="border p-2">NIDN</th>
                            <th class="border p-2">Nama Dosen</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">No. Telepon</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTable">
                        @foreach($dosen as $index => $d)

                        <tr>
                            <td class="border p-2 text-center">{{ $index + 1 }}</td>
                            <td class="border p-2">{{ $d['nidn']}}</td>
                            <td class="border p-2">{{ $d['nama']}}</td>
                            <td class="border p-2">{{ $d['email']}}</td>
                            <td class="border p-2">{{ $d['no_telp']}}</td>


                            <td class="border p-2 text-center flex gap-2 justify-center">
                                <a href="{{ route('Dosen.edit', $d['nidn']) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Edit</a>

                                <form action="{{ route('Dosen.destroy', $d['nidn']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-4">
                    <button id="prevPage" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Previous</button>
                    <span id="pageInfo" class="text-gray-700">Page 1</span>
                    <button id="nextPage" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Next</button>
                </div>
            </div>
        </main>
    </div>


    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="mt-4 flex justify-center space-x-4">
                <button onclick="deleteData()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ya, Hapus</button>
                <button onclick="closeDeleteModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const button = document.getElementById("dropdownButton");
            const dropdown = document.getElementById("dropdown");
            const arrow = document.getElementById("arrow");

            button.addEventListener("click", function() {
                dropdown.classList.toggle("hidden");
                arrow.textContent = dropdown.classList.contains("hidden") ? "▼" : "▲";
            });
        });
        
        let currentPage = 1;
        const rowsPerPage = 10;
        const table = document.getElementById("mahasiswaTable");
        const rows = table.getElementsByTagName("tr");
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function showPage(page) {
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = "none";
            }
            let start = (page - 1) * rowsPerPage;
            let end = start + rowsPerPage;
            for (let i = start; i < end && i < rows.length; i++) {
                rows[i].style.display = "";
            }
            document.getElementById("pageInfo").textContent = Page ${page} of ${totalPages};
        }

        document.getElementById("prevPage").addEventListener("click", function() {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.getElementById("nextPage").addEventListener("click", function() {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        showPage(currentPage);

        document.addEventListener("DOMContentLoaded", function() {
            let currentPage = document.body.getAttribute("data-page");
            let dropdownMenu = document.getElementById("dropdown-menu");
            let dropdownBtn = document.getElementById("dropdown-btn");
            let arrow = document.getElementById("arrow");
            let activeLink = document.querySelector(a[href='${currentPage}']);

            let pages = ["penilaian", "datadosen", "datamahasiswa", "datamatkul", "dataprodi", "datakelas"];

            if (pages.includes(currentPage)) {
                dropdownMenu.classList.remove("hidden");
                arrow.innerHTML = "▲";
            }

            if (activeLink) {
                activeLink.classList.add("bg-blue-800", "text-white");
            }

            dropdownBtn.addEventListener("click", function() {
                if (dropdownMenu.classList.contains("hidden")) {
                    dropdownMenu.classList.remove("hidden");
                    arrow.innerHTML = "▲";
                } else {
                    dropdownMenu.classList.add("hidden");
                    arrow.innerHTML = "▼";
                }
            });
        });


        function openDeleteModal(event, element) {
            event.preventDefault();
            deleteElement = element.closest("tr");
            document.getElementById("deleteModal").classList.remove("hidden");
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
            deleteElement = null;
        }

        function deleteData() {
            if (deleteElement) {
                deleteElement.remove();
                deleteElement = null;
            }
            closeDeleteModal();
        }

        //seacrh
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#mahasiswaTable tr");

            rows.forEach(row => {
                let namaDosen = row.cells[2].textContent.toLowerCase();
                if (namaDosen.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>
