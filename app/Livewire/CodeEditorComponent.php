<?php

namespace App\Livewire;

use App\Models\CodeSnippet;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class CodeEditorComponent extends Component
{
    use WithPagination;

    public $code = '';
    public $language = 'javascript';
    public $title = '';
    public $isPublic = false;
    public $showSaveModal = false;
    public $mySnippets = [];
    public $selectedSnippet = null;

    public function mount()
    {
        $this->loadMySnippets();
    }

    public function loadMySnippets()
    {
        $this->mySnippets = CodeSnippet::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($snippet) {
                return [
                    'id' => $snippet->id,
                    'title' => $snippet->title,
                    'slug' => $snippet->slug,
                    'language' => $snippet->language,
                    'is_public' => $snippet->is_public,
                    'views' => $snippet->views_count ?? 0,
                    'created_at' => $snippet->created_at->diffForHumans(),
                ];
            })
            ->toArray();
    }

    public function changeLanguage($language)
    {
        $this->language = $language;
    }

    public function saveSnippet()
    {
        $this->validate([
            'title' => 'required|string|max:100',
            'code' => 'required|string',
            'language' => 'required|in:html,css,javascript,php',
        ]);

        $slug = \Str::slug($this->title) . '-' . \Str::random(6);

        CodeSnippet::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => $slug,
            'code' => $this->code,
            'language' => $this->language,
            'is_public' => $this->isPublic,
        ]);

        $this->reset(['title', 'showSaveModal', 'isPublic']);
        $this->loadMySnippets();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Code snippet saved! 🎉'
        ]);
    }

    public function loadSnippet($snippetId)
    {
        $snippet = CodeSnippet::findOrFail($snippetId);
        
        if ($snippet->user_id !== auth()->id() && !$snippet->is_public) {
            abort(403);
        }

        $this->code = $snippet->code;
        $this->language = $snippet->language;
        $this->title = $snippet->title;
        $this->selectedSnippet = $snippet->id;
    }

    public function deleteSnippet($snippetId)
    {
        $snippet = CodeSnippet::findOrFail($snippetId);
        
        if ($snippet->user_id !== auth()->id()) {
            abort(403);
        }

        $snippet->delete();
        $this->reset(['selectedSnippet']);
        $this->loadMySnippets();
    }

    public function render()
    {
        return view('livewire.code-editor');
    }
}
