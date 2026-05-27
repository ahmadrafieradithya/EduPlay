<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\LearningPath;
use App\Models\Topic;
use App\Models\Lesson;

$paths = LearningPath::with('topics.lessons')->get();
echo "=== SEEDING VERIFICATION ===\n\n";

foreach ($paths as $path) {
    $topicCount = $path->topics->count();
    $lessonCount = $path->topics->sum(fn($t) => $t->lessons->count());
    echo "✓ {$path->title} ({$path->estimated_hours}h)\n";
    echo "  - Topics: {$topicCount}\n";
    echo "  - Lessons: {$lessonCount}\n\n";
}

$totalPaths = LearningPath::count();
$totalTopics = Topic::count();
$totalLessons = Lesson::count();

echo "=== SUMMARY ===\n";
echo "Total Paths: {$totalPaths}\n";
echo "Total Topics: {$totalTopics}\n";
echo "Total Lessons: {$totalLessons}\n";
