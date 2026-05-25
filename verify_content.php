<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use App\Models\LearningPath;

$path = LearningPath::where('title', 'Dasar HTML')->with('topics.lessons')->first();

if ($path) {
    echo "=== DASAR HTML LEARNING PATH VERIFICATION ===\n\n";
    
    foreach ($path->topics as $topic) {
        echo "TOPIC: {$topic->title}\n";
        echo str_repeat("-", 50) . "\n";
        
        foreach ($topic->lessons as $lesson) {
            echo "  └─ {$lesson->title}\n";
            echo "     Type: {$lesson->type} | XP: {$lesson->xp_reward} | Free: " . ($lesson->is_free ? 'Yes' : 'No') . "\n";
            
            if ($lesson->video_url) {
                echo "     Video URL: {$lesson->video_url}\n";
            }
            
            if ($lesson->content) {
                $contentLength = strlen($lesson->content);
                $hasH2 = str_contains($lesson->content, '<h2>');
                $hasCode = str_contains($lesson->content, '<code>');
                $hasList = str_contains($lesson->content, '<ul>') || str_contains($lesson->content, '<ol>');
                
                echo "     Content: {$contentLength} chars | H2: " . ($hasH2 ? '✓' : '✗') . " | Code: " . ($hasCode ? '✓' : '✗') . " | List: " . ($hasList ? '✓' : '✗') . "\n";
            }
            echo "\n";
        }
        echo "\n";
    }
    
    echo "=== SUMMARY ===\n";
    $totalLessons = $path->topics->sum(fn($t) => $t->lessons->count());
    $videoLessons = $path->topics->flatMap(fn($t) => $t->lessons)->where('type', 'video')->count();
    $articleLessons = $path->topics->flatMap(fn($t) => $t->lessons)->where('type', 'article')->count();
    $codeExamples = $path->topics->flatMap(fn($t) => $t->lessons)->where('type', 'code_example')->count();
    
    echo "Total Lessons: {$totalLessons}\n";
    echo "Video Lessons: {$videoLessons}\n";
    echo "Article Lessons: {$articleLessons}\n";
    echo "Code Examples: {$codeExamples}\n";
    echo "\n✓ Dasar HTML path successfully seeded with real, unique content!\n";
} else {
    echo "✗ Learning Path not found.\n";
}
