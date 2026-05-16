<?php

namespace App\Livewire;

use App\Models\Topic;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TopicDetail extends Component
{
    public $topic;
    public $lessons = [];
    public $userProgress = [];

    public function mount(Topic $topic)
    {
        $this->topic = $topic->load(['learningPath', 'lessons']);
        
        $this->lessons = $this->topic->lessons()
            ->where('is_published', true)
            ->orderBy('order')
            ->get()
            ->map(function ($lesson) {
                $progress = auth()->user()->progress()
                    ->where('lesson_id', $lesson->id)
                    ->first();
                
                return [
                    'lesson' => $lesson,
                    'completed' => $progress?->status === 'completed',
                    'started' => $progress !== null,
                    'is_locked' => false, // TODO: Implement lock system
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.topic-detail');
    }
}
