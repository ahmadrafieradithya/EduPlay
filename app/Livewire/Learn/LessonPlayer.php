<?php

namespace App\Livewire\Learn;

use App\Models\Lesson;
use App\Models\UserLessonProgress;
use App\Services\XPService;
use App\Services\StreakService;
use App\Services\BadgeService;
use Livewire\Component;

class LessonPlayer extends Component
{
    public Lesson $lesson;
    public bool $isCompleted = false;
    public bool $showXpAnimation = false;
    public int $xpEarned = 0;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
        $progress = UserLessonProgress::where('user_id', auth()->id())
            ->where('lesson_id', $lesson->id)
            ->first();
        $this->isCompleted = $progress?->status === UserLessonProgress::STATUS_COMPLETED;
    }

    public function markComplete(): void
    {
        if ($this->isCompleted) return;

        $user = auth()->user();

        // Update lesson progress
        UserLessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $this->lesson->id],
            [
                'status' => UserLessonProgress::STATUS_COMPLETED,
                'completed_at' => now(),
            ]
        );

        // Award XP
        $this->xpEarned = $this->lesson->xp_reward;
        app(XPService::class)->award(
            $user,
            'lesson_completed',
            $this->xpEarned,
            ['lesson_id' => $this->lesson->id]
        );

        // Update streak
        app(StreakService::class)->updateStreak($user);

        // Check and award badges
        app(BadgeService::class)->checkAndAward($user);

        // Set completion state
        $this->isCompleted = true;
        $this->showXpAnimation = true;

        // Dispatch event for parent components to listen
        $this->dispatch('lesson-completed', 
            xp: $this->xpEarned, 
            lessonId: $this->lesson->id
        );

        // Auto hide animation after 3 seconds
        $this->js("setTimeout(() => \$wire.hideXpAnimation(), 3000)");
    }

    public function hideXpAnimation(): void
    {
        $this->showXpAnimation = false;
    }

    public function render()
    {
        return view('livewire.learn.lesson-player');
    }
}
