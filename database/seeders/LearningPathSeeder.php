<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LearningPathSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Learning Path 1: Dasar HTML
        $htmlPath = LearningPath::updateOrCreate(
            ['slug' => Str::slug('Dasar HTML')],
            [
                'title' => 'Dasar HTML',
                'description' => 'Pelajari fundamentals HTML untuk membangun struktur website yang kuat dan semantic.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=300&fit=crop',
                'order' => 1,
                'difficulty' => 'beginner',
                'is_published' => true,
                'estimated_hours' => 10,
            ]
        );

        $this->createTopicsAndLessons($htmlPath, $this->getHtmlTopicsData());

        // Learning Path 2: CSS & Styling
        $cssPath = LearningPath::updateOrCreate(
            ['slug' => Str::slug('CSS & Styling')],
            [
                'title' => 'CSS & Styling',
                'description' => 'Master CSS untuk menciptakan website yang indah, responsive, dan user-friendly dengan desain modern.',
                'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=500&h=300&fit=crop',
                'order' => 2,
                'difficulty' => 'intermediate',
                'is_published' => true,
                'estimated_hours' => 15,
            ]
        );

        $this->createTopicsAndLessons($cssPath, $this->getCssTopicsData());

        // Learning Path 3: PHP & Laravel
        $phpPath = LearningPath::updateOrCreate(
            ['slug' => Str::slug('PHP & Laravel')],
            [
                'title' => 'PHP & Laravel',
                'description' => 'Kuasai PHP dan framework Laravel untuk membangun aplikasi web full-stack yang scalable dan professional.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=300&fit=crop',
                'order' => 3,
                'difficulty' => 'advanced',
                'is_published' => true,
                'estimated_hours' => 25,
            ]
        );

        $this->createTopicsAndLessons($phpPath, $this->getPhpTopicsData());
    }

    private function createTopicsAndLessons($path, $topicsData): void
    {
        foreach ($topicsData as $topicOrder => $topicData) {
            $topic = Topic::updateOrCreate(
                [
                    'learning_path_id' => $path->id,
                    'slug' => Str::slug($topicData['title']),
                ],
                [
                    'title' => $topicData['title'],
                    'description' => $topicData['description'],
                    'thumbnail' => $topicData['thumbnail'],
                    'order' => $topicOrder + 1,
                    'estimated_minutes' => $topicData['estimated_minutes'],
                    'is_published' => true,
                ]
            );

            foreach ($topicData['lessons'] as $lessonOrder => $lessonData) {
                Lesson::updateOrCreate(
                    [
                        'topic_id' => $topic->id,
                        'title' => $lessonData['title'],
                    ],
                    [
                        'type' => $lessonData['type'],
                        'content' => $lessonData['content'],
                        'video_url' => $lessonData['video_url'],
                        'order' => $lessonOrder + 1,
                        'xp_reward' => $lessonData['xp_reward'],
                        'is_published' => true,
                        'is_free' => $lessonOrder === 0, // First lesson is free
                        'duration_minutes' => $lessonData['duration_minutes'],
                    ]
                );
            }
        }
    }

    private function getHtmlTopicsData(): array
    {
        return [
            [
                'title' => 'Pengenalan HTML',
                'description' => 'Memahami dasar-dasar HTML dan struktur dokumen.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop',
                'estimated_minutes' => 60,
                'lessons' => [
                    [
                        'title' => 'Apa itu HTML?',
                        'type' => 'video',
                        'content' => '<h2>Apa itu HTML?</h2><p>HTML (HyperText Markup Language) adalah bahasa markup yang digunakan untuk membuat halaman web. HTML menggunakan sistem tag untuk menstruktur konten.</p><h3>Kegunaan HTML:</h3><ul><li>Membuat struktur halaman web</li><li>Menampilkan teks, gambar, dan media lainnya</li><li>Membuat form untuk input data</li><li>Mendefinisikan semantik konten</li></ul>',
                        'video_url' => 'https://www.youtube.com/embed/ok7N9qXVWKk',
                        'xp_reward' => 10,
                        'duration_minutes' => 8,
                    ],
                    [
                        'title' => 'Struktur Dokumen HTML',
                        'type' => 'article',
                        'content' => '<h2>Struktur Dokumen HTML</h2><p>Setiap dokumen HTML harus memiliki struktur dasar yang benar:</p><pre>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n  &lt;head&gt;\n    &lt;meta charset="UTF-8"&gt;\n    &lt;title&gt;Judul Halaman&lt;/title&gt;\n  &lt;/head&gt;\n  &lt;body&gt;\n    &lt;h1&gt;Selamat Datang&lt;/h1&gt;\n  &lt;/body&gt;\n&lt;/html&gt;</pre><p>Tag-tag utama:</p><ul><li>&lt;html&gt; - Root element</li><li>&lt;head&gt; - Metadata dokumen</li><li>&lt;body&gt; - Konten yang ditampilkan</li></ul>',
                        'video_url' => '',
                        'xp_reward' => 15,
                        'duration_minutes' => 10,
                    ],
                    [
                        'title' => 'Tag dan Atribut HTML',
                        'type' => 'interactive',
                        'content' => '<h2>Memahami Tag dan Atribut</h2><p>Tag HTML dibungkus dengan kurung sudut &lt; &gt;. Atribut memberikan informasi tambahan kepada tag.</p><pre>&lt;a href="https://example.com"&gt;Klik di sini&lt;/a&gt;</pre><p>Contoh atribut: id, class, href, src, alt, title</p>',
                        'video_url' => '',
                        'xp_reward' => 12,
                        'duration_minutes' => 7,
                    ],
                    [
                        'title' => 'Heading dan Paragraph',
                        'type' => 'article',
                        'content' => '<h2>Heading dan Paragraph</h2><p>Heading digunakan untuk judul dengan level 1-6 (h1-h6). Paragraph menggunakan tag &lt;p&gt;.</p><pre>&lt;h1&gt;Judul Utama&lt;/h1&gt;\n&lt;p&gt;Ini adalah paragraf pertama.&lt;/p&gt;\n&lt;p&gt;Ini adalah paragraf kedua.&lt;/p&gt;</pre>',
                        'video_url' => '',
                        'xp_reward' => 10,
                        'duration_minutes' => 5,
                    ],
                    [
                        'title' => 'Link dan Gambar',
                        'type' => 'interactive',
                        'content' => '<h2>Membuat Link dan Menampilkan Gambar</h2><p>Link dibuat dengan tag &lt;a&gt; dan gambar dengan tag &lt;img&gt;.</p><pre>&lt;a href="halaman-lain.html"&gt;Kunjungi Halaman&lt;/a&gt;\n&lt;img src="gambar.jpg" alt="Deskripsi Gambar"&gt;</pre>',
                        'video_url' => '',
                        'xp_reward' => 15,
                        'duration_minutes' => 8,
                    ],
                ],
            ],
            [
                'title' => 'Elemen HTML Lanjutan',
                'description' => 'Memperdalam penggunaan elemen HTML untuk konten yang lebih kompleks.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop',
                'estimated_minutes' => 75,
                'lessons' => [
                    [
                        'title' => 'List dan Table',
                        'type' => 'article',
                        'content' => '<h2>List dan Table</h2><p>HTML menyediakan dua cara untuk menampilkan data terstruktur:</p><h3>Ordered List:</h3><pre>&lt;ol&gt;\n  &lt;li&gt;Item pertama&lt;/li&gt;\n  &lt;li&gt;Item kedua&lt;/li&gt;\n&lt;/ol&gt;</pre><h3>Unordered List:</h3><pre>&lt;ul&gt;\n  &lt;li&gt;Item A&lt;/li&gt;\n  &lt;li&gt;Item B&lt;/li&gt;\n&lt;/ul&gt;</pre>',
                        'video_url' => '',
                        'xp_reward' => 15,
                        'duration_minutes' => 10,
                    ],
                    [
                        'title' => 'Form HTML',
                        'type' => 'interactive',
                        'content' => '<h2>Membuat Form</h2><pre>&lt;form action="/submit" method="POST"&gt;\n  &lt;input type="text" name="nama" placeholder="Nama"&gt;\n  &lt;input type="email" name="email" placeholder="Email"&gt;\n  &lt;textarea name="pesan" placeholder="Pesan"&gt;&lt;/textarea&gt;\n  &lt;button type="submit"&gt;Kirim&lt;/button&gt;\n&lt;/form&gt;</pre>',
                        'video_url' => '',
                        'xp_reward' => 20,
                        'duration_minutes' => 12,
                    ],
                    [
                        'title' => 'Semantic HTML',
                        'type' => 'article',
                        'content' => '<h2>Semantic HTML5</h2><p>Semantic elements memberikan makna pada konten:</p><pre>&lt;header&gt;...&lt;/header&gt;\n&lt;nav&gt;...&lt;/nav&gt;\n&lt;article&gt;...&lt;/article&gt;\n&lt;aside&gt;...&lt;/aside&gt;\n&lt;footer&gt;...&lt;/footer&gt;</pre>',
                        'video_url' => '',
                        'xp_reward' => 15,
                        'duration_minutes' => 9,
                    ],
                    [
                        'title' => 'Media Embedding',
                        'type' => 'interactive',
                        'content' => '<h2>Menyisipkan Media</h2><pre>&lt;video controls&gt;\n  &lt;source src="video.mp4" type="video/mp4"&gt;\n&lt;/video&gt;\n\n&lt;audio controls&gt;\n  &lt;source src="audio.mp3" type="audio/mpeg"&gt;\n&lt;/audio&gt;\n\n&lt;iframe src="https://www.youtube.com/embed/..."&gt;&lt;/iframe&gt;</pre>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 11,
                    ],
                    [
                        'title' => 'Best Practices HTML',
                        'type' => 'article',
                        'content' => '<h2>Best Practices</h2><ul><li>Gunakan semantic tags</li><li>Selalu beri alt text pada gambar</li><li>Validasi HTML dengan W3C Validator</li><li>Gunakan indentasi yang konsisten</li><li>Hindari nested tags yang terlalu dalam</li><li>Gunakan kebab-case untuk class names</li></ul>',
                        'video_url' => '',
                        'xp_reward' => 12,
                        'duration_minutes' => 8,
                    ],
                ],
            ],
            [
                'title' => 'Proyek HTML Praktis',
                'description' => 'Aplikasikan pengetahuan HTML dengan membuat proyek nyata.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop',
                'estimated_minutes' => 90,
                'lessons' => [
                    [
                        'title' => 'Membuat Landing Page',
                        'type' => 'project',
                        'content' => '<h2>Project: Landing Page Sederhana</h2><p>Buat landing page dengan struktur HTML yang baik, termasuk header, hero section, features, dan footer.</p><h3>Requirements:</h3><ul><li>Gunakan semantic HTML</li><li>Minimal 5 section berbeda</li><li>Gunakan heading h1-h3 dengan benar</li><li>Tambahkan minimal 3 gambar</li><li>Buat form newsletter</li></ul>',
                        'video_url' => '',
                        'xp_reward' => 50,
                        'duration_minutes' => 30,
                    ],
                    [
                        'title' => 'Portfolio Website',
                        'type' => 'project',
                        'content' => '<h2>Project: Portfolio Website</h2><p>Buat website portfolio pribadi dengan proyek-proyek Anda.</p><h3>Sections:</h3><ul><li>About Me</li><li>Projects Showcase</li><li>Skills</li><li>Contact Form</li></ul>',
                        'video_url' => '',
                        'xp_reward' => 50,
                        'duration_minutes' => 35,
                    ],
                    [
                        'title' => 'Blog Listing Page',
                        'type' => 'project',
                        'content' => '<h2>Project: Blog Listing</h2><p>Buat halaman blog dengan listing artikel menggunakan HTML yang benar.</p>',
                        'video_url' => '',
                        'xp_reward' => 40,
                        'duration_minutes' => 25,
                    ],
                    [
                        'title' => 'HTML untuk E-commerce',
                        'type' => 'article',
                        'content' => '<h2>E-commerce Product Page</h2><p>Struktur HTML untuk halaman produk e-commerce yang sempurna.</p>',
                        'video_url' => '',
                        'xp_reward' => 35,
                        'duration_minutes' => 20,
                    ],
                    [
                        'title' => 'Sertifikasi HTML Dasar',
                        'type' => 'quiz',
                        'content' => '<h2>Quiz Akhir: HTML Dasar</h2><p>Uji pemahaman Anda tentang HTML dengan quiz komprehensif.</p>',
                        'video_url' => '',
                        'xp_reward' => 30,
                        'duration_minutes' => 15,
                    ],
                ],
            ],
        ];
    }

    private function getCssTopicsData(): array
    {
        return [
            [
                'title' => 'Dasar CSS',
                'description' => 'Pelajari fondasi CSS untuk styling website.',
                'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=300&fit=crop',
                'estimated_minutes' => 80,
                'lessons' => [
                    [
                        'title' => 'Pengenalan CSS',
                        'type' => 'video',
                        'content' => '<h2>CSS (Cascading Style Sheets)</h2><p>CSS digunakan untuk mengatur tampilan dan layout dari elemen HTML.</p><h3>3 Cara Menggunakan CSS:</h3><pre>1. Inline: &lt;p style="color: red;"&gt;\n2. Internal: &lt;style&gt; di dalam &lt;head&gt;\n3. External: File .css terpisah</pre>',
                        'video_url' => 'https://www.youtube.com/embed/1Rs2ND1ryYc',
                        'xp_reward' => 15,
                        'duration_minutes' => 10,
                    ],
                    [
                        'title' => 'Selectors dan Properties',
                        'type' => 'article',
                        'content' => '<h2>CSS Selectors</h2><pre>/* Element Selector */\np { color: blue; }\n\n/* Class Selector */\n.highlight { background: yellow; }\n\n/* ID Selector */\n#header { width: 100%; }\n\n/* Attribute Selector */\ninput[type="text"] { border: 1px solid gray; }</pre>',
                        'video_url' => '',
                        'xp_reward' => 20,
                        'duration_minutes' => 12,
                    ],
                    [
                        'title' => 'Box Model',
                        'type' => 'interactive',
                        'content' => '<h2>CSS Box Model</h2><p>Setiap elemen dalam CSS terdiri dari content, padding, border, dan margin.</p><pre>.box {\n  margin: 20px;       /* Ruang di luar border */\n  border: 2px solid;  /* Garis tepi */\n  padding: 15px;      /* Ruang di dalam */\n  width: 200px;       /* Content width */\n}</pre>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 11,
                    ],
                    [
                        'title' => 'Display & Positioning',
                        'type' => 'article',
                        'content' => '<h2>Display Properties</h2><pre>/* Block, Inline, Inline-block */\ndisplay: block;       /* Mengambil lebar penuh */\ndisplay: inline;      /* Hanya mengambil ruang yang diperlukan */\ndisplay: inline-block; /* Kombinasi keduanya */\n\n/* Positioning */\nposition: static;     /* Default */\nposition: relative;   /* Relatif terhadap posisi normal */\nposition: absolute;   /* Relatif terhadap parent positioning */\nposition: fixed;      /* Relatif terhadap viewport */</pre>',
                        'video_url' => '',
                        'xp_reward' => 20,
                        'duration_minutes' => 13,
                    ],
                    [
                        'title' => 'Colors dan Fonts',
                        'type' => 'interactive',
                        'content' => '<h2>Colors dan Typography</h2><pre>/* Colors */\ncolor: #FF5733;           /* Hex */\ncolor: rgb(255, 87, 51);  /* RGB */\ncolor: rgba(255, 87, 51, 0.5); /* RGBA */\n\n/* Fonts */\nfont-family: Arial, sans-serif;\nfont-size: 16px;\nfont-weight: bold;\nline-height: 1.6;</pre>',
                        'video_url' => '',
                        'xp_reward' => 15,
                        'duration_minutes' => 9,
                    ],
                ],
            ],
            [
                'title' => 'Layout Modern CSS',
                'description' => 'Master Flexbox dan Grid untuk layout responsif.',
                'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=300&fit=crop',
                'estimated_minutes' => 100,
                'lessons' => [
                    [
                        'title' => 'Flexbox Introduction',
                        'type' => 'video',
                        'content' => '<h2>CSS Flexbox</h2><p>Flexbox membuat layout yang flexible dan responsive.</p><pre>.container {\n  display: flex;\n  justify-content: center;  /* Align horizontal */\n  align-items: center;      /* Align vertical */\n  gap: 20px;                /* Space between items */\n}\n\n.item {\n  flex: 1;  /* Equal width */\n}</pre>',
                        'video_url' => 'https://www.youtube.com/embed/fYq5PXtjsvc',
                        'xp_reward' => 25,
                        'duration_minutes' => 15,
                    ],
                    [
                        'title' => 'Grid Layout',
                        'type' => 'article',
                        'content' => '<h2>CSS Grid</h2><pre>.grid {\n  display: grid;\n  grid-template-columns: repeat(3, 1fr);\n  grid-gap: 20px;\n}\n\n.item {\n  grid-column: span 2; /* Span 2 columns */\n}</pre>',
                        'video_url' => '',
                        'xp_reward' => 25,
                        'duration_minutes' => 14,
                    ],
                    [
                        'title' => 'Responsive Design',
                        'type' => 'interactive',
                        'content' => '<h2>Media Queries & Responsive</h2><pre>@media (max-width: 768px) {\n  .container {\n    flex-direction: column;\n  }\n  \n  h1 {\n    font-size: 18px;\n  }\n}\n\n/* Mobile First Approach */\n@media (min-width: 1024px) {\n  .container {\n    max-width: 1200px;\n  }\n}</pre>',
                        'video_url' => '',
                        'xp_reward' => 20,
                        'duration_minutes' => 12,
                    ],
                    [
                        'title' => 'Animations & Transitions',
                        'type' => 'article',
                        'content' => '<h2>CSS Animations</h2><pre>/* Transition */\nbutton {\n  transition: all 0.3s ease;\n}\n\nbutton:hover {\n  background-color: blue;\n  transform: scale(1.05);\n}\n\n/* Keyframe Animation */\n@keyframes slideIn {\n  from { transform: translateX(-100%); }\n  to { transform: translateX(0); }\n}\n\n.item {\n  animation: slideIn 0.5s ease;\n}</pre>',
                        'video_url' => '',
                        'xp_reward' => 22,
                        'duration_minutes' => 13,
                    ],
                    [
                        'title' => 'Advanced CSS Techniques',
                        'type' => 'article',
                        'content' => '<h2>Advanced CSS</h2><p>CSS Variables, Gradients, Shadows, dan Transform.</p>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 11,
                    ],
                ],
            ],
            [
                'title' => 'Praktik CSS Real-world',
                'description' => 'Implementasi CSS dalam proyek nyata.',
                'thumbnail' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=300&fit=crop',
                'estimated_minutes' => 95,
                'lessons' => [
                    [
                        'title' => 'Styling Navigation Bar',
                        'type' => 'project',
                        'content' => '<h2>Project: Responsive Navigation</h2><p>Buat navigation bar yang responsive dengan hamburger menu.</p>',
                        'video_url' => '',
                        'xp_reward' => 40,
                        'duration_minutes' => 25,
                    ],
                    [
                        'title' => 'Card Components',
                        'type' => 'project',
                        'content' => '<h2>Project: Card Design</h2><p>Buat reusable card components dengan CSS yang baik.</p>',
                        'video_url' => '',
                        'xp_reward' => 40,
                        'duration_minutes' => 20,
                    ],
                    [
                        'title' => 'Form Styling',
                        'type' => 'project',
                        'content' => '<h2>Project: Beautiful Forms</h2><p>Style form dengan CSS modern dan user-friendly.</p>',
                        'video_url' => '',
                        'xp_reward' => 35,
                        'duration_minutes' => 18,
                    ],
                    [
                        'title' => 'Landing Page Styling',
                        'type' => 'project',
                        'content' => '<h2>Project: Full Landing Page</h2><p>Implementasi CSS lengkap untuk landing page profesional.</p>',
                        'video_url' => '',
                        'xp_reward' => 50,
                        'duration_minutes' => 30,
                    ],
                    [
                        'title' => 'Sertifikasi CSS',
                        'type' => 'quiz',
                        'content' => '<h2>Quiz Akhir: CSS Mastery</h2><p>Test kemampuan CSS Anda.</p>',
                        'video_url' => '',
                        'xp_reward' => 30,
                        'duration_minutes' => 15,
                    ],
                ],
            ],
        ];
    }

    private function getPhpTopicsData(): array
    {
        return [
            [
                'title' => 'Fundamentals PHP',
                'description' => 'Dasar-dasar bahasa pemrograman PHP.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop',
                'estimated_minutes' => 90,
                'lessons' => [
                    [
                        'title' => 'Syntax dan Variables',
                        'type' => 'video',
                        'content' => '<h2>PHP Basics</h2><pre><?php\n$nama = "John";\n$umur = 25;\n$harga = 19.99;\n\necho "Nama: " . $nama;\necho "Umur: {$umur}";\n?></pre>',
                        'video_url' => 'https://www.youtube.com/embed/OK_JCtrrv-c',
                        'xp_reward' => 20,
                        'duration_minutes' => 12,
                    ],
                    [
                        'title' => 'Operators dan Control Flow',
                        'type' => 'article',
                        'content' => '<h2>PHP Operators</h2><pre><?php\n// Arithmetic\n$sum = 10 + 5;\n\n// Comparison\nif ($umur >= 18) {\n    echo "Dewasa";\n}\n\n// Logical\nif ($umur >= 18 && $status == "single") {\n    echo "Syarat terpenuhi";\n}\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 10,
                    ],
                    [
                        'title' => 'Arrays dan Loops',
                        'type' => 'interactive',
                        'content' => '<h2>Arrays</h2><pre><?php\n$buah = ["Apel", "Jeruk", "Mangga"];\n$person = [\n    "nama" => "John",\n    "umur" => 25\n];\n\nforeach ($buah as $item) {\n    echo $item;\n}\n\nfor ($i = 0; $i < 5; $i++) {\n    echo $i;\n}\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 20,
                        'duration_minutes' => 11,
                    ],
                    [
                        'title' => 'Functions',
                        'type' => 'article',
                        'content' => '<h2>Functions</h2><pre><?php\nfunction greet($name) {\n    return "Hello, " . $name;\n}\n\necho greet("John");\n\n// Arrow Functions\n$multiply = fn($a, $b) => $a * $b;\necho $multiply(3, 4);\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 10,
                    ],
                    [
                        'title' => 'String Manipulation',
                        'type' => 'interactive',
                        'content' => '<h2>String Functions</h2><pre><?php\n$text = "Hello World";\necho strlen($text);           // 11\necho strtoupper($text);       // HELLO WORLD\necho substr($text, 0, 5);     // Hello\necho str_replace("World", "PHP", $text);\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 15,
                        'duration_minutes' => 8,
                    ],
                ],
            ],
            [
                'title' => 'Object-Oriented PHP',
                'description' => 'Pemrograman OOP dengan PHP modern.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop',
                'estimated_minutes' => 110,
                'lessons' => [
                    [
                        'title' => 'Classes dan Objects',
                        'type' => 'video',
                        'content' => '<h2>OOP in PHP</h2><pre><?php\nclass User {\n    public $name;\n    private $email;\n    \n    public function __construct($name, $email) {\n        $this->name = $name;\n        $this->email = $email;\n    }\n    \n    public function getEmail() {\n        return $this->email;\n    }\n}\n\n$user = new User("John", "john@example.com");\n?></pre>',
                        'video_url' => 'https://www.youtube.com/embed/OIrj1IEZbEo',
                        'xp_reward' => 25,
                        'duration_minutes' => 14,
                    ],
                    [
                        'title' => 'Inheritance dan Polymorphism',
                        'type' => 'article',
                        'content' => '<h2>Inheritance</h2><pre><?php\nclass Animal {\n    public function sound() {\n        return "Sound";\n    }\n}\n\nclass Dog extends Animal {\n    public function sound() {\n        return "Woof!";\n    }\n}\n\n$dog = new Dog();\necho $dog->sound();\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 22,
                        'duration_minutes' => 12,
                    ],
                    [
                        'title' => 'Interfaces dan Traits',
                        'type' => 'interactive',
                        'content' => '<h2>Interfaces & Traits</h2><pre><?php\ninterface Movable {\n    public function move();\n}\n\nclass Car implements Movable {\n    public function move() {\n        return "Driving...";\n    }\n}\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 20,
                        'duration_minutes' => 11,
                    ],
                    [
                        'title' => 'Namespaces dan Autoloading',
                        'type' => 'article',
                        'content' => '<h2>Namespaces</h2><pre><?php\nnamespace App\\Models;\n\nclass User {\n    // ...\n}\n\nnamespace App;\nuse App\\Models\\User;\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 10,
                    ],
                    [
                        'title' => 'Exception Handling',
                        'type' => 'interactive',
                        'content' => '<h2>Exceptions</h2><pre><?php\ntry {\n    if ($age < 0) {\n        throw new Exception("Age cannot be negative");\n    }\n} catch (Exception $e) {\n    echo "Error: " . $e->getMessage();\n}\n?></pre>',
                        'video_url' => '',
                        'xp_reward' => 18,
                        'duration_minutes' => 9,
                    ],
                ],
            ],
            [
                'title' => 'Laravel Framework',
                'description' => 'Membangun aplikasi dengan Laravel.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop',
                'estimated_minutes' => 120,
                'lessons' => [
                    [
                        'title' => 'Laravel Setup & Routing',
                        'type' => 'video',
                        'content' => '<h2>Getting Started with Laravel</h2><p>Laravel adalah framework PHP yang powerful untuk membangun aplikasi web modern.</p><pre>// routes/web.php\nRoute::get(\'/\', function () {\n    return view(\'welcome\');\n});\n\nRoute::get(\'/users/{id}\', [UserController::class, \'show\']);</pre>',
                        'video_url' => 'https://www.youtube.com/embed/376l3r7KhAQ',
                        'xp_reward' => 30,
                        'duration_minutes' => 16,
                    ],
                    [
                        'title' => 'Models dan Database',
                        'type' => 'article',
                        'content' => '<h2>Eloquent ORM</h2><pre>// app/Models/User.php\nclass User extends Model {\n    protected $fillable = [\'name\', \'email\'];\n}\n\n// Create\n$user = User::create([\'name\' => \'John\', \'email\' => \'john@example.com\']);\n\n// Read\n$user = User::find(1);\n$users = User::all();</pre>',
                        'video_url' => '',
                        'xp_reward' => 28,
                        'duration_minutes' => 14,
                    ],
                    [
                        'title' => 'Controllers dan Requests',
                        'type' => 'interactive',
                        'content' => '<h2>Controllers</h2><pre>// app/Http/Controllers/UserController.php\nclass UserController extends Controller {\n    public function store(Request $request) {\n        $validated = $request->validate([\n            \'name\' => \'required|string\',\n            \'email\' => \'required|email\'\n        ]);\n        \n        User::create($validated);\n    }\n}</pre>',
                        'video_url' => '',
                        'xp_reward' => 25,
                        'duration_minutes' => 13,
                    ],
                    [
                        'title' => 'Views dan Blade Templating',
                        'type' => 'article',
                        'content' => '<h2>Blade Templates</h2><pre><!-- resources/views/user.blade.php -->\n@foreach ($users as $user)\n    <h2>{{ $user->name }}</h2>\n    @if ($user->is_active)\n        <p>Aktif</p>\n    @endif\n@endforeach</pre>',
                        'video_url' => '',
                        'xp_reward' => 22,
                        'duration_minutes' => 12,
                    ],
                    [
                        'title' => 'Authentication & Authorization',
                        'type' => 'project',
                        'content' => '<h2>Laravel Auth</h2><p>Implementasi authentication dan authorization di Laravel.</p>',
                        'video_url' => '',
                        'xp_reward' => 35,
                        'duration_minutes' => 20,
                    ],
                ],
            ],
        ];
    }
}
