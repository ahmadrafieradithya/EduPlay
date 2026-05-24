<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use App\Models\Streak;
use App\Models\UserProgress;
use App\Models\UserXP;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LessonActions extends Component
{
    public Lesson $lesson;
    public ?UserProgress $progress = null;
    public bool $completed = false;

    protected $listeners = [
        'markComplete' => 'markComplete',
    ];

    public function mount($lesson)
    {
        $this->lesson = is_object($lesson) ? $lesson : Lesson::findOrFail($lesson);
        $this->progress = auth()->user()->progress()->where('lesson_id', $this->lesson->id)->first();
        $this->completed = $this->progress && $this->progress->status === 'completed';
    }

    public function markComplete()
    {
        $user = auth()->user();
        if (!$user) {
            return $this->dispatchBrowserEvent('notify', ['type' => 'error', 'message' => 'Login required']);
        }

        if ($this->completed) {
            return; // already completed
        }

        // create or update progress
        $progress = UserProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $this->lesson->id],
            [
                'status' => 'completed',
                'score' => 100,
                'completed_at' => now(),
            ]
        );

        // Update total xp on user and user_xp table
        $xp = (int) ($this->lesson->xp_reward ?? 10);
        $user->increment('total_xp', $xp);

        $userXp = UserXP::firstOrCreate(['user_id' => $user->id], ['total_xp' => 0]);
        $userXp->increment('total_xp', $xp);

        // Update streak
        $streak = Streak::firstOrCreate(['user_id' => $user->id], ['current_streak' => 0, 'longest_streak' => 0, 'last_activity_date' => now()->toDateString()]);
        $today = now()->toDateString();
        if ($streak->last_activity_date && $streak->last_activity_date->toDateString() === $today) {
            // already updated today
        } else {
            $yesterday = now()->subDay()->toDateString();
            if ($streak->last_activity_date && $streak->last_activity_date->toDateString() === $yesterday) {
                $streak->current_streak += 1;
            } else {
                $streak->current_streak = 1;
            }
            $streak->last_activity_date = $today;
            $streak->longest_streak = max($streak->longest_streak, $streak->current_streak);
            $streak->save();
        }

        $this->progress = $progress;
        $this->completed = true;

        // emit event to animate XP
        $this->dispatchBrowserEvent('xp-gained', ['xp' => $xp]);
        $this->emitUp('lessonCompleted', $this->lesson->id);
    }

    public function render()
    {
        return view('livewire.lesson-actions');
    }
}
