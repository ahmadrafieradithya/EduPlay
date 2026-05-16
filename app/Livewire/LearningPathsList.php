<?php

namespace App\Livewire;

use App\Models\LearningPath;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LearningPaths extends Component
{
    public $paths = [];
    public $selectedDifficulty = 'all';
    public $searchTerm = '';

    public function mount()
    {
        $this->loadPaths();
    }

    public function loadPaths()
    {
        $query = LearningPath::where('is_published', true)
            ->with(['topics' => function ($q) {
                $q->where('is_published', true)->with('lessons');
            }])
            ->orderBy('order');

        if ($this->selectedDifficulty !== 'all') {
            $query->where('difficulty', $this->selectedDifficulty);
        }

        if ($this->searchTerm) {
            $query->where('title', 'like', '%' . $this->searchTerm . '%');
        }

        $this->paths = $query->get()->map(function ($path) {
            $userProgress = auth()->user()->progress()
                ->whereIn('lesson_id', $path->topics->pluck('lessons.*.id')->flatten())
                ->where('status', 'completed')
                ->count();
            
            $totalLessons = $path->topics->sum(fn($topic) => $topic->lessons->count());
            $path->user_progress_count = $userProgress;
            $path->user_progress_percent = $totalLessons > 0 ? round(($userProgress / $totalLessons) * 100) : 0;
            $path->total_lessons = $totalLessons;
            $path->total_xp = $path->topics->sum(fn($topic) => 
                $topic->lessons->sum('xp_reward')
            );
            
            return $path;
        })->toArray();
    }

    public function filterByDifficulty($difficulty)
    {
        $this->selectedDifficulty = $difficulty;
        $this->loadPaths();
    }

    public function search($term)
    {
        $this->searchTerm = $term;
        $this->loadPaths();
    }

    public function render()
    {
        return view('livewire.learning-paths');
    }
}
