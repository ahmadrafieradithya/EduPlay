<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Services\BadgeService;
use App\Services\StreakService;
use App\Services\XPService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LessonPlayer extends Component
{
    public Lesson $lesson;
    public bool $isCompleted = false;
    public bool $showXpAnimation = false;
    public int $xpEarned = 0;

    #[\Livewire\Attributes\On('lesson-completed')]
    public function onLessonCompleted($data = []): void
    {
        // Handle any external lesson completion events
    }

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
        $progress = auth()->user()->progress()
            ->where('lesson_id', $lesson->id)
            ->first();
        $this->isCompleted = $progress?->status === 'completed';
    }

    public function markComplete(): void
    {
        if ($this->isCompleted) {
            return;
        }

        $user = auth()->user();

        // Update progress
        $user->progress()->updateOrCreate(
            ['lesson_id' => $this->lesson->id],
            ['status' => 'completed', 'completed_at' => now()]
        );

        // Award XP
        $this->xpEarned = $this->lesson->xp_reward ?? 10;
        app(XPService::class)->award(
            $user,
            'lesson_completed',
            $this->xpEarned,
            ['lesson_id' => $this->lesson->id]
        );

        // Update streak
        app(StreakService::class)->updateStreak($user);

        $this->isCompleted = true;
        $this->showXpAnimation = true;

        // Check and award badges
        app(BadgeService::class)->checkAndAward($user);

        $this->dispatch('lesson-completed', xp: $this->xpEarned);
    }

    public function render(): View
    {
        return view('livewire.lesson-player');
    }
}
