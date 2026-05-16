<?php

namespace App\Livewire;

use App\Models\Battle;
use App\Models\GameRoom;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class BattleLobby extends Component
{
    public $rooms = [];
    public $currentUserRating = 0;
    public $showCreateRoomModal = false;
    public $roomName = '';
    public $selectedQuestion = null;
    public $questionFilter = 'all';

    public function mount()
    {
        $this->loadRooms();
        $this->currentUserRating = auth()->user()->playerRating?->elo_rating ?? 1000;
    }

    public function loadRooms()
    {
        $this->rooms = GameRoom::where('status', 'waiting')
            ->with(['creator', 'players'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($room) {
                return [
                    'id' => $room->id,
                    'code' => $room->room_code,
                    'name' => $room->name,
                    'creator' => $room->creator->name,
                    'players' => $room->players->count(),
                    'max_players' => $room->max_players,
                    'difficulty' => $room->difficulty,
                    'is_full' => $room->players->count() >= $room->max_players,
                ];
            })
            ->toArray();
    }

    public function joinRoom($roomId)
    {
        $room = GameRoom::findOrFail($roomId);
        
        if ($room->players->count() >= $room->max_players) {
            $this->addError('room', 'Ruangan sudah penuh!');
            return;
        }

        $room->players()->attach(auth()->id());
        
        return redirect()->route('battle.arena', $room->id);
    }

    public function createRoom()
    {
        $this->validate(['roomName' => 'required|string|max:50']);

        $room = GameRoom::create([
            'creator_id' => auth()->id(),
            'name' => $this->roomName,
            'room_code' => strtoupper(substr(md5(time()), 0, 6)),
            'difficulty' => 'medium',
            'max_players' => 2,
            'status' => 'waiting',
        ]);

        $room->players()->attach(auth()->id());

        $this->reset(['roomName', 'showCreateRoomModal']);
        $this->loadRooms();

        return redirect()->route('battle.arena', $room->id);
    }

    public function render()
    {
        return view('livewire.battle-lobby');
    }
}
