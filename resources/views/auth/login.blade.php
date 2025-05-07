<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Remela</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Intro.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/minified/introjs.min.css">
    <style>
        .error-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }
        .modal-content {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 28rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            animation: slideUp 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .input-icon {
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
        }
        .form-container {
            transition: all 0.3s ease;
        }
        /* Animasi untuk modal bantuan */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        /* Custom styling untuk Intro.js */
        .introjs-custom .introjs-tooltip-title {
            color: #0369a1;
        }
        .introjs-custom .introjs-tooltiptext {
            max-width: 350px;
        }
        .introjs-custom .introjs-button {
            background-color: #0ea5e9;
            color: white;
            text-shadow: none;
            border-radius: 0.375rem;
        }
        .introjs-custom .introjs-button:hover {
            background-color: #0284c7;
        }
        .introjs-custom .introjs-skipbutton {
            color: #64748b;
        }
        .introjs-highlight {
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-50 to-sky-100 flex flex-col">
    <!-- Error Modal -->
    <div id="error-modal" class="error-modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Terjadi Kesalahan
                </h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p id="error-message" class="text-gray-700 mb-4">
                @if($errors->has('auth'))
                    {{ $errors->first('auth') }}
                @endif
            </p>
            <div class="flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-800 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden form-container">
            <div class="bg-gradient-to-r from-sky-500 to-sky-600 text-white text-center py-6">
                <h1 class="text-2xl font-bold">Formulir Masuk</h1>
                <p class="mt-1 text-sky-100">Silakan masuk untuk melanjutkan</p>
            </div>
            
            <form id="login-form" action="{{ route('login') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-gray-700 font-medium mb-2">Masuk Sebagai</label>
                    <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-200 focus:border-sky-500 transition-all" onchange="toggleInputType()">
                        <option value="">Pilih peran</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pasien" {{ old('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="kader" {{ old('role') == 'kader' ? 'selected' : '' }}>Kader</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dynamic Input Field -->
                <div id="input-container">
                    @if(old('role') === 'pasien')
                        <div>
                            <label for="nik" class="block text-gray-700 font-medium mb-2">NIK</label>
                            <div class="flex rounded-lg overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-sky-200 focus-within:border-sky-500 transition-all">
                                <span class="input-icon">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" class="flex-grow p-3 outline-none" maxlength="16" placeholder="Masukkan NIK">
                            </div>
                            @error('nik')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <div class="flex rounded-lg overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-sky-200 focus-within:border-sky-500 transition-all">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="flex-grow p-3 outline-none" placeholder="Masukkan Email">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Kata Sandi</label>
                    <div class="flex rounded-lg overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-sky-200 focus-within:border-sky-500 transition-all">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" class="flex-grow p-3 outline-none" placeholder="Masukkan Kata Sandi">
                        <button type="button" onclick="togglePassword()" class="px-4 text-gray-500 hover:text-sky-500 transition-colors">
                            <i id="eye-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="show-password" onclick="togglePassword()" class="h-4 w-4 text-sky-500 focus:ring-sky-400 border-gray-300 rounded">
                        <label for="show-password" class="ml-2 text-gray-600">Tampilkan Kata Sandi</label>
                    </div>
                    <button type="button" onclick="showHelpModal()" class="text-sm text-sky-600 hover:text-sky-800 hover:underline">
                        Bantuan Masuk?
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-300 transform hover:scale-[1.01]">
                    Masuk
                </button>
            </form>

            <!-- Link untuk memulai tur lagi -->
            <div class="px-6 pb-6 text-center">
                <button onclick="startIntroTour()" class="text-sm text-gray-500 hover:text-sky-600 flex items-center justify-center mx-auto">
                    <i class="fas fa-question-circle mr-2"></i> Butuh panduan menggunakan formulir masuk?
                </button>
            </div>
        </div>
    </main>

    <footer class="bg-sky-800 text-white text-center p-4 text-sm">
        &copy; 2025 REMELA. Semua Hak Dilindungi.
    </footer>

    <!-- Intro.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/minified/intro.min.js"></script>
    
    <script>
        // Tampilkan modal jika ada error auth
        @if($errors->has('auth'))
            document.addEventListener('DOMContentLoaded', function() {
                showErrorModal("{{ $errors->first('auth') }}");
            });
        @endif

        // Fungsi untuk toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");
            const showPasswordCheckbox = document.getElementById("show-password");
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
                showPasswordCheckbox.checked = true;
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
                showPasswordCheckbox.checked = false;
            }
        }

        // Fungsi untuk toggle input type berdasarkan role
        function toggleInputType() {
            const role = document.getElementById("role").value;
            const inputContainer = document.getElementById("input-container");
            
            if (role === "pasien") {
                inputContainer.innerHTML = `
                    <div>
                        <label for="nik" class="block text-gray-700 font-medium mb-2">NIK</label>
                        <div class="flex rounded-lg overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-sky-200 focus-within:border-sky-500 transition-all">
                            <span class="input-icon">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" class="flex-grow p-3 outline-none" maxlength="16" placeholder="Masukkan NIK">
                        </div>
                    </div>
                `;
            } else {
                inputContainer.innerHTML = `
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <div class="flex rounded-lg overflow-hidden border border-gray-300 focus-within:ring-2 focus-within:ring-sky-200 focus-within:border-sky-500 transition-all">
                            <span class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="flex-grow p-3 outline-none" placeholder="Masukkan Email">
                        </div>
                    </div>
                `;
            }
        }

        // Fungsi untuk menampilkan modal error
        function showErrorModal(message) {
            const modal = document.getElementById('error-modal');
            const errorMessage = document.getElementById('error-message');
            
            errorMessage.textContent = message;
            modal.style.display = 'flex';
            
            // Tutup modal setelah 5 detik
            setTimeout(() => {
                closeModal();
            }, 5000);
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            const modal = document.getElementById('error-modal');
            modal.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.animation = '';
            }, 300);
        }

        // Fungsi untuk memulai tur pengantar
        function startIntroTour() {
            const intro = introJs();
            
            intro.setOptions({
                steps: [
                    {
                        element: document.querySelector('.bg-gradient-to-r.from-sky-500.to-sky-600'),
                        intro: "<div class='text-center'><h3 class='text-lg font-bold mb-2'>Selamat Datang di REMELA</h3><p>Sistem Informasi Posyandu Terintegrasi</p></div>",
                        position: 'bottom'
                    },
                    {
                        element: document.getElementById('role'),
                        intro: "<div class='text-left'><h4 class='font-bold mb-1'>Pilih Peran Anda</h4><p>Silakan pilih peran Anda:<br>- <strong>Admin</strong>: Untuk administrator sistem<br>- <strong>Pasien</strong>: Untuk ibu/bayi (gunakan NIK)<br>- <strong>Petugas</strong>: Untuk petugas puskesmas<br>- <strong>Kader</strong>: Untuk kader posyandu</p></div>",
                        position: 'bottom'
                    },
                    {
                        element: document.getElementById('input-container'),
                        intro: "<div class='text-left'><h4 class='font-bold mb-1'>Identitas Masuk</h4><p>Bergantung pada peran yang dipilih:<br>- <strong>Pasien</strong>: Masukkan NIK (16 digit)<br>- <strong>Lainnya</strong>: Masukkan email terdaftar</p></div>",
                        position: 'top'
                    },
                    {
                        element: document.getElementById('password'),
                        intro: "<div class='text-left'><h4 class='font-bold mb-1'>Kata Sandi</h4><p>Masukkan kata sandi Anda. Klik ikon mata untuk menampilkan/menyembunyikan kata sandi.</p><p class='mt-2 text-sm bg-yellow-50 p-2 rounded'><i class='fas fa-info-circle mr-1'></i> <strong>Lupa kata sandi?</strong> Silakan hubungi kader posyandu terdekat untuk reset password.</p></div>",
                        position: 'top'
                    },
                    {
                        element: document.querySelector('button[type="submit"]'),
                        intro: "<div class='text-center'><h4 class='font-bold mb-1'>Masuk</h4><p>Setelah mengisi semua data, klik tombol ini untuk masuk ke sistem.</p><p class='mt-2 text-sm'>Pastikan data yang dimasukkan sudah benar.</p></div>",
                        position: 'top'
                    }
                ],
                nextLabel: 'Lanjut',
                prevLabel: 'Kembali',
                doneLabel: 'Selesai',
                exitOnOverlayClick: false,
                showStepNumbers: false,
                showBullets: false,
                tooltipClass: 'introjs-custom',
                highlightClass: 'introjs-highlight'
            });
            
            intro.start();
            
            // Set flag di localStorage bahwa tur sudah ditampilkan
            localStorage.setItem('loginIntroShown', 'true');
        }

        // Fungsi untuk menampilkan modal bantuan
        function showHelpModal() {
            const modal = document.createElement('div');
            modal.id = 'help-modal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg max-w-md w-full p-6 animate-fadeIn">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-sky-600 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Bantuan Masuk
                        </h3>
                        <button onclick="document.getElementById('help-modal').remove()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="space-y-3 text-gray-700">
                        <div class="p-3 bg-sky-50 rounded-lg">
                            <h4 class="font-bold mb-1 text-sky-700">Masuk sebagai Pasien</h4>
                            <p>Gunakan NIK (16 digit) sebagai username dan password yang telah diberikan kader.</p>
                            <p class="mt-2 text-sm"><i class="fas fa-lightbulb mr-1"></i> NIK bisa ditemukan di Kartu Keluarga atau KTP.</p>
                        </div>
                        <div class="p-3 bg-sky-50 rounded-lg">
                            <h4 class="font-bold mb-1 text-sky-700">Masuk sebagai Petugas/Kader</h4>
                            <p>Gunakan email terdaftar dan password yang telah Anda buat.</p>
                            <p class="mt-2 text-sm"><i class="fas fa-lightbulb mr-1"></i> Pastikan email yang dimasukkan sudah benar.</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="font-bold mb-1 text-yellow-700">Lupa Password?</h4>
                            <p><i class="fas fa-exclamation-circle mr-1"></i> Silakan hubungi kader posyandu terdekat untuk reset password.</p>
                            <p class="mt-2 text-sm"><i class="fas fa-phone mr-1"></i> Kontak Posyandu: 0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end items-center">
                        <button onclick="document.getElementById('help-modal').remove()" class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        // Jalankan tur pengantar saat pertama kali mengakses halaman
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ini pertama kali pengguna mengunjungi halaman Masuk
            const firstVisit = !localStorage.getItem('loginIntroShown');
            
            if (firstVisit) {
                setTimeout(() => {
                    startIntroTour();
                }, 1000);
            }
            
            // Tambahkan tombol bantuan di pojok kanan bawah
            const helpButton = document.createElement('button');
            helpButton.id = 'help-button';
            helpButton.className = 'fixed bottom-6 right-6 bg-sky-500 hover:bg-sky-600 text-white p-3 rounded-full shadow-lg transition-all z-50';
            helpButton.innerHTML = '<i class="fas fa-question text-xl"></i>';
            helpButton.title = 'Bantuan Masuk';
            helpButton.onclick = function() {
                showHelpModal();
            };
            document.body.appendChild(helpButton);
        });
    </script>
</body>
</html>