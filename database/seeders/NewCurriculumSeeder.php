<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Lesson::truncate();
        Topic::truncate();
        LearningPath::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $curriculum = [
            [
                'title' => 'Dasar HTML',
                'description' => 'Pelajari fondasi web dengan HTML dari nol',
                'difficulty' => 'Beginner',
                'estimated_hours' => 5,
                'topics' => [
                    [
                        'title' => 'Pengenalan HTML',
                        'lessons' => [
                            ['title' => 'Apa itu HTML dan cara kerja browser', 'type' => 'article', 'content' => '<h2>Apa itu HTML?</h2><p>HTML adalah bahasa markup standar untuk membuat halaman web.</p>'],
                            ['title' => 'Struktur dasar dokumen HTML', 'type' => 'code_example', 'content' => '<h2>Struktur HTML</h2><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n&lt;title&gt;Judul&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n...\n&lt;/body&gt;\n&lt;/html&gt;</code></pre>'],
                            ['title' => 'Cara membuat dan menjalankan file HTML pertama', 'type' => 'video', 'video_url' => 'https://www.youtube.com/embed/qz0aGYrrlhU'],
                        ]
                    ],
                    [
                        'title' => 'Tag & Elemen Dasar',
                        'lessons' => [
                            ['title' => 'Heading (h1-h6), Paragraf (p), Line Break (br)', 'type' => 'article', 'content' => '<h2>Heading & Paragraf</h2><p>Gunakan h1-h6 untuk judul dan p untuk teks biasa.</p>'],
                            ['title' => 'Bold, Italic, Underline, dan formatting teks', 'type' => 'article', 'content' => '<h2>Formatting</h2><p>Gunakan strong untuk tebal dan em untuk miring.</p>'],
                            ['title' => 'Komentar dalam HTML', 'type' => 'code_example', 'content' => '<h2>Komentar</h2><pre><code>&lt;!-- Ini adalah komentar --&gt;</code></pre>'],
                        ]
                    ],
                    [
                        'title' => 'Link & Gambar',
                        'lessons' => [
                            ['title' => 'Membuat hyperlink dengan tag <a>', 'type' => 'article', 'content' => '<h2>Hyperlink</h2><p>Gunakan atribut href untuk menentukan tujuan link.</p>'],
                            ['title' => 'Menampilkan gambar dengan tag <img>', 'type' => 'article', 'content' => '<h2>Gambar</h2><p>Gunakan atribut src untuk sumber gambar dan alt untuk teks alternatif.</p>'],
                            ['title' => 'Atribut href, src, alt, target', 'type' => 'article', 'content' => '<h2>Atribut Penting</h2><p>target="_blank" membuka link di tab baru.</p>'],
                        ]
                    ],
                    [
                        'title' => 'List & Tabel',
                        'lessons' => [
                            ['title' => 'Ordered list (ol) dan Unordered list (ul)', 'type' => 'article', 'content' => '<h2>List</h2><p>ol untuk list bernomor, ul untuk list poin.</p>'],
                            ['title' => 'Membuat tabel dengan tr, td, th', 'type' => 'article', 'content' => '<h2>Tabel</h2><p>tr adalah baris, td adalah data, th adalah header.</p>'],
                            ['title' => 'Colspan dan Rowspan', 'type' => 'article', 'content' => '<h2>Merge Cell</h2><p>Colspan untuk gabung kolom, rowspan untuk gabung baris.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Form & Input',
                        'lessons' => [
                            ['title' => 'Membuat form dengan tag <form>', 'type' => 'article', 'content' => '<h2>Form</h2><p>Form digunakan untuk mengumpulkan input dari pengguna.</p>'],
                            ['title' => 'Input text, password, email, number', 'type' => 'article', 'content' => '<h2>Tipe Input</h2><p>Setiap tipe input memiliki kegunaan dan validasi berbeda.</p>'],
                            ['title' => 'Button, checkbox, radio, select, textarea', 'type' => 'article', 'content' => '<h2>Elemen Form Lainnya</h2><p>Gunakan select untuk dropdown dan textarea untuk teks panjang.</p>'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'CSS & Styling',
                'description' => 'Buat tampilan web yang cantik dengan CSS',
                'difficulty' => 'Beginner',
                'estimated_hours' => 6,
                'topics' => [
                    [
                        'title' => 'Pengenalan CSS',
                        'lessons' => [
                            ['title' => 'Apa itu CSS dan cara menghubungkan ke HTML', 'type' => 'article', 'content' => '<h2>Intro CSS</h2><p>CSS digunakan untuk mengatur gaya visual halaman web.</p>'],
                            ['title' => 'Inline, Internal, dan External CSS', 'type' => 'article', 'content' => '<h2>Metode CSS</h2><p>External CSS adalah cara terbaik untuk maintain kode.</p>'],
                            ['title' => 'Selektor dasar: element, class, id', 'type' => 'article', 'content' => '<h2>Selektor</h2><p>Class menggunakan titik (.) dan ID menggunakan pagar (#).</p>'],
                        ]
                    ],
                    [
                        'title' => 'Box Model & Layout Dasar',
                        'lessons' => [
                            ['title' => 'Margin, Padding, Border', 'type' => 'article', 'content' => '<h2>Box Model</h2><p>Margin di luar, Padding di dalam border.</p>'],
                            ['title' => 'Width, Height, Box-sizing', 'type' => 'article', 'content' => '<h2>Ukuran Box</h2><p>box-sizing: border-box memudahkan perhitungan ukuran.</p>'],
                            ['title' => 'Display: block, inline, inline-block', 'type' => 'article', 'content' => '<h2>Properti Display</h2><p>Block mengambil satu baris penuh, inline hanya selebar konten.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Warna & Typography',
                        'lessons' => [
                            ['title' => 'Warna dengan hex, rgb, rgba', 'type' => 'article', 'content' => '<h2>Format Warna</h2><p>rgba mendukung transparansi (alpha).</p>'],
                            ['title' => 'Font-family, font-size, font-weight', 'type' => 'article', 'content' => '<h2>Tipografi</h2><p>Gunakan font-family untuk menentukan jenis font.</p>'],
                            ['title' => 'Text-align, line-height, letter-spacing', 'type' => 'article', 'content' => '<h2>Aligment</h2><p>line-height mengatur jarak antar baris teks.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Flexbox',
                        'lessons' => [
                            ['title' => 'Konsep Flexbox dan flex container', 'type' => 'article', 'content' => '<h2>Flexbox Intro</h2><p>Gunakan display: flex pada parent element.</p>'],
                            ['title' => 'justify-content dan align-items', 'type' => 'article', 'content' => '<h2>Aligment Flex</h2><p>justify-content (horizontal), align-items (vertical).</p>'],
                            ['title' => 'flex-wrap, flex-grow, flex-basis', 'type' => 'article', 'content' => '<h2>Flex Property</h2><p>flex-grow menentukan seberapa besar elemen akan tumbuh.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Responsive Design',
                        'lessons' => [
                            ['title' => 'Apa itu responsive design', 'type' => 'article', 'content' => '<h2>Responsive</h2><p>Halaman web yang menyesuaikan diri dengan ukuran layar.</p>'],
                            ['title' => 'Media queries', 'type' => 'article', 'content' => '<h2>Media Query</h2><p>Gunakan @media untuk menerapkan CSS pada kondisi tertentu.</p>'],
                            ['title' => 'Mobile-first approach', 'type' => 'article', 'content' => '<h2>Mobile First</h2><p>Desain untuk layar kecil dulu, baru ke layar besar.</p>'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'JavaScript Dasar',
                'description' => 'Pelajari logika pemrograman dengan JavaScript',
                'difficulty' => 'Beginner',
                'estimated_hours' => 8,
                'topics' => [
                    [
                        'title' => 'Pengenalan JavaScript',
                        'lessons' => [
                            ['title' => 'Apa itu JavaScript dan kegunaannya', 'type' => 'article', 'content' => '<h2>JS Intro</h2><p>JavaScript membuat web menjadi interaktif.</p>'],
                            ['title' => 'Cara menyisipkan JS ke HTML', 'type' => 'article', 'content' => '<h2>Script Tag</h2><p>Letakkan sebelum tag penutup body.</p>'],
                            ['title' => 'console.log dan cara debug dasar', 'type' => 'article', 'content' => '<h2>Debugging</h2><p>Gunakan console.log untuk melihat nilai variabel di konsol browser.</p>'],
                        ]
                    ],
                    [
                        'title' => 'JS Variabel & Tipe Data',
                        'lessons' => [
                            ['title' => 'var, let, const dan perbedaannya', 'type' => 'article', 'content' => '<h2>Variabel</h2><p>Gunakan const untuk nilai tetap, let untuk yang bisa berubah.</p>'],
                            ['title' => 'String, Number, Boolean, null, undefined', 'type' => 'article', 'content' => '<h2>Tipe Data</h2><p>JS adalah bahasa yang bersifat dynamic typing.</p>'],
                            ['title' => 'Operasi matematika dan string', 'type' => 'article', 'content' => '<h2>Operator</h2><p>+ digunakan untuk penjumlahan dan penggabungan string.</p>'],
                        ]
                    ],
                    [
                        'title' => 'JS Kondisi & Perulangan',
                        'lessons' => [
                            ['title' => 'if, else if, else', 'type' => 'article', 'content' => '<h2>Kondisi</h2><p>Logika percabangan berdasarkan kondisi tertentu.</p>'],
                            ['title' => 'switch case', 'type' => 'article', 'content' => '<h2>Switch</h2><p>Alternatif if-else untuk banyak kondisi pada satu nilai.</p>'],
                            ['title' => 'for loop, while loop, forEach', 'type' => 'article', 'content' => '<h2>Looping</h2><p>Perulangan untuk menjalankan kode berkali-kali.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Fungsi JS',
                        'lessons' => [
                            ['title' => 'Membuat dan memanggil fungsi', 'type' => 'article', 'content' => '<h2>Function</h2><p>Blok kode yang bisa dipanggil berkali-kali.</p>'],
                            ['title' => 'Parameter dan return value', 'type' => 'article', 'content' => '<h2>Parameter</h2><p>Fungsi bisa menerima input dan mengembalikan output.</p>'],
                            ['title' => 'Arrow function (=>)', 'type' => 'article', 'content' => '<h2>Arrow Function</h2><p>Sintaks fungsi yang lebih modern dan ringkas.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Array & Object JS',
                        'lessons' => [
                            ['title' => 'Membuat dan mengakses array', 'type' => 'article', 'content' => '<h2>Array</h2><p>Kumpulan data berurutan (indeks dimulai dari 0).</p>'],
                            ['title' => 'Method array: push, pop, map, filter', 'type' => 'article', 'content' => '<h2>Array Method</h2><p>Manipulasi data array dengan mudah.</p>'],
                            ['title' => 'Membuat dan mengakses object', 'type' => 'article', 'content' => '<h2>Object</h2><p>Kumpulan pasangan key-value.</p>'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'PHP Dasar',
                'description' => 'Backend development dengan bahasa PHP',
                'difficulty' => 'Beginner',
                'estimated_hours' => 7,
                'topics' => [
                    [
                        'title' => 'Pengenalan PHP',
                        'lessons' => [
                            ['title' => 'Apa itu PHP dan cara kerjanya', 'type' => 'article', 'content' => '<h2>PHP Intro</h2><p>Bahasa skrip server-side untuk web development.</p>'],
                            ['title' => 'Sintaks dasar dan tag PHP', 'type' => 'article', 'content' => '<h2>Tag PHP</h2><p>Dimulai dengan &lt;?php dan diakhiri ?&gt;.</p>'],
                            ['title' => 'echo, print, komentar', 'type' => 'article', 'content' => '<h2>Output</h2><p>echo adalah perintah paling umum untuk cetak teks.</p>'],
                        ]
                    ],
                    [
                        'title' => 'PHP Variabel & Tipe Data',
                        'lessons' => [
                            ['title' => 'Variabel dengan tanda $', 'type' => 'article', 'content' => '<h2>Variabel PHP</h2><p>Selalu diawali dengan tanda dollar ($).</p>'],
                            ['title' => 'String, Integer, Float, Boolean, Array', 'type' => 'article', 'content' => '<h2>Tipe Data PHP</h2><p>PHP memiliki tipe data standar seperti bahasa lain.</p>'],
                            ['title' => 'Operasi dasar dan string functions', 'type' => 'article', 'content' => '<h2>String Func</h2><p>strlen() untuk hitung panjang, str_replace() untuk ganti teks.</p>'],
                        ]
                    ],
                    [
                        'title' => 'PHP Kondisi & Perulangan',
                        'lessons' => [
                            ['title' => 'if, elseif, else', 'type' => 'article', 'content' => '<h2>Percabangan</h2><p>Logika kendali di PHP.</p>'],
                            ['title' => 'switch case', 'type' => 'article', 'content' => '<h2>Switch PHP</h2><p>Membandingkan satu nilai dengan banyak case.</p>'],
                            ['title' => 'for, while, foreach', 'type' => 'article', 'content' => '<h2>Looping PHP</h2><p>foreach sangat berguna untuk iterasi array.</p>'],
                        ]
                    ],
                    [
                        'title' => 'PHP Function & Array',
                        'lessons' => [
                            ['title' => 'Membuat function di PHP', 'type' => 'article', 'content' => '<h2>PHP Function</h2><p>Deklarasi dengan kata kunci function.</p>'],
                            ['title' => 'Array indexed dan associative', 'type' => 'article', 'content' => '<h2>Assoc Array</h2><p>Array dengan key berupa string (key => value).</p>'],
                            ['title' => 'Fungsi array bawaan PHP', 'type' => 'article', 'content' => '<h2>Array Func</h2><p>sort(), array_push(), array_merge().</p>'],
                        ]
                    ],
                    [
                        'title' => 'PHP Form & Superglobal',
                        'lessons' => [
                            ['title' => '$_GET, $_POST, $_SESSION', 'type' => 'article', 'content' => '<h2>Superglobals</h2><p>Variabel bawaan PHP yang bisa diakses di mana saja.</p>'],
                            ['title' => 'Validasi input form', 'type' => 'article', 'content' => '<h2>Validasi</h2><p>Penting untuk keamanan data sebelum diproses.</p>'],
                            ['title' => 'Keamanan dasar input user', 'type' => 'article', 'content' => '<h2>Security</h2><p>Gunakan htmlspecialchars() untuk cegah XSS.</p>'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Laravel Framework',
                'description' => 'Modern PHP web framework untuk profesional',
                'difficulty' => 'Intermediate',
                'estimated_hours' => 10,
                'topics' => [
                    [
                        'title' => 'Pengenalan Laravel',
                        'lessons' => [
                            ['title' => 'Apa itu Laravel dan MVC pattern', 'type' => 'article', 'content' => '<h2>Laravel Intro</h2><p>Framework PHP dengan arsitektur Model-View-Controller.</p>'],
                            ['title' => 'Instalasi Laravel dengan Composer', 'type' => 'article', 'content' => '<h2>Install</h2><p>composer create-project laravel/laravel app-name.</p>'],
                            ['title' => 'Struktur folder Laravel', 'type' => 'article', 'content' => '<h2>Folder Structure</h2><p>app, resources, routes, database adalah folder utama.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Routing & Controller',
                        'lessons' => [
                            ['title' => 'Cara membuat route di web.php', 'type' => 'article', 'content' => '<h2>Routing</h2><p>Definisikan URL aplikasi di folder routes.</p>'],
                            ['title' => 'Membuat Controller dengan Artisan', 'type' => 'article', 'content' => '<h2>Controller</h2><p>php artisan make:controller NameController.</p>'],
                            ['title' => 'Resource Controller', 'type' => 'article', 'content' => '<h2>Resource</h2><p>Controller otomatis dengan method CRUD lengkap.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Blade Template',
                        'lessons' => [
                            ['title' => 'Sintaks Blade dasar', 'type' => 'article', 'content' => '<h2>Blade Intro</h2><p>Template engine Laravel yang powerfull.</p>'],
                            ['title' => 'Layout dengan @extends dan @yield', 'type' => 'article', 'content' => '<h2>Layouting</h2><p>Gunakan inheritance untuk template utama.</p>'],
                            ['title' => 'Komponen dan slot', 'type' => 'article', 'content' => '<h2>Components</h2><p>Elemen UI yang bisa dipakai ulang (reusable).</p>'],
                        ]
                    ],
                    [
                        'title' => 'Eloquent ORM & Migration',
                        'lessons' => [
                            ['title' => 'Membuat Migration dan Model', 'type' => 'article', 'content' => '<h2>DB Mapping</h2><p>Migration untuk skema tabel, Model untuk interaksi data.</p>'],
                            ['title' => 'CRUD dengan Eloquent', 'type' => 'article', 'content' => '<h2>Eloquent CRUD</h2><p>Cara mudah interaksi database tanpa SQL manual.</p>'],
                            ['title' => 'Relasi: hasMany, belongsTo', 'type' => 'article', 'content' => '<h2>Relationship</h2><p>Menghubungkan antar tabel dengan method di Model.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Autentikasi & Middleware',
                        'lessons' => [
                            ['title' => 'Laravel Breeze untuk auth', 'type' => 'article', 'content' => '<h2>Auth Starter</h2><p>Paket simpel untuk fitur Login dan Register.</p>'],
                            ['title' => 'Middleware dan proteksi route', 'type' => 'article', 'content' => '<h2>Middleware</h2><p>Filter request sebelum masuk ke Controller.</p>'],
                            ['title' => 'Role dan permission dasar', 'type' => 'article', 'content' => '<h2>Authorization</h2><p>Mengatur hak akses pengguna aplikasi.</p>'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Git & GitHub',
                'description' => 'Version control sistem untuk kolaborasi tim',
                'difficulty' => 'Beginner',
                'estimated_hours' => 3,
                'topics' => [
                    [
                        'title' => 'Pengenalan Git',
                        'lessons' => [
                            ['title' => 'Apa itu version control dan Git', 'type' => 'article', 'content' => '<h2>Git Intro</h2><p>Alat untuk mencatat riwayat perubahan kode.</p>'],
                            ['title' => 'Instalasi dan konfigurasi Git', 'type' => 'article', 'content' => '<h2>Setup Git</h2><p>git config --global user.name "Nama".</p>'],
                            ['title' => 'git init dan konsep repository', 'type' => 'article', 'content' => '<h2>Repo</h2><p>Folder yang dipantau oleh Git.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Basic Git Commands',
                        'lessons' => [
                            ['title' => 'git add, git commit, git status', 'type' => 'article', 'content' => '<h2>Git Flow</h2><p>Stage changes, commit, dan cek status.</p>'],
                            ['title' => 'git log dan melihat history', 'type' => 'article', 'content' => '<h2>History</h2><p>Melihat catatan komit yang sudah dilakukan.</p>'],
                            ['title' => '.gitignore', 'type' => 'article', 'content' => '<h2>Ignore</h2><p>File atau folder yang tidak ingin dipantau Git.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Branching & Merge Git',
                        'lessons' => [
                            ['title' => 'Membuat branch baru', 'type' => 'article', 'content' => '<h2>Branching</h2><p>Bekerja di fitur terpisah tanpa ganggu main branch.</p>'],
                            ['title' => 'git merge dan menyelesaikan conflict', 'type' => 'article', 'content' => '<h2>Merging</h2><p>Menggabungkan perubahan dari satu branch ke branch lain.</p>'],
                            ['title' => 'Best practice branching', 'type' => 'article', 'content' => '<h2>Practice</h2><p>Gunakan nama branch yang deskriptif.</p>'],
                        ]
                    ],
                    [
                        'title' => 'GitHub Intro',
                        'lessons' => [
                            ['title' => 'Push dan pull dari remote repository', 'type' => 'article', 'content' => '<h2>Remote</h2><p>Upload (push) dan download (pull) kode ke server.</p>'],
                            ['title' => 'Clone repository', 'type' => 'article', 'content' => '<h2>Clone</h2><p>Download repository yang sudah ada di internet.</p>'],
                            ['title' => 'Pull Request dasar', 'type' => 'article', 'content' => '<h2>PR</h2><p>Cara mengajukan perubahan ke proyek orang lain.</p>'],
                        ]
                    ],
                ]
            ],
            [
                'title' => 'Python Dasar',
                'description' => 'Bahasa pemrograman paling populer untuk data dan AI',
                'difficulty' => 'Beginner',
                'estimated_hours' => 6,
                'topics' => [
                    [
                        'title' => 'Pengenalan Python',
                        'lessons' => [
                            ['title' => 'Apa itu Python dan kegunaannya', 'type' => 'article', 'content' => '<h2>Python Intro</h2><p>Bahasa yang simpel, powerfull, dan serbaguna.</p>'],
                            ['title' => 'Instalasi Python dan menjalankan script', 'type' => 'article', 'content' => '<h2>Setup</h2><p>Gunakan terminal atau IDE seperti VS Code.</p>'],
                            ['title' => 'print(), komentar, indentasi', 'type' => 'article', 'content' => '<h2>Sintaks Dasar</h2><p>Python menggunakan indentasi (spasi) untuk blok kode.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Python Variabel & Tipe Data',
                        'lessons' => [
                            ['title' => 'Variabel dan assignment', 'type' => 'article', 'content' => '<h2>Python Var</h2><p>Langsung deklarasi tanpa kata kunci khusus.</p>'],
                            ['title' => 'String, Integer, Float, Boolean', 'type' => 'article', 'content' => '<h2>Data Type</h2><p>Tipe data dasar di Python.</p>'],
                            ['title' => 'Input dari user dengan input()', 'type' => 'article', 'content' => '<h2>User Input</h2><p>Menerima data dari pengguna melalui konsol.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Python Kondisi & Perulangan',
                        'lessons' => [
                            ['title' => 'if, elif, else', 'type' => 'article', 'content' => '<h2>Percabangan Python</h2><p>Gunakan titik dua (:) dan indentasi.</p>'],
                            ['title' => 'for loop dan range()', 'type' => 'article', 'content' => '<h2>Looping</h2><p>range() menghasilkan deret angka untuk diulang.</p>'],
                            ['title' => 'while loop', 'type' => 'article', 'content' => '<h2>While</h2><p>Terus berulang selama kondisi bernilai True.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Python Fungsi & Module',
                        'lessons' => [
                            ['title' => 'Membuat fungsi dengan def', 'type' => 'article', 'content' => '<h2>Python Func</h2><p>Didefinisikan dengan kata kunci def.</p>'],
                            ['title' => 'Parameter, return, dan scope', 'type' => 'article', 'content' => '<h2>Parameter</h2><p>Fungsi yang fleksibel dengan return value.</p>'],
                            ['title' => 'Import module bawaan Python', 'type' => 'article', 'content' => '<h2>Modules</h2><p>Gunakan library yang sudah tersedia di Python.</p>'],
                        ]
                    ],
                    [
                        'title' => 'Python List & Dictionary',
                        'lessons' => [
                            ['title' => 'Membuat dan memanipulasi list', 'type' => 'article', 'content' => '<h2>List Python</h2><p>Tipe data koleksi yang mutable (bisa diubah).</p>'],
                            ['title' => 'Dictionary: key-value pairs', 'type' => 'article', 'content' => '<h2>Dict</h2><p>Tipe data untuk menyimpan pasangan kunci dan nilai.</p>'],
                            ['title' => 'List comprehension dasar', 'type' => 'article', 'content' => '<h2>Comprehension</h2><p>Cara singkat membuat list baru dari list lama.</p>'],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($curriculum as $i => $pathData) {
            $path = LearningPath::create([
                'title' => $pathData['title'],
                'slug' => Str::slug($pathData['title']),
                'description' => $pathData['description'],
                'difficulty' => $pathData['difficulty'],
                'estimated_hours' => $pathData['estimated_hours'],
                'order' => $i + 1,
                'is_published' => true,
            ]);

            foreach ($pathData['topics'] as $j => $topicData) {
                $topic = Topic::create([
                    'learning_path_id' => $path->id,
                    'title' => $topicData['title'],
                    'slug' => Str::slug($topicData['title']),
                    'order' => $j + 1,
                    'is_published' => true,
                    'estimated_minutes' => 30,
                ]);

                foreach ($topicData['lessons'] as $k => $lessonData) {
                    Lesson::create([
                        'topic_id' => $topic->id,
                        'title' => $lessonData['title'],
                        'type' => $lessonData['type'],
                        'content' => $lessonData['content'] ?? null,
                        'video_url' => $lessonData['video_url'] ?? null,
                        'order' => $k + 1,
                        'xp_reward' => 10,
                        'is_published' => true,
                        'is_free' => true,
                        'duration_minutes' => 10,
                    ]);
                }
            }
        }
    }
}
