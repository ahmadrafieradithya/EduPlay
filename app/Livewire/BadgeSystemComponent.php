<?php

namespace App\Livewire;

use App\Models\Badge;
use App\Services\BadgeService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class BadgeSystemComponent extends Component
{
    public $badges = [];
    public $selectedRarity = 'all';
    public $userBadges = [];
    public $totalBadges = 0;
    public $unlockedCount = 0;

    protected $badgeService;

    public function mount()
    {
        $this->badgeService = app(BadgeService::class);
        $this->loadBadges();
    }

    public function loadBadges()
    {
        $query = Badge::where('is_active', true);

        if ($this->selectedRarity !== 'all') {
            $query->where('rarity', $this->selectedRarity);
        }

        $userBadgeIds = auth()->user()->badges()->pluck('badge_id')->toArray();
        
        $this->badges = $query->orderBy('created_at')->get()->map(function ($badge) use ($userBadgeIds) {
            $isUnlocked = in_array($badge->id, $userBadgeIds);
            $progress = $this->getBadgeProgress($badge);

            return [
                'id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'icon' => $badge->icon,
                'rarity' => $badge->rarity,
                'category' => $badge->category,
                'is_unlocked' => $isUnlocked,
                'progress' => $progress,
                'rarity_color' => $this->getRarityColor($badge->rarity),
                'earned_at' => $isUnlocked ? auth()->user()->badges()
                    ->where('badge_id', $badge->id)
                    ->first()?->pivot->earned_at : null,
            ];
        })->toArray();

        $this->totalBadges = Badge::where('is_active', true)->count();
        $this->unlockedCount = count($userBadgeIds);
    }

    public function filterByRarity($rarity)
    {
        $this->selectedRarity = $rarity;
        $this->loadBadges();
    }

    private function getBadgeProgress($badge): array
    {
        $condition = $badge->condition ?? [];
        $user = auth()->user();

        if ($badge->slug === 'html_beginner') {
            $completed = $user->progress()
                ->whereHas('lesson.topic.learningPath', fn($q) => 
                    $q->where('title', 'like', '%HTML%')
                )
                ->where('status', 'completed')
                ->count();
            return ['current' => $completed, 'target' => 3];
        }

        if ($badge->slug === 'streak_warrior') {
            $streak = $user->streak?->current_streak ?? 0;
            return ['current' => $streak, 'target' => 7];
        }

        return ['current' => 0, 'target' => 1];
    }

    private function getRarityColor($rarity): string
    {
        return match($rarity) {
            'common' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100',
            'rare' => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
            'epic' => 'bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100',
            'legendary' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function render()
    {
        return view('livewire.badge-system');
    }
}
