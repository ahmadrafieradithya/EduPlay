<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Game 1: Typing Race
        $typingRace = Game::updateOrCreate(
            ['title' => 'Typing Race', 'type' => 'typing_race'],
            [
                'type' => 'typing_race',
                'config' => [
                    'description' => 'Berlomba mengetik code snippet secara akurat',
                    'difficulty' => 'beginner',
                ],
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $typingRace->id, 'level_number' => 1],
            [
                'title' => 'Dasar Typing',
                'content' => [
                    'texts' => [
                        'echo "Hello World";',
                        '$name = "John";',
                        'function greet($name) { return $name; }',
                        'for ($i = 0; $i < 10; $i++) { echo $i; }',
                    ],
                    'target_wpm' => 20,
                    'difficulty' => 'easy',
                ],
                'time_limit' => 120,
                'xp_reward' => 25,
                'min_score_to_pass' => 60,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $typingRace->id, 'level_number' => 2],
            [
                'title' => 'Intermediate Typing',
                'content' => [
                    'texts' => [
                        'class User { public function __construct($name) { $this->name = $name; } }',
                        'array_filter($items, fn($item) => $item["active"] == true)',
                        '$data = ["name" => "John", "age" => 25, "email" => "john@example.com"];',
                        'if ($user && $user->isAdmin() && $user->canDelete($resource)) { $resource->delete(); }',
                    ],
                    'target_wpm' => 35,
                    'difficulty' => 'medium',
                ],
                'time_limit' => 150,
                'xp_reward' => 40,
                'min_score_to_pass' => 70,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $typingRace->id, 'level_number' => 3],
            [
                'title' => 'Expert Typing',
                'content' => [
                    'texts' => [
                        'Route::middleware(["auth:sanctum"])->group(function () { Route::apiResource("users", UserController::class); });',
                        '$users = User::where("is_active", true)->with(["posts", "comments"])->paginate(15);',
                        'DB::transaction(function () { $user = User::create($data); $user->syncRoles($roles); Log::info("User created", ["id" => $user->id]); });',
                        'namespace App\\Http\\Controllers; use Illuminate\\Http\\Request; class UserController extends Controller { public function index() { return User::all(); } }',
                    ],
                    'target_wpm' => 50,
                    'difficulty' => 'hard',
                ],
                'time_limit' => 180,
                'xp_reward' => 60,
                'min_score_to_pass' => 75,
                'is_active' => true,
            ]
        );

        // Game 2: Bug Fix
        $bugFix = Game::updateOrCreate(
            ['title' => 'Bug Fix', 'type' => 'bug_fix'],
            [
                'type' => 'bug_fix',
                'config' => [
                    'description' => 'Temukan dan perbaiki bug dalam kode',
                    'difficulty' => 'beginner',
                ],
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $bugFix->id, 'level_number' => 1],
            [
                'title' => 'Logic Error',
                'content' => [
                    'description' => 'Ada bug dalam logika perulangan. Temukan dan perbaiki!',
                    'buggy_code' => '$sum = 0; for ($i = 1; $i < 10; $i--) { $sum += $i; } echo $sum;',
                    'options' => [
                        '$i > 10',
                        '$i <= 10',
                        '$i++',
                        '$i -= 1',
                    ],
                    'correct_answers' => ['$i++'],
                ],
                'time_limit' => 90,
                'xp_reward' => 30,
                'min_score_to_pass' => 80,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $bugFix->id, 'level_number' => 2],
            [
                'title' => 'Type Error',
                'content' => [
                    'description' => 'Variabel $age seharusnya integer, tetapi dikirim sebagai string.',
                    'buggy_code' => 'function checkAdult($age) { if ($age >= 18) { return "Adult"; } return "Minor"; } checkAdult("25");',
                    'options' => [
                        'Ubah "25" menjadi (int)"25"',
                        'Ubah parameter menjadi (int)$age',
                        'Gunakan intval($age) di awal function',
                        'Semua jawaban benar',
                    ],
                    'correct_answers' => ['Semua jawaban benar'],
                ],
                'time_limit' => 90,
                'xp_reward' => 35,
                'min_score_to_pass' => 80,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $bugFix->id, 'level_number' => 3],
            [
                'title' => 'Database Query Bug',
                'content' => [
                    'description' => 'Query ini tidak mengembalikan hasil yang diharapkan.',
                    'buggy_code' => '$users = User::where("is_active", "1")->get(); // Seharusnya aktif tapi masih mendapat inactive',
                    'options' => [
                        'Ubah "1" menjadi true',
                        'Ubah \'is_active\', "1" menjadi \'is_active\', true',
                        'Gunakan whereRaw',
                        'Tambahkan ->toSql() untuk debug',
                    ],
                    'correct_answers' => ['Ubah \'is_active\', "1" menjadi \'is_active\', true'],
                ],
                'time_limit' => 100,
                'xp_reward' => 45,
                'min_score_to_pass' => 80,
                'is_active' => true,
            ]
        );

        // Game 3: Code Puzzle
        $codePuzzle = Game::updateOrCreate(
            ['title' => 'Code Puzzle', 'type' => 'code_puzzle'],
            [
                'type' => 'code_puzzle',
                'config' => [
                    'description' => 'Susun potongan kode dalam urutan yang benar',
                    'difficulty' => 'intermediate',
                ],
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $codePuzzle->id, 'level_number' => 1],
            [
                'title' => 'Simple Function',
                'content' => [
                    'pieces' => [
                        'function sum($a, $b) {',
                        'return $a + $b;',
                        '}',
                        'echo sum(5, 3);',
                    ],
                    'correct_order' => [0, 1, 2, 3],
                    'hints' => [
                        'Function definition dimulai dengan nama function',
                        'Return statement di dalam function',
                        'Closing bracket penutup function',
                        'Panggil function dengan argumen',
                    ],
                ],
                'time_limit' => 120,
                'xp_reward' => 35,
                'min_score_to_pass' => 85,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $codePuzzle->id, 'level_number' => 2],
            [
                'title' => 'Class Definition',
                'content' => [
                    'pieces' => [
                        'class User {',
                        'public $name;',
                        'public function __construct($name) {',
                        '$this->name = $name;',
                        '}',
                        '}',
                        '$user = new User("John");',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6],
                    'hints' => [
                        'Class definition',
                        'Property deklarasi',
                        'Constructor method',
                        'Assign ke property',
                        'Close constructor',
                        'Close class',
                        'Instantiate object',
                    ],
                ],
                'time_limit' => 150,
                'xp_reward' => 45,
                'min_score_to_pass' => 85,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $codePuzzle->id, 'level_number' => 3],
            [
                'title' => 'Array Filter Logic',
                'content' => [
                    'pieces' => [
                        '$numbers = [1, 2, 3, 4, 5];',
                        '$filtered = array_filter($numbers,',
                        'fn($num) => $num > 2',
                        ');',
                        'foreach ($filtered as $num) {',
                        'echo $num . " ";',
                        '}',
                    ],
                    'correct_order' => [0, 1, 2, 3, 4, 5, 6],
                    'hints' => [
                        'Initialize array',
                        'Start array_filter',
                        'Arrow function dengan condition',
                        'Close array_filter',
                        'Loop hasil filter',
                        'Echo nilai',
                        'Close loop',
                    ],
                ],
                'time_limit' => 150,
                'xp_reward' => 50,
                'min_score_to_pass' => 85,
                'is_active' => true,
            ]
        );

        // Game 4: Output Guessing
        $outputGuessing = Game::updateOrCreate(
            ['title' => 'Output Guessing', 'type' => 'output_guessing'],
            [
                'type' => 'output_guessing',
                'config' => [
                    'description' => 'Tebak output dari kode yang diberikan',
                    'difficulty' => 'beginner',
                ],
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $outputGuessing->id, 'level_number' => 1],
            [
                'title' => 'Simple Output',
                'content' => [
                    'question' => 'Apa output dari kode ini?',
                    'code' => '$x = 5; $y = 3; echo $x + $y;',
                    'options' => ['8', '15', '53', 'Error'],
                    'correct' => 0,
                ],
                'time_limit' => 60,
                'xp_reward' => 20,
                'min_score_to_pass' => 100,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $outputGuessing->id, 'level_number' => 2],
            [
                'title' => 'String Concatenation',
                'content' => [
                    'question' => 'Output dari kode berikut?',
                    'code' => '$first = "Hello"; $second = "World"; echo $first . " " . $second;',
                    'options' => ['HelloWorld', 'Hello World', 'Hello  World', 'Error'],
                    'correct' => 1,
                ],
                'time_limit' => 60,
                'xp_reward' => 25,
                'min_score_to_pass' => 100,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $outputGuessing->id, 'level_number' => 3],
            [
                'title' => 'Loop Output',
                'content' => [
                    'question' => 'Output dari kode berikut?',
                    'code' => 'for ($i = 1; $i <= 3; $i++) { echo $i; } echo " Done";',
                    'options' => ['123 Done', '1 2 3 Done', '0 1 2 Done', 'Done'],
                    'correct' => 0,
                ],
                'time_limit' => 75,
                'xp_reward' => 30,
                'min_score_to_pass' => 100,
                'is_active' => true,
            ]
        );

        // Game 5: HTML Builder
        $htmlBuilder = Game::updateOrCreate(
            ['title' => 'HTML Builder', 'type' => 'html_builder'],
            [
                'type' => 'html_builder',
                'config' => [
                    'description' => 'Bangun halaman HTML sesuai dengan requirement',
                    'difficulty' => 'beginner',
                ],
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $htmlBuilder->id, 'level_number' => 1],
            [
                'title' => 'Basic Page Structure',
                'content' => [
                    'question' => 'Buat halaman HTML dengan judul "My First Page" dan sebuah heading "Welcome"',
                    'requirements' => [
                        'Gunakan DOCTYPE html',
                        'Tambahkan title "My First Page"',
                        'Heading h1 dengan teks "Welcome"',
                        'Minimal 1 paragraph',
                    ],
                    'hints' => [
                        'Gunakan <!DOCTYPE html>',
                        'Title di dalam head tag',
                        'Konten di dalam body tag',
                    ],
                ],
                'time_limit' => 120,
                'xp_reward' => 40,
                'min_score_to_pass' => 80,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $htmlBuilder->id, 'level_number' => 2],
            [
                'title' => 'Navigation Page',
                'content' => [
                    'question' => 'Buat halaman dengan navbar sederhana',
                    'requirements' => [
                        'Navigation dengan 3 link (Home, About, Contact)',
                        'Main section dengan heading dan paragraf',
                        'Footer dengan copyright',
                        'Gunakan semantic HTML',
                    ],
                    'hints' => [
                        'Gunakan nav, main, footer tags',
                        'List untuk navigation items',
                        'Link ke pages berbeda',
                    ],
                ],
                'time_limit' => 180,
                'xp_reward' => 50,
                'min_score_to_pass' => 80,
                'is_active' => true,
            ]
        );

        GameLevel::updateOrCreate(
            ['game_id' => $htmlBuilder->id, 'level_number' => 3],
            [
                'title' => 'Portfolio Section',
                'content' => [
                    'question' => 'Buat section portfolio dengan grid layout',
                    'requirements' => [
                        'Heading "My Projects"',
                        'Minimal 3 project cards dengan gambar dan deskripsi',
                        'Link ke project atau live demo',
                        'Grid layout responsif',
                        'Include CSS class untuk styling',
                    ],
                    'hints' => [
                        'Gunakan section dan article tags',
                        'Image dengan alt text',
                        'Class names untuk CSS styling',
                        'Semantic markup',
                    ],
                ],
                'time_limit' => 240,
                'xp_reward' => 60,
                'min_score_to_pass' => 80,
                'is_active' => true,
            ]
        );
    }
}
