<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'level_number' => 1,
                'title' => 'Murid Baru',
                'min_xp' => 0,
                'max_xp' => 100,
                'badge_icon' => '🌱',
                'perks' => ['welcome_badge', 'start_learning'],
            ],
            [
                'level_number' => 2,
                'title' => 'Pemula Tekun',
                'min_xp' => 101,
                'max_xp' => 250,
                'badge_icon' => '📚',
                'perks' => ['unlock_quizzes', 'daily_challenges'],
            ],
            [
                'level_number' => 3,
                'title' => 'Pelajar Bersemangat',
                'min_xp' => 251,
                'max_xp' => 500,
                'badge_icon' => '⚡',
                'perks' => ['unlock_games', 'leaderboard_access'],
            ],
            [
                'level_number' => 4,
                'title' => 'Coder Pemula',
                'min_xp' => 501,
                'max_xp' => 750,
                'badge_icon' => '💻',
                'perks' => ['code_editor_access', 'snippet_sharing'],
            ],
            [
                'level_number' => 5,
                'title' => 'Pengembang Muda',
                'min_xp' => 751,
                'max_xp' => 1000,
                'badge_icon' => '🎯',
                'perks' => ['battles_unlock', 'advanced_challenges'],
            ],
            [
                'level_number' => 6,
                'title' => 'Pengembang Percaya Diri',
                'min_xp' => 1001,
                'max_xp' => 1500,
                'badge_icon' => '🔥',
                'perks' => ['team_challenges', 'badge_rewards'],
            ],
            [
                'level_number' => 7,
                'title' => 'Expert HTML',
                'min_xp' => 1501,
                'max_xp' => 2000,
                'badge_icon' => '🏷️',
                'perks' => ['html_master_badge', 'html_projects'],
            ],
            [
                'level_number' => 8,
                'title' => 'CSS Wizard',
                'min_xp' => 2001,
                'max_xp' => 3000,
                'badge_icon' => '🎨',
                'perks' => ['css_master_badge', 'design_challenges'],
            ],
            [
                'level_number' => 9,
                'title' => 'JavaScript Ninja',
                'min_xp' => 3001,
                'max_xp' => 4500,
                'badge_icon' => '🥷',
                'perks' => ['js_master_badge', 'advanced_games'],
            ],
            [
                'level_number' => 10,
                'title' => 'Full Stack Developer',
                'min_xp' => 4501,
                'max_xp' => 6000,
                'badge_icon' => '🚀',
                'perks' => ['fullstack_access', 'api_projects'],
            ],
            [
                'level_number' => 11,
                'title' => 'PHP Enthusiast',
                'min_xp' => 6001,
                'max_xp' => 8000,
                'badge_icon' => '🐘',
                'perks' => ['php_expert_mode', 'database_access'],
            ],
            [
                'level_number' => 12,
                'title' => 'Laravel Apprentice',
                'min_xp' => 8001,
                'max_xp' => 10000,
                'badge_icon' => '🪜',
                'perks' => ['laravel_projects', 'advanced_routing'],
            ],
            [
                'level_number' => 13,
                'title' => 'Backend Master',
                'min_xp' => 10001,
                'max_xp' => 13000,
                'badge_icon' => '⚙️',
                'perks' => ['backend_expert', 'database_design'],
            ],
            [
                'level_number' => 14,
                'title' => 'Database Architect',
                'min_xp' => 13001,
                'max_xp' => 16000,
                'badge_icon' => '🏗️',
                'perks' => ['advanced_sql', 'optimization_tools'],
            ],
            [
                'level_number' => 15,
                'title' => 'DevOps Specialist',
                'min_xp' => 16001,
                'max_xp' => 20000,
                'badge_icon' => '🔧',
                'perks' => ['deployment_access', 'server_management'],
            ],
            [
                'level_number' => 16,
                'title' => 'Tech Lead',
                'min_xp' => 20001,
                'max_xp' => 25000,
                'badge_icon' => '👨‍💼',
                'perks' => ['mentor_mode', 'code_review_access'],
            ],
            [
                'level_number' => 17,
                'title' => 'Architect',
                'min_xp' => 25001,
                'max_xp' => 35000,
                'badge_icon' => '🏛️',
                'perks' => ['system_design', 'consulting_mode'],
            ],
            [
                'level_number' => 18,
                'title' => 'Innovation Master',
                'min_xp' => 35001,
                'max_xp' => 45000,
                'badge_icon' => '💡',
                'perks' => ['create_courses', 'advanced_analytics'],
            ],
            [
                'level_number' => 19,
                'title' => 'Visionary Developer',
                'min_xp' => 45001,
                'max_xp' => 55000,
                'badge_icon' => '👁️',
                'perks' => ['vision_mode', 'strategic_planning'],
            ],
            [
                'level_number' => 20,
                'title' => 'Laravel Legend',
                'min_xp' => 55001,
                'max_xp' => 99999,
                'badge_icon' => '🏆',
                'perks' => ['legendary_status', 'vip_access', 'lifetime_premium'],
            ],
        ];

        foreach ($levels as $levelData) {
            Level::updateOrCreate(
                ['level_number' => $levelData['level_number']],
                $levelData
            );
        }
    }
}
