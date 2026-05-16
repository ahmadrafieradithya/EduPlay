<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\UserProgress;
use App\Services\XPService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LessonPlayer extends Component
{
    public $lesson;
    public $userProgress;
    public $nextLesson;
    public $previousLesson;
    public $isCompleted = false;
    public $xpGained = 0;
    public $showCompletionModal = false;

    protected $xpService;

    public function mount(Lesson $lesson)
    {
        $this->xpService = app(XPService::class);
        $this->lesson = $lesson->load('topic.learningPath');
        
        $this->userProgress = auth()->user()->progress()
            ->where('lesson_id', $lesson->id)
            ->first();
        
        $this->isCompleted = $this->userProgress?->status === 'completed';

        // Get next and previous lessons
        $topic = $lesson->topic;
        $this->nextLesson = $topic->lessons()
            ->where('order', '>', $lesson->order)
            ->orderBy('order')
            ->first();
        
        $this->previousLesson = $topic->lessons()
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    public function completeLesson()
    {
        if ($this->isCompleted) {
            return;
        }

        // Create or update progress
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $this->lesson->id,
            ],
            [
                'status' => 'completed',
                'completed_at' => now(),
            ]
        );

        // Award XP
        $this->xpGained = $this->lesson->xp_reward ?? 50;
        $this->xpService->reward(
            auth()->user(),
            'lesson_complete',
            $this->xpGained,
            ['lesson_id' => $this->lesson->id]
        );

        // Update streak
        $streakService = app(\App\Services\StreakService::class);
        $streakService->updateStreak(auth()->user());

        // Check for badges
        $badgeService = app(\App\Services\BadgeService::class);
        $newBadges = $badgeService->checkAndAward(auth()->user());

        $this->isCompleted = true;
        $this->showCompletionModal = true;

        $this->dispatch('lesson-completed', [
            'xp' => $this->xpGained,
            'lesson' => $this->lesson->title,
            'newBadges' => count($newBadges),
        ]);
    }

    public function goToNextLesson()
    {
        if ($this->nextLesson) {
            return redirect()->route('learn.lesson', $this->nextLesson);
        }
    }

    public function render()
    {
        return view('livewire.lesson-player');
    }
}
