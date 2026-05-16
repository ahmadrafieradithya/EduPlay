<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LeaderboardComponent extends Component
{
    public $activeTab = 'global';
    public $topThree = [];
    public $rankings = [];
    public $currentUserRank = null;
    public $period = 'all_time';

    protected $tabs = ['global', 'weekly', 'classroom', 'school'];

    public function mount()
    {
        $this->loadLeaderboard();
    }

    public function loadLeaderboard()
    {
        $query = User::query()
            ->select('users.*')
            ->selectRaw('COUNT(DISTINCT ub.id) as badge_count')
            ->selectRaw('(SELECT COUNT(*) FROM user_progress up WHERE up.user_id = users.id AND up.status = "completed") as lessons_completed')
            ->leftJoin('user_badges as ub', 'users.id', '=', 'ub.user_id')
            ->groupBy('users.id')
            ->orderByDesc('total_xp');

        // Apply school filter if classroom selected
        if ($this->activeTab === 'classroom' && auth()->user()->classroom) {
            $query->whereHas('classrooms', fn($q) => 
                $q->where('classroom_id', auth()->user()->classrooms->first()->id)
            );
        } elseif ($this->activeTab === 'school') {
            $query->where('school_id', auth()->user()->school_id);
        }

        // Apply period filter
        if ($this->period !== 'all_time') {
            $startDate = match($this->period) {
                'weekly' => now()->startOfWeek(),
                'monthly' => now()->startOfMonth(),
                default => null,
            };

            if ($startDate) {
                $query->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM xp_transactions WHERE user_id = users.id AND created_at >= ?) as period_xp', [$startDate])
                    ->orderByRaw('period_xp DESC');
            }
        }

        $allUsers = $query->limit(100)->get();

        // Get top 3
        $this->topThree = $allUsers->take(3)->map(function ($user, $index) {
            return [
                'rank' => $index + 1,
                'user' => $user,
                'xp' => $user->total_xp,
                'level' => $user->level ?? 1,
                'medal' => ['🥇', '🥈', '🥉'][$index],
            ];
        })->toArray();

        // Get full ranking
        $this->rankings = $allUsers->map(function ($user, $index) {
            return [
                'rank' => $index + 1,
                'user' => $user,
                'xp' => $user->total_xp,
                'level' => $user->level ?? 1,
                'badges' => $user->badge_count ?? 0,
                'lessons' => $user->lessons_completed ?? 0,
                'is_current' => $user->id === auth()->id(),
            ];
        })->toArray();

        // Find current user rank
        $this->currentUserRank = collect($this->rankings)
            ->firstWhere('is_current', true);
    }

    public function switchTab($tab)
    {
        if (in_array($tab, $this->tabs)) {
            $this->activeTab = $tab;
            $this->loadLeaderboard();
        }
    }

    public function switchPeriod($period)
    {
        $this->period = $period;
        $this->loadLeaderboard();
    }

    public function render()
    {
        return view('livewire.leaderboard');
    }
}
