<?php

namespace App\Livewire\Learn;

use App\Models\Lesson;
use App\Models\Bookmark;
use Livewire\Component;

class BookmarkButton extends Component
{
    public Lesson $lesson;
    public bool $isBookmarked = false;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
        $this->isBookmarked = $lesson->isBookmarkedBy(auth()->id());
    }

    public function toggle(): void
    {
        $user = auth()->user();
        if ($this->isBookmarked) {
            Bookmark::where('user_id', $user->id)
                ->where('lesson_id', $this->lesson->id)
                ->delete();
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'lesson_id' => $this->lesson->id,
            ]);
        }
        $this->isBookmarked = !$this->isBookmarked;
    }

    public function render()
    {
        return view('livewire.learn.bookmark-button');
    }
}
