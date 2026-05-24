<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\GameLevel;
use App\Models\PlayerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BattleController extends Controller
{
    /**
     * Show battle lobby
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Ensure player rating exists for current user
        $myRating = PlayerRating::firstOrCreate(
            ['user_id' => $user->id],
            ['elo_rating' => 1000, 'wins' => 0, 'losses' => 0, 'rank_title' => PlayerRating::getRankTitle(1000)]
        );

        // Recent public battles (last 5)
        $recentBattles = Battle::with(['host', 'winner', 'level'])
            ->latest()
            ->take(5)
            ->get();

        // Top players by elo
        $topPlayers = PlayerRating::with('user')
            ->orderByDesc('elo_rating')
            ->take(10)
            ->get();

        // Available game levels (only from published games)
        $gameLevels = GameLevel::whereHas('game', fn($q) => $q->where('is_published', true))
            ->where('is_active', true)
            ->with('game')
            ->get();

        return view('battle.index', compact('myRating', 'recentBattles', 'topPlayers', 'gameLevels'));
    }

    /**
     * Create a new battle and add host as participant
     */
    public function create(Request $request)
    {
        $request->validate([
            'game_level_id' => 'required|exists:game_levels,id',
        ]);

        $user = $request->user();

        $battle = Battle::create([
            'code' => Battle::generateCode(),
            'host_id' => $user->id,
            'game_level_id' => $request->get('game_level_id'),
            'status' => 'waiting',
            'max_participants' => 2,
        ]);

        // Insert participant in pivot table (battle_participants)
        DB::table('battle_participants')->insert([
            'battle_id' => $battle->id,
            'user_id' => $user->id,
            'joined_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('battle.room', ['code' => $battle->code]);
    }

    /**
     * Join an existing waiting battle by code
     */
    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|size:6',
        ]);

        $code = strtoupper($request->get('code'));

        $battle = Battle::where('code', $code)->where('status', 'waiting')->firstOrFail();

        if ($battle->isFull()) {
            return back()->withErrors(['code' => 'Ruang sudah penuh.']);
        }

        $user = $request->user();

        // Prevent double join
        if ($battle->participants()->where('user_id', $user->id)->exists()) {
            return redirect()->route('battle.room', ['code' => $battle->code]);
        }

        DB::table('battle_participants')->insert([
            'battle_id' => $battle->id,
            'user_id' => $user->id,
            'joined_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('battle.room', ['code' => $battle->code]);
    }

    /**
     * Room view for a battle
     */
    public function room(string $code)
    {
        $battle = Battle::with(['host', 'participants', 'level'])->where('code', strtoupper($code))->firstOrFail();

        $user = auth()->user();

        $isParticipant = $battle->participants()->where('user_id', $user->id)->exists();

        if (! $isParticipant) {
            abort(403, 'Anda bukan peserta di battle ini.');
        }

        return view('battle.room', compact('battle'));
    }
}
