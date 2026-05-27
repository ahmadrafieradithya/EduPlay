<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTypingRace();
        $this->seedCodePuzzle();
    }

    private function seedTypingRace(): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'typing-race'],
            [
                'title'       => 'Typing Race',
                'slug'        => 'typing-race',
                'description' => 'Uji kecepatan mengetik kode kamu! Semakin cepat dan akurat, semakin tinggi skor kamu.',
                'type'        => 'typing_race',
                'icon'        => '⌨️',
                'is_active'   => true,
            ]
        );

        // Level 1 - HTML Texts (10+ texts)
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'order' => 1],
            [
                'game_id'           => $game->id,
                'title'             => 'HTML Dasar',
                'description'       => 'Ketik tag-tag HTML dasar dengan cepat dan akurat.',
                'order'             => 1,
                'time_limit'        => 60,
                'min_score_to_pass' => 50,
                'xp_reward'         => 20,
                'content'           => json_encode([
                    'texts' => [
                        '<h1>Halo Dunia!</h1>',
                        '<p>Belajar HTML itu menyenangkan.</p>',
                        '<a href="index.html">Kembali ke Beranda</a>',
                        '<img src="foto.jpg" alt="Foto Saya">',
                        '<ul><li>Item Pertama</li><li>Item Kedua</li></ul>',
                        '<!DOCTYPE html>',
                        '<input type="text" placeholder="Nama kamu...">',
                        '<button type="submit">Kirim Formulir</button>',
                        '<div class="container"><p>Konten di sini</p></div>',
                        '<table><tr><td>Data</td></tr></table>',
                        '<span style="color: red;">Teks Merah</span>',
                        '<h2>Subjudul Penting</h2>',
                    ],
                    'target_wpm' => 20,
                    'language'   => 'html',
                ]),
            ]
        );

        // Level 2 - PHP Texts (10+ texts)
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'order' => 2],
            [
                'game_id'           => $game->id,
                'title'             => 'PHP Menengah',
                'description'       => 'Ketik sintaks PHP dengan cepat. Perhatikan tanda dolar dan titik koma!',
                'order'             => 2,
                'time_limit'        => 60,
                'min_score_to_pass' => 50,
                'xp_reward'         => 30,
                'content'           => json_encode([
                    'texts' => [
                        '$nama = "Ahmad Rafie";',
                        'echo "Halo, " . $nama . "!";',
                        'if ($umur >= 17) { echo "Boleh masuk"; }',
                        'for ($i = 1; $i <= 10; $i++) { echo $i; }',
                        'function hitung($a, $b) { return $a + $b; }',
                        '$array = ["HTML", "CSS", "PHP", "Laravel"];',
                        'foreach ($siswa as $s) { echo $s->nama; }',
                        '$hasil = array_filter($data, fn($x) => $x > 0);',
                        'class Siswa { public string $nama; }',
                        'echo str_word_count("Hello World Laravel");',
                        '$x = isset($_POST["name"]) ? $_POST["name"] : "Guest";',
                        'date("Y-m-d H:i:s");',
                    ],
                    'target_wpm' => 15,
                    'language'   => 'php',
                ]),
            ]
        );

        // Level 3 - Laravel Texts (10+ texts)
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'order' => 3],
            [
                'game_id'           => $game->id,
                'title'             => 'Laravel Expert',
                'description'       => 'Tantangan tertinggi! Ketik sintaks Laravel yang kompleks.',
                'order'             => 3,
                'time_limit'        => 60,
                'min_score_to_pass' => 50,
                'xp_reward'         => 50,
                'content'           => json_encode([
                    'texts' => [
                        'Route::get("/dashboard", [DashboardController::class, "index"]);',
                        '$users = User::where("active", true)->orderBy("name")->get();',
                        'return view("dashboard", compact("user", "posts"));',
                        'User::create(["name" => $request->name, "email" => $request->email]);',
                        '$user = User::findOrFail($id);',
                        'return redirect()->route("home")->with("success", "Berhasil!");',
                        'Schema::create("posts", function (Blueprint $table) {',
                        '$request->validate(["email" => "required|email|unique:users"]);',
                        'public function posts(): HasMany { return $this->hasMany(Post::class); }',
                        'php artisan make:controller PostController --resource',
                        '$post = Post::with("user")->first();',
                        'return response()->json($data, 200);',
                    ],
                    'target_wpm' => 12,
                    'language'   => 'php',
                ]),
            ]
        );
    }

    private function seedCodePuzzle(): void
    {
        $game = Game::updateOrCreate(
            ['slug' => 'code-puzzle'],
            [
                'title'       => 'Code Puzzle',
                'slug'        => 'code-puzzle',
                'description' => 'Susun potongan kode menjadi program yang benar. Uji logika dan pemahamanmu!',
                'type'        => 'code_puzzle',
                'icon'        => '🧩',
                'is_active'   => true,
            ]
        );

        // Level 1 - HTML Puzzle
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'order' => 1],
            [
                'game_id'           => $game->id,
                'title'             => 'Susun Halaman HTML',
                'description'       => 'Susun potongan kode HTML menjadi struktur halaman yang benar.',
                'order'             => 1,
                'time_limit'        => 120,
                'min_score_to_pass' => 60,
                'xp_reward'         => 30,
                'content'           => json_encode([
                    'description' => 'Susun tag-tag HTML berikut menjadi struktur dokumen HTML yang valid!',
                    'pieces'      => [
                        '<!DOCTYPE html>',
                        '<html lang="id">',
                        '<head>',
                        '<title>Halaman Saya</title>',
                        '</head>',
                        '<body>',
                        '<h1>Halo Dunia!</h1>',
                        '</body>',
                        '</html>',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    'hints' => [
                        'DOCTYPE selalu di baris pertama',
                        'Tag html membungkus segalanya',
                        'head berisi metadata, body berisi konten',
                        'Setiap tag pembuka butuh tag penutup',
                    ],
                ]),
            ]
        );

        // Level 2 - PHP Puzzle
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'order' => 2],
            [
                'game_id'           => $game->id,
                'title'             => 'Fungsi PHP',
                'description'       => 'Susun potongan kode PHP menjadi fungsi yang benar.',
                'order'             => 2,
                'time_limit'        => 120,
                'min_score_to_pass' => 60,
                'xp_reward'         => 40,
                'content'           => json_encode([
                    'description' => 'Susun baris-baris kode ini menjadi fungsi PHP yang menghitung faktorial!',
                    'pieces'      => [
                        '<?php',
                        'function faktorial($n) {',
                        '    if ($n <= 1) {',
                        '        return 1;',
                        '    }',
                        '    return $n * faktorial($n - 1);',
                        '}',
                        'echo faktorial(5);',
                        '?>',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    'hints' => [
                        'PHP dibuka dengan <?php',
                        'Fungsi dideklarasikan dengan function',
                        'Kondisi dasar (base case) di cek pertama',
                        'Rekursi memanggil fungsi itu sendiri',
                    ],
                ]),
            ]
        );

        // Level 3 - Laravel Puzzle
        GameLevel::updateOrCreate(
            ['game_id' => $game->id, 'order' => 3],
            [
                'game_id'           => $game->id,
                'title'             => 'Laravel Controller',
                'description'       => 'Susun method store() di Laravel Controller dengan benar.',
                'order'             => 3,
                'time_limit'        => 150,
                'min_score_to_pass' => 60,
                'xp_reward'         => 60,
                'content'           => json_encode([
                    'description' => 'Susun kode method store() pada Laravel Controller yang menyimpan data ke database!',
                    'pieces'      => [
                        'public function store(Request $request)',
                        '{',
                        '    $validated = $request->validate([',
                        "        'title' => 'required|max:255',",
                        "        'body'  => 'required',",
                        '    ]);',
                        '    Post::create($validated);',
                        "    return redirect()->route('posts.index')",
                        "        ->with('success', 'Post berhasil dibuat!');",
                        '}',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    'hints' => [
                        'Method dimulai dengan public function',
                        'Selalu validasi input dulu sebelum simpan',
                        'Post::create() menyimpan ke database',
                        'redirect() mengembalikan user ke halaman lain',
                    ],
                ]),
            ]
        );
    }
}