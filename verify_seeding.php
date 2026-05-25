<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use App\Models\LearningPath;

$path = LearningPath::where('title', 'Dasar HTML')->with('topics.lessons')->first();

if ($path) {
    echo "✓ Learning Path Found: " . $path->title . "\n";
    echo "✓ Topics Count: " . $path->topics->count() . "\n";
    
    $totalLessons = 0;
    foreach ($path->topics as $topic) {
        echo "  - Topic: " . $topic->title . " (" . $topic->lessons->count() . " lessons)\n";
        $totalLessons += $topic->lessons->count();
        
        foreach ($topic->lessons->take(2) as $lesson) {
            echo "    - " . $lesson->title . " (" . $lesson->type . ", XP: " . $lesson->xp_reward . ")\n";
        }
    }
    
    echo "\n✓ Total Lessons: " . $totalLessons . "\n";
    echo "✓ Seeding completed successfully!\n";
} else {
    echo "✗ Learning Path 'Dasar HTML' not found.\n";
    $allPaths = LearningPath::all();
    echo "Available paths: " . $allPaths->pluck('title')->implode(', ') . "\n";
}
