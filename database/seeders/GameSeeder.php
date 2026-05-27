<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameLevel;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $schoolId = School::first()?->id ?? 1;
        $userId = User::first()?->id ?? 1;

        $this->seedTypingRace($schoolId, $userId);
        $this->seedCodePuzzle($schoolId, $userId);
        $this->seedBugHunter($schoolId, $userId);
        $this->seedQuizCode($schoolId, $userId);
        $this->seedFillTheBlank($schoolId, $userId);
    }

    private function seedTypingRace($schoolId, $userId): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'typing-race'],
            [
                'school_id'   => $schoolId,
                'created_by'  => $userId,
                'title'       => 'Typing Race',
                'slug'        => 'typing-race',
                'description' => 'Uji kecepatan mengetik kode kamu! Semakin cepat dan akurat, semakin tinggi skor kamu.',
                'type'        => 'typing_race',
                'icon'        => '⌨️',
                'is_active'   => true,
                'difficulty'  => 'medium'
            ]
        );

        // Level 1 - Mudah
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 1],
            [
                'title'             => 'Dasar Variabel',
                'description'       => 'Ketik deklarasi variabel dan output sederhana.',
                'level_number'      => 1,
                'time_limit'        => 60,
                'min_score_to_pass' => 50,
                'xp_reward'         => 20,
                'content'           => [
                    'texts' => [
                        '<h1>Halo Dunia</h1>',
                        '$nama = "Ahmad";',
                        'echo $nama;',
                        '<p>Belajar Coding</p>',
                        '$skor = 100;',
                        'print("EduPlay");'
                    ],
                    'language'   => 'php',
                ],
            ]
        );

        // Level 2 - Sedang
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 2],
            [
                'title'             => 'Kondisi & Loop',
                'description'       => 'Tantangan mengetik struktur kendali PHP.',
                'level_number'      => 2,
                'time_limit'        => 60,
                'min_score_to_pass' => 60,
                'xp_reward'         => 40,
                'content'           => [
                    'texts' => [
                        'if ($skor > 80) { echo "Lulus"; }',
                        'for ($i=0; $i<10; $i++) { }',
                        'array_push($data, "PHP");',
                        'while ($x <= 5) { $x++; }',
                        'foreach ($items as $item) { }',
                        'else { echo "Coba lagi"; }'
                    ],
                    'language'   => 'php',
                ],
            ]
        );

        // Level 3 - Sulit
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 3],
            [
                'title'             => 'Fungsi & Class',
                'description'       => 'Ketik sintaks PHP yang lebih kompleks.',
                'level_number'      => 3,
                'time_limit'        => 60,
                'min_score_to_pass' => 70,
                'xp_reward'         => 60,
                'content'           => [
                    'texts' => [
                        'public function hitung($a, $b) { return $a + $b; }',
                        'class Siswa extends User { }',
                        'Route::get("/", [Controller::class, "index"]);',
                        'protected $fillable = ["name", "email"];',
                        'return view("dashboard", compact("data"));',
                        'public function __construct() { }'
                    ],
                    'language'   => 'php',
                ],
            ]
        );
    }

    private function seedCodePuzzle($schoolId, $userId): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'code-puzzle'],
            [
                'school_id'   => $schoolId,
                'created_by'  => $userId,
                'title'       => 'Code Puzzle',
                'slug'        => 'code-puzzle',
                'description' => 'Susun potongan kode menjadi program yang benar. Uji logika dan pemahamanmu!',
                'type'        => 'code_puzzle',
                'icon'        => '🧩',
                'is_active'   => true,
                'difficulty'  => 'hard'
            ]
        );

        // Level 1 - Mudah (HTML)
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 1],
            [
                'title'             => 'Struktur HTML',
                'description'       => 'Susun tag-tag HTML dasar.',
                'level_number'      => 1,
                'time_limit'        => 120,
                'min_score_to_pass' => 60,
                'xp_reward'         => 30,
                'content'           => [
                    'pieces'      => [
                        '<html>',
                        '<head>',
                        '<title>Judul</title>',
                        '</head>',
                        '<body>',
                        '<h1>Isi</h1>',
                        '</body>',
                        '</html>',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6, 7],
                    'hints' => ['Tag html membungkus semuanya', 'Head di atas body'],
                ],
            ]
        );

        // Level 2 - Sedang (PHP Loop)
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 2],
            [
                'title'             => 'Penjumlahan Array',
                'description'       => 'Susun kode PHP untuk menghitung total array.',
                'level_number'      => 2,
                'time_limit'        => 150,
                'min_score_to_pass' => 70,
                'xp_reward'         => 50,
                'content'           => [
                    'pieces'      => [
                        '<?php',
                        '$angka = [1, 2, 3];',
                        '$total = 0;',
                        'foreach ($angka as $n) {',
                        '    $total += $n;',
                        '}',
                        'echo $total;',
                        '?>',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6, 7],
                    'hints' => ['Inisialisasi total dengan 0', 'Echo dilakukan setelah loop selesai'],
                ],
            ]
        );

        // Level 3 - Sulit (Laravel Controller)
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 3],
            [
                'title'             => 'Laravel Controller',
                'description'       => 'Susun class controller sederhana.',
                'level_number'      => 3,
                'time_limit'        => 180,
                'min_score_to_pass' => 80,
                'xp_reward'         => 80,
                'content'           => [
                    'pieces'      => [
                        'namespace App\Http;',
                        'use Illuminate\Http\Request;',
                        'class PostController {',
                        '    public function index() {',
                        '        $posts = Post::all();',
                        '        return view("posts", compact("posts"));',
                        '    }',
                        '}',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6, 7],
                    'hints' => ['Namespace selalu di baris pertama', 'Return view di akhir method'],
                ],
            ]
        );
    }

    private function seedBugHunter($schoolId, $userId): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'bug-hunter'],
            [
                'school_id'   => $schoolId,
                'created_by'  => $userId,
                'title'       => 'Bug Hunter',
                'slug'        => 'bug-hunter',
                'description' => 'Temukan dan perbaiki bug dalam kode. Jadilah detektif kode yang handal!',
                'type'        => 'bug_fix',
                'icon'        => '🐛',
                'is_active'   => true,
                'difficulty'  => 'medium'
            ]
        );

        // Level 1 - Mudah
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 1],
            [
                'title'             => 'Sintaks Dasar',
                'description'       => 'Temukan kesalahan penulisan dasar.',
                'level_number'      => 1,
                'time_limit'        => 60,
                'min_score_to_pass' => 70,
                'xp_reward'         => 30,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Apa yang salah dengan kode ini? <br><code>$x = 10 echo $x;</code>',
                            'options'     => ['Kurang titik koma (;)', 'Variabel salah', 'Kurang tanda kurung', 'Tidak ada yang salah'],
                            'correct'     => 0,
                            'explanation' => 'Setiap pernyataan di PHP harus diakhiri dengan titik koma (;).'
                        ],
                        [
                            'question'    => 'Manakah penulisan variabel yang SALAH?',
                            'options'     => ['$nama_saya', '$123nama', '$_nama', '$NamaSaya'],
                            'correct'     => 1,
                            'explanation' => 'Variabel tidak boleh diawali dengan angka.'
                        ],
                        [
                            'question'    => 'Perbaiki tag HTML ini: <code>&lt;p&gt;Halo&lt;/b&gt;</code>',
                            'options'     => ['Ganti &lt;/b&gt; dengan &lt;/p&gt;', 'Ganti &lt;p&gt; dengan &lt;b&gt;', 'Hapus tag penutup', 'Sudah benar'],
                            'correct'     => 0,
                            'explanation' => 'Tag pembuka <p> harus ditutup dengan tag </p>.'
                        ]
                    ]
                ],
            ]
        );

        // Level 2 - Sedang
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 2],
            [
                'title'             => 'Logika Loop',
                'description'       => 'Perbaiki kesalahan pada perulangan dan kondisi.',
                'level_number'      => 2,
                'time_limit'        => 60,
                'min_score_to_pass' => 70,
                'xp_reward'         => 50,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Perbaiki for loop ini: <br><code>for ($i=0 $i<10 $i++)</code>',
                            'options'     => ['Gunakan titik koma (;)', 'Gunakan koma (,)', 'Gunakan titik (.)', 'Gunakan spasi'],
                            'correct'     => 0,
                            'explanation' => 'Sintaks for loop menggunakan titik koma sebagai pemisah: for($i=0; $i<10; $i++).'
                        ],
                        [
                            'question'    => 'Apa bug pada kode ini? <br><code>if ($x = 10) { echo "Sama"; }</code>',
                            'options'     => ['Harusnya menggunakan ==', 'Kurang titik koma', 'Tanda kurung salah', 'Tidak ada bug'],
                            'correct'     => 0,
                            'explanation' => 'Satu tanda sama dengan (=) adalah assignment, untuk perbandingan gunakan dua (==).'
                        ]
                    ]
                ],
            ]
        );

        // Level 3 - Sulit
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 3],
            [
                'title'             => 'Scope & Function',
                'description'       => 'Analisis bug pada fungsi dan ruang lingkup variabel.',
                'level_number'      => 3,
                'time_limit'        => 60,
                'min_score_to_pass' => 70,
                'xp_reward'         => 70,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Apa bug di sini? <br><code>function test() { echo $y; } <br>$y = 5; <br>test();</code>',
                            'options'     => ['Variabel $y tidak dikenal di dalam fungsi', 'Fungsi tidak boleh bernama test', 'Variable $y harus string', 'Kurang return'],
                            'correct'     => 0,
                            'explanation' => 'Variabel global tidak otomatis masuk ke scope fungsi di PHP. Gunakan kata kunci global atau lewatkan sebagai parameter.'
                        ]
                    ]
                ],
            ]
        );
    }

    private function seedQuizCode($schoolId, $userId): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'quiz-code'],
            [
                'school_id'   => $schoolId,
                'created_by'  => $userId,
                'title'       => 'Quiz Code',
                'slug'        => 'quiz-code',
                'description' => 'Tebak output dan jawab kuis seputar programming untuk meningkatkan pemahamanmu.',
                'type'        => 'output_guessing',
                'icon'        => '🔮',
                'is_active'   => true,
                'difficulty'  => 'easy'
            ]
        );

        // Level 1 - Mudah
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 1],
            [
                'title'             => 'Operasi Dasar',
                'description'       => 'Tebak hasil perhitungan sederhana.',
                'level_number'      => 1,
                'time_limit'        => 45,
                'min_score_to_pass' => 70,
                'xp_reward'         => 20,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Apa output dari: <br><code>$a=5; $b=2; echo $a + $b;</code>',
                            'options'     => ['7', '52', '3', 'Error'],
                            'correct'     => 0,
                            'explanation' => '5 + 2 adalah 7.'
                        ],
                        [
                            'question'    => 'Apa hasil dari 10 % 3?',
                            'options'     => ['1', '3', '0', '3.33'],
                            'correct'     => 0,
                            'explanation' => 'Modulus (%) menghasilkan sisa bagi. 10 dibagi 3 adalah 3 sisa 1.'
                        ]
                    ]
                ],
            ]
        );

        // Level 2 - Sedang
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 2],
            [
                'title'             => 'String & Array',
                'description'       => 'Tebak hasil manipulasi string dan array.',
                'level_number'      => 2,
                'time_limit'        => 60,
                'min_score_to_pass' => 70,
                'xp_reward'         => 40,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Apa output dari: <br><code>$x="10"; $y=5; echo $x . $y;</code>',
                            'options'     => ['105', '15', 'Error', '10.5'],
                            'correct'     => 0,
                            'explanation' => 'Operator titik (.) digunakan untuk penggabungan string (concatenation) di PHP.'
                        ]
                    ]
                ],
            ]
        );

        // Level 3 - Sulit
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 3],
            [
                'title'             => 'Logika Kompleks',
                'description'       => 'Tebak output dari logika program yang lebih dalam.',
                'level_number'      => 3,
                'time_limit'        => 90,
                'min_score_to_pass' => 70,
                'xp_reward'         => 60,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Apa output dari: <br><code>$arr=[1,2,3]; array_pop($arr); echo count($arr);</code>',
                            'options'     => ['2', '3', '1', 'Error'],
                            'correct'     => 0,
                            'explanation' => 'array_pop menghapus elemen terakhir (3), sehingga array sisa [1, 2] dengan jumlah 2.'
                        ]
                    ]
                ],
            ]
        );
    }

    private function seedFillTheBlank($schoolId, $userId): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'fill-the-blank'],
            [
                'school_id'   => $schoolId,
                'created_by'  => $userId,
                'title'       => 'Fill the Blank',
                'slug'        => 'fill-the-blank',
                'description' => 'Lengkapi bagian kode yang kosong untuk membuat program berjalan dengan benar.',
                'type'        => 'fill_blank',
                'icon'        => '✏️',
                'is_active'   => true,
                'difficulty'  => 'easy'
            ]
        );

        // Level 1 - Mudah
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 1],
            [
                'title'             => 'Deklarasi Kode',
                'description'       => 'Lengkapi bagian awal kode.',
                'level_number'      => 1,
                'time_limit'        => 45,
                'min_score_to_pass' => 70,
                'xp_reward'         => 20,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Lengkapi deklarasi variabel ini: <br><code>____ $nama = "Budi";</code>',
                            'options'     => ['$', 'var', 'let', 'val'],
                            'correct'     => 0,
                            'explanation' => 'Variabel di PHP selalu dimulai dengan tanda dolar ($).'
                        ],
                        [
                            'question'    => 'Lengkapi tag pembuka PHP: <br><code>____ echo "Hello";</code>',
                            'options'     => ['<?php', '<?', '<php', 'php'],
                            'correct'     => 0,
                            'explanation' => 'Tag pembuka standar PHP adalah <?php.'
                        ]
                    ]
                ],
            ]
        );

        // Level 2 - Sedang
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 2],
            [
                'title'             => 'Keyword Loop',
                'description'       => 'Lengkapi kata kunci untuk perulangan.',
                'level_number'      => 2,
                'time_limit'        => 60,
                'min_score_to_pass' => 70,
                'xp_reward'         => 40,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Lengkapi sintaks foreach: <br><code>foreach ($data ____ $item)</code>',
                            'options'     => ['as', 'in', '=>', 'is'],
                            'correct'     => 0,
                            'explanation' => 'Sintaks foreach di PHP menggunakan kata kunci "as" untuk memisahkan array dan elemennya.'
                        ]
                    ]
                ],
            ]
        );

        // Level 3 - Sulit
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'level_number' => 3],
            [
                'title'             => 'Magic Methods',
                'description'       => 'Lengkapi method khusus dalam Class PHP.',
                'level_number'      => 3,
                'time_limit'        => 90,
                'min_score_to_pass' => 70,
                'xp_reward'         => 60,
                'content'           => [
                    'questions' => [
                        [
                            'question'    => 'Lengkapi Constructor: <br><code>public function ____() { }</code>',
                            'options'     => ['__construct', 'construct', 'init', 'new'],
                            'correct'     => 0,
                            'explanation' => 'Constructor di PHP menggunakan method magic __construct (dua garis bawah).'
                        ]
                    ]
                ],
            ]
        );
    }
}
