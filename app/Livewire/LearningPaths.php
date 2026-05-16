<?php

namespace App\Livewire;

use App\Models\LearningPath;
use Livewire\Component;

class LearningPaths extends Component
{
    public $learningPaths;

    public function mount()
    {
        $this->learningPaths = LearningPath::all();
    }

    public function render()
    {
        return view('livewire.learning-paths');
    }
}