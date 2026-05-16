<?php

namespace App\Livewire;

use App\Models\Classroom;
use App\Models\UserBadge;
use App\Models\UserXP;
use Livewire\Component;

class Dashboard extends Component
{
    public $progressCount;
    public $xpEarned;
    public $achievementCount;
    public $classroomCount;

    public function mount()
    {
        $user = auth()->user();
        $this->progressCount = $user->progress()->count();
        $this->xpEarned = $user->total_xp ?? 0;
        $this->achievementCount = $user->badges()->count();
        $this->classroomCount = Classroom::where('school_id', $user->school_id)->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}