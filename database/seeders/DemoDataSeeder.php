<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Course;
use App\Models\Game;
use App\Models\GameLevel;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\LearningPath;
use App\Models\Module;
use App\Models\School;
use App\Models\Streak;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\UserXP;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's demo data.
     */
    public function run(): void
    {
        $school = School::firstOrCreate([
            'slug' => 'demo-school',
        ], [
            'name' => 'Demo School',
            'domain' => 'demo.eduplay.test',
            'address' => 'Demo address',
            'quota_students' => 1000,
            'is_active' => true,
        ]);

        $this->seedUsers($school->id);
        $this->seedLevels();
        $this->seedLearningPaths();
        $this->seedCourseModules($school->id);
        $this->seedGames($school->id);
        $this->seedBadges();
        $this->seedUserProgressData();
    }

    private function seedLevels(): void
    {
        $levels = [
            ['level_number' => 1, 'title' => 'Murid Baru', 'min_xp' => 0, 'max_xp' => 100],
            ['level_number' => 2, 'title' => 'Penjelajah HTML', 'min_xp' => 101, 'max_xp' => 250],
            ['level_number' => 3, 'title' => 'Stylizer CSS', 'min_xp' => 251, 'max_xp' => 500],
            ['level_number' => 4, 'title' => 'Script Master', 'min_xp' => 501, 'max_xp' => 900],
            ['level_number' => 5, 'title' => 'Code Warrior', 'min_xp' => 901, 'max_xp' => 1500],
            ['level_number' => 6, 'title' => 'PHP Adventurer', 'min_xp' => 1501, 'max_xp' => 2300],
            ['level_number' => 7, 'title' => 'Database Knight', 'min_xp' => 2301, 'max_xp' => 3300],
            ['level_number' => 8, 'title' => 'Route Ranger', 'min_xp' => 3301, 'max_xp' => 4500],
            ['level_number' => 9, 'title' => 'Blade Champion', 'min_xp' => 4501, 'max_xp' => 6000],
            ['level_number' => 10, 'title' => 'MVC Wizard', 'min_xp' => 6001, 'max_xp' => 8000],
            ['level_number' => 11, 'title' => 'Query Commander', 'min_xp' => 8001, 'max_xp' => 10500],
            ['level_number' => 12, 'title' => 'Cache Crusader', 'min_xp' => 10501, 'max_xp' => 13500],
            ['level_number' => 13, 'title' => 'Debugging Oracle', 'min_xp' => 13501, 'max_xp' => 17000],
            ['level_number' => 14, 'title' => 'API Artisan', 'min_xp' => 17001, 'max_xp' => 21000],
            ['level_number' => 15, 'title' => 'Eloquent Sage', 'min_xp' => 21001, 'max_xp' => 26000],
            ['level_number' => 16, 'title' => 'Testing Titan', 'min_xp' => 26001, 'max_xp' => 31500],
            ['level_number' => 17, 'title' => 'Deployment Don', 'min_xp' => 31501, 'max_xp' => 38000],
            ['level_number' => 18, 'title' => 'Secured Sentinel', 'min_xp' => 38001, 'max_xp' => 45500],
            ['level_number' => 19, 'title' => 'Performance Paladin', 'min_xp' => 45501, 'max_xp' => 54000],
            ['level_number' => 20, 'title' => 'Laravel Legend', 'min_xp' => 54001, 'max_xp' => 99999],
        ];

        foreach ($levels as $level) {
            Level::firstOrCreate(['level_number' => $level['level_number']], $level);
        }
    }

    private function seedUsers(int $schoolId): void
    {
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@eduplay.test'],
            [
                'name' => 'Demo Teacher',
                'password' => Hash::make('password'),
                'school_id' => $schoolId,
                'email_verified_at' => now(),
                'level' => 4,
                'total_xp' => 1250,
            ]
        );
        $teacher->assignRole('teacher');

        $students = [
            ['name' => 'Ava Patel', 'email' => 'student1@eduplay.test', 'level' => 3, 'total_xp' => 780, 'current_streak' => 5, 'longest_streak' => 8],
            ['name' => 'Noah Kim', 'email' => 'student2@eduplay.test', 'level' => 2, 'total_xp' => 420, 'current_streak' => 3, 'longest_streak' => 6],
            ['name' => 'Mia Torres', 'email' => 'student3@eduplay.test', 'level' => 1, 'total_xp' => 220, 'current_streak' => 2, 'longest_streak' => 4],
        ];

        foreach ($students as $studentData) {
            $student = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'password' => Hash::make('password'),
                    'school_id' => $schoolId,
                    'email_verified_at' => now(),
                    'level' => $studentData['level'],
                    'total_xp' => $studentData['total_xp'],
                ]
            );
            $student->assignRole('student');
        }
    }

    private function seedCourseModules(int $schoolId): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'game-design-basics'],
            [
                'school_id' => $schoolId,
                'teacher_id' => User::role('teacher')->first()?->id,
                'title' => 'Game Design Basics',
                'slug' => 'game-design-basics',
                'description' => 'A hands-on course covering game design foundations and practical web experience.',
                'thumbnail' => 'images/courses/game-design-basics.jpg',
                'category' => 'Game Design',
                'difficulty' => 'Beginner',
                'is_published' => true,
                'order' => 1,
            ]
        );

        $modules = [
            ['title' => 'Understanding Mechanics', 'order' => 1, 'duration_minutes' => 15, 'content' => ['summary' => 'Review game mechanics and feedback loops.']],
            ['title' => 'Creating Interactive Systems', 'order' => 2, 'duration_minutes' => 20, 'content' => ['summary' => 'Build a simple interactive web module.']],
            ['title' => 'Balancing Progression', 'order' => 3, 'duration_minutes' => 18, 'content' => ['summary' => 'Learn how to balance challenge and reward.']],
        ];

        foreach ($modules as $moduleData) {
            Module::firstOrCreate(
                ['course_id' => $course->id, 'title' => $moduleData['title']],
                array_merge($moduleData, ['course_id' => $course->id, 'is_locked' => false])
            );
        }
    }

    private function seedLearningPaths(): void
    {
        $paths = [
            ['title' => 'Dasar HTML', 'slug' => 'dasar-html', 'description' => 'Pelajari fondasi web dengan HTML dari nol', 'order' => 1, 'is_published' => true],
            ['title' => 'CSS & Styling Modern', 'slug' => 'css-styling', 'description' => 'Buat tampilan web yang cantik dengan CSS', 'order' => 2, 'is_published' => true],
            ['title' => 'PHP & Laravel', 'slug' => 'php-laravel', 'description' => 'Backend web development dengan PHP dan Laravel', 'order' => 3, 'is_published' => true],
        ];

        foreach ($paths as $pathData) {
            $path = LearningPath::firstOrCreate(['slug' => $pathData['slug']], $pathData);

            $topics = match ($pathData['slug']) {
                'dasar-html' => ['Pengenalan HTML', 'Tag & Elemen', 'Form & Input', 'Tabel & List', 'HTML Semantik'],
                'css-styling' => ['Dasar CSS', 'Box Model', 'Flexbox', 'Grid Layout', 'Responsive Design'],
                'php-laravel' => ['Dasar PHP', 'OOP di PHP', 'Intro Laravel', 'Routing & Controller', 'Eloquent ORM'],
                default => [],
            };

            foreach ($topics as $i => $topicTitle) {
                $topic = Topic::firstOrCreate(
                    ['slug' => Str::slug($topicTitle)],
                    [
                        'learning_path_id' => $path->id,
                        'title' => $topicTitle,
                        'order' => $i + 1,
                        'estimated_minutes' => 30,
                        'is_published' => true,
                    ]
                );

                for ($j = 1; $j <= 5; $j++) {
                    Lesson::firstOrCreate(
                        ['topic_id' => $topic->id, 'order' => $j],
                        [
                            'title' => "Materi {$j}: Bagian {$j} dari {$topicTitle}",
                            'type' => $j === 1 ? 'video' : 'article',
                            'content' => "<h2>{$topicTitle} — Bagian {$j}</h2><p>Konten materi pembelajaran untuk {$topicTitle}. Materi ini akan membahas konsep-konsep penting yang perlu kamu pahami.</p>",
                            'video_url' => $j === 1 ? 'https://www.youtube.com/embed/qz0aGYrrlhU' : null,
                            'xp_reward' => 10,
                            'is_published' => true,
                            'is_free' => $j === 1,
                        ]
                    );
                }
            }
        }
    }

    private function seedGames(int $schoolId): void
    {
        $gameTypes = [
            ['type' => 'code_puzzle', 'title' => 'Code Puzzle'],
            ['type' => 'memory_card', 'title' => 'Bug Hunter'],
            ['type' => 'typing_race', 'title' => 'Speed Typing'],
            ['type' => 'quiz_battle', 'title' => 'Quiz Code'],
            ['type' => 'drag_drop', 'title' => 'Fill the Blank'],
        ];

        $creatorId = User::first()?->id;

        foreach ($gameTypes as $gameData) {
            $game = Game::firstOrCreate(
                ['type' => $gameData['type']],
                [
                    'title' => $gameData['title'],
                    'slug' => Str::slug($gameData['title']),
                    'school_id' => $schoolId,
                    'created_by' => $creatorId,
                    'is_active' => true,
                    'config' => ['mode' => 'demo'],
                ]
            );

            for ($lvl = 1; $lvl <= 3; $lvl++) {
                GameLevel::firstOrCreate(
                    ['game_id' => $game->id, 'level_number' => $lvl],
                    [
                        'title' => "Level {$lvl}",
                        'time_limit' => 60 + ($lvl * 30),
                        'xp_reward' => 20 * $lvl,
                        'min_score_to_pass' => 70,
                        'content' => $this->getGameContent($gameData['type'], $lvl),
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function seedBadges(): void
    {
        $badges = [
            ['name' => 'HTML Hero', 'description' => 'Selesaikan semua materi HTML', 'icon' => '🏅', 'rarity' => 'common', 'category' => 'topic', 'condition' => ['type' => 'complete_lessons', 'count' => 5], 'xp_reward' => 50, 'is_active' => true],
            ['name' => 'Streak King', 'description' => 'Pertahankan streak 7 hari berturut-turut', 'icon' => '🔥', 'rarity' => 'rare', 'category' => 'achievement', 'condition' => ['type' => 'streak_days', 'days' => 7], 'xp_reward' => 100, 'is_active' => true],
            ['name' => 'Code Warrior', 'description' => 'Capai level 5', 'icon' => '⚔️', 'rarity' => 'epic', 'category' => 'achievement', 'condition' => ['type' => 'reach_level', 'level' => 5], 'xp_reward' => 150, 'is_active' => true],
            ['name' => 'Speed Demon', 'description' => 'Menang 5 kali di Speed Typing', 'icon' => '💨', 'rarity' => 'rare', 'category' => 'social', 'condition' => ['type' => 'win_battles', 'count' => 5], 'xp_reward' => 100, 'is_active' => true],
            ['name' => 'Laravel Legend', 'description' => 'Selesaikan semua materi Laravel', 'icon' => '🌟', 'rarity' => 'legendary', 'category' => 'topic', 'condition' => ['type' => 'complete_lessons', 'count' => 75], 'xp_reward' => 250, 'is_active' => true],
        ];

        foreach ($badges as $badgeData) {
            Badge::firstOrCreate(['name' => $badgeData['name']], $badgeData);
        }
    }

    private function seedUserProgressData(): void
    {
        $users = User::role('student')->get();
        $level1 = Level::where('level_number', 1)->first();

        foreach ($users as $user) {
            $totalXp = max(100, $user->total_xp ?? rand(100, 1200));
            $level = Level::findLevelByXp($totalXp) ?? $level1;

            UserXP::updateOrCreate(
                ['user_id' => $user->id],
                ['total_xp' => $totalXp, 'level_id' => $level?->id ?? $level1?->id]
            );

            Streak::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'current_streak' => rand(2, 7),
                    'longest_streak' => rand(4, 12),
                    'last_activity_date' => now()->subDays(rand(0, 1))->toDateString(),
                ]
            );

            $modules = Module::inRandomOrder()->take(2)->get();
            foreach ($modules as $module) {
                UserProgress::firstOrCreate(
                    ['user_id' => $user->id, 'module_id' => $module->id],
                    [
                        'status' => 'completed',
                        'score' => rand(80, 95),
                        'completed_at' => now()->subDays(rand(1, 5)),
                    ]
                );
            }
        }
    }

    private function getGameContent(string $type, int $level): array
    {
        return match ($type) {
            'code_puzzle' => [
                'language' => 'php',
                'description' => "Level {$level}: Susun kode PHP yang benar",
                'pieces' => ['<?php', "echo 'Hello World';", '?>'],
                'correct_order' => [0, 1, 2],
                'hints' => ['Mulai dengan tag PHP pembuka'],
            ],
            'memory_card' => [
                'description' => "Level {$level}: Temukan bug di kode berikut",
                'snippet' => '<?php echo "Hello" ?>',
                'bug' => 'missing semicolon',
                'hint' => 'Periksa akhir baris kode',
            ],
            'typing_race' => [
                'description' => "Level {$level}: Ketik kode secepat mungkin",
                'prompt' => 'echo "Hello EduPlay";',
                'time_bonus' => 5,
            ],
            'quiz_battle' => [
                'question' => 'Apa tag HTML yang digunakan untuk membuat heading level 1?',
                'options' => ['<h1>', '<heading>', '<title>', '<head>'],
                'correct' => 0,
                'explanation' => 'Tag <h1> digunakan untuk heading level 1 (terbesar)',
            ],
            'drag_drop' => [
                'description' => "Level {$level}: Lengkapi kode yang hilang",
                'template' => 'echo ___"Hello";',
                'answer' => ' ',
                'hint' => 'Gunakan titik koma di akhir',
            ],
            default => ['content' => "Level {$level} content"],
        };
    }
}
