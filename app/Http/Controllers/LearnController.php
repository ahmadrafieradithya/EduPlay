<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LearningPath;
use App\Models\Topic;
use App\Models\UserProgress;
use Illuminate\Support\Facades\DB;

class LearnController extends Controller
{
    public function index()
    {
        $paths = LearningPath::where('is_published', true)
            ->with('topics.lessons')
            ->get()
            ->map(function ($path) {
                $userProgress = auth()->user()->progress()
                    ->whereIn('lesson_id', $path->topics->pluck('lessons.*.id')->flatten())
                    ->where('status', 'completed')
                    ->count();
                
                $totalLessons = $path->topics->sum(fn($topic) => $topic->lessons->count());
                $path->user_progress_count = $userProgress;
                $path->user_progress_percent = $totalLessons > 0 ? round(($userProgress / $totalLessons) * 100) : 0;
                $path->total_lessons = $totalLessons;
                
                return $path;
            });

        return view('learn.index', compact('paths'));
    }

    public function path(LearningPath $path)
    {
        abort_if(!$path->is_published, 404);

        $topics = $path->topics()
            ->where('is_published', true)
            ->with('lessons')
            ->orderBy('order')
            ->get()
            ->map(function ($topic) {
                $completedLessons = auth()->user()->progress()
                    ->whereIn('lesson_id', $topic->lessons->pluck('id'))
                    ->where('status', 'completed')
                    ->count();
                
                $totalLessons = $topic->lessons->count();
                $topic->completed_count = $completedLessons;
                $topic->total_lessons = $totalLessons;
                $topic->progress_percent = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                
                return $topic;
            });

        return view('learn.path', compact('path', 'topics'));
    }

    public function lesson(Lesson $lesson)
    {
        abort_if(!$lesson->topic->learningPath->is_published || !$lesson->is_published, 404);

        $topic = $lesson->topic;
        $path = $topic->learningPath;

        $allLessons = $topic->lessons()
            ->where('is_published', true)
            ->orderBy('order')
            ->get();

        $currentIndex = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        $userProgress = auth()->user()->progress()
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('learn.lesson', compact('lesson', 'topic', 'path', 'prevLesson', 'nextLesson', 'userProgress', 'allLessons'));
    }
}
