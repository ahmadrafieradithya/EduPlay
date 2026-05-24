<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            // Common Badges
            [
                'name' => 'First Step',
                'description' => 'Menyelesaikan lesson pertama',
                'icon' => '👣',
                'rarity' => 'common',
                'category' => 'achievement',
                'condition' => ['lessons_completed' => 1],
                'xp_reward' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Learner',
                'description' => 'Menyelesaikan 5 lesson',
                'icon' => '📚',
                'rarity' => 'common',
                'category' => 'achievement',
                'condition' => ['lessons_completed' => 5],
                'xp_reward' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Streak Week',
                'description' => 'Belajar 7 hari berturut-turut',
                'icon' => '🔥',
                'rarity' => 'common',
                'category' => 'streak',
                'condition' => ['current_streak' => 7],
                'xp_reward' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'First Victory',
                'description' => 'Menang pertama kali di game',
                'icon' => '🎮',
                'rarity' => 'common',
                'category' => 'gaming',
                'condition' => ['games_won' => 1],
                'xp_reward' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Quiz Master',
                'description' => 'Menyelesaikan 10 quiz',
                'icon' => '❓',
                'rarity' => 'common',
                'category' => 'achievement',
                'condition' => ['quizzes_completed' => 10],
                'xp_reward' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Quick Typer',
                'description' => 'Menyelesaikan typing race dengan score tinggi',
                'icon' => '⌨️',
                'rarity' => 'common',
                'category' => 'gaming',
                'condition' => ['typing_score_above' => 80],
                'xp_reward' => 35,
                'is_active' => true,
            ],
            [
                'name' => 'Code Reader',
                'description' => 'Membaca 50 code snippet',
                'icon' => '👁️',
                'rarity' => 'common',
                'category' => 'achievement',
                'condition' => ['snippets_read' => 50],
                'xp_reward' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Social Butterfly',
                'description' => 'Membuat 5 forum posts',
                'icon' => '🦋',
                'rarity' => 'common',
                'category' => 'community',
                'condition' => ['forum_posts' => 5],
                'xp_reward' => 30,
                'is_active' => true,
            ],

            // Rare Badges
            [
                'name' => 'Path Master',
                'description' => 'Menyelesaikan seluruh learning path',
                'icon' => '🗺️',
                'rarity' => 'rare',
                'category' => 'achievement',
                'condition' => ['paths_completed' => 1],
                'xp_reward' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Bug Slayer',
                'description' => 'Memenangkan 25 bug fix games',
                'icon' => '🐛',
                'rarity' => 'rare',
                'category' => 'gaming',
                'condition' => ['bug_fix_wins' => 25],
                'xp_reward' => 150,
                'is_active' => true,
            ],
            [
                'name' => 'HTML Expert',
                'description' => 'Mendapatkan level HTML mastery',
                'icon' => '🏷️',
                'rarity' => 'rare',
                'category' => 'skill',
                'condition' => ['skill_level' => ['html' => 5]],
                'xp_reward' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'CSS Wizard',
                'description' => 'Mendapatkan level CSS mastery',
                'icon' => '🎨',
                'rarity' => 'rare',
                'category' => 'skill',
                'condition' => ['skill_level' => ['css' => 5]],
                'xp_reward' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Month Streak',
                'description' => 'Belajar 30 hari berturut-turut',
                'icon' => '🔥🔥',
                'rarity' => 'rare',
                'category' => 'streak',
                'condition' => ['current_streak' => 30],
                'xp_reward' => 200,
                'is_active' => true,
            ],
            [
                'name' => 'Battle Champion',
                'description' => 'Menang 10 battles berturut-turut',
                'icon' => '⚔️',
                'rarity' => 'rare',
                'category' => 'gaming',
                'condition' => ['battle_streak' => 10],
                'xp_reward' => 180,
                'is_active' => true,
            ],
            [
                'name' => 'Leaderboard Hero',
                'description' => 'Masuk top 10 leaderboard',
                'icon' => '🏆',
                'rarity' => 'rare',
                'category' => 'achievement',
                'condition' => ['leaderboard_rank' => 10],
                'xp_reward' => 150,
                'is_active' => true,
            ],

            // Epic Badges
            [
                'name' => 'Full Stack Warrior',
                'description' => 'Menyelesaikan HTML, CSS, dan PHP path',
                'icon' => '🚀',
                'rarity' => 'epic',
                'category' => 'achievement',
                'condition' => ['paths_completed' => 3],
                'xp_reward' => 300,
                'is_active' => true,
            ],
            [
                'name' => 'Legendary Coder',
                'description' => 'Mencapai 10000 total XP',
                'icon' => '👑',
                'rarity' => 'epic',
                'category' => 'achievement',
                'condition' => ['total_xp' => 10000],
                'xp_reward' => 250,
                'is_active' => true,
            ],
            [
                'name' => 'Game Lord',
                'description' => 'Memenangkan 100 games',
                'icon' => '👾',
                'rarity' => 'epic',
                'category' => 'gaming',
                'condition' => ['games_won' => 100],
                'xp_reward' => 300,
                'is_active' => true,
            ],

            // Legendary Badge
            [
                'name' => 'Laravel Legend',
                'description' => 'Menjadi the ultimate Laravel master',
                'icon' => '⭐',
                'rarity' => 'legendary',
                'category' => 'achievement',
                'condition' => ['total_xp' => 55000, 'level' => 20],
                'xp_reward' => 500,
                'is_active' => true,
            ],
        ];

        foreach ($badges as $badgeData) {
            Badge::updateOrCreate(
                ['name' => $badgeData['name']],
                $badgeData
            );
        }
    }
}
