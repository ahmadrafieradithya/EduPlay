<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LearningPath;
use App\Models\UserLessonProgress;
use App\Models\Bookmark;
use Illuminate\View\View;

class LearnController extends Controller
{
    public function index(): View
    {
        $paths = LearningPath::where('is_published', true)
            ->with(['publishedTopics.publishedLessons'])
            ->orderBy('order')
            ->get();

        $userId = auth()->id();
        $paths->each(fn($p) => $p->user_progress = $p->getProgressForUser($userId));

        return view('learn.index', compact('paths'));
    }

    public function path(LearningPath $path): View
    {
        abort_if(!$path->is_published, 404);

        $lessonIds = $path->publishedTopics->flatMap->publishedLessons->pluck('id');
        $progressMap = UserLessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $lessonIds)
            ->get()
            ->keyBy('lesson_id');

        $completedIds = $progressMap->where('status', 'completed')->keys();

        return view('learn.path', compact('path', 'progressMap', 'completedIds'));
    }

    public function lesson(Lesson $lesson): View
    {
        abort_if(!$lesson->is_published, 404);
        $lesson->load('topic.learningPath');

        $allLessons = $lesson->topic->publishedLessons;
        $idx = $allLessons->search(fn($l) => $l->id === $lesson->id);

        $completedIds = UserLessonProgress::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->pluck('lesson_id');

        // Mark as in_progress
        UserLessonProgress::firstOrCreate(
            ['user_id' => auth()->id(), 'lesson_id' => $lesson->id],
            ['status' => 'in_progress']
        );

        return view('learn.lesson', [
            'lesson'       => $lesson,
            'prevLesson'   => $idx > 0 ? $allLessons[$idx - 1] : null,
            'nextLesson'   => $idx < $allLessons->count() - 1 ? $allLessons[$idx + 1] : null,
            'completedIds' => $completedIds,
            'isBookmarked' => $lesson->isBookmarkedBy(auth()->id()),
        ]);
    }

    public function bookmarks(): View
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with('lesson.topic.learningPath')
            ->latest()
            ->get();

        return view('learn.bookmarks', compact('bookmarks'));
    }
}
