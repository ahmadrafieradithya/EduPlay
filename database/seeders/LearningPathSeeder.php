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

    public function run(): void
    {
        // PATH 1: Dasar HTML (5 hours)
        $htmlPath = LearningPath::updateOrCreate(
            ['slug' => Str::slug('Dasar HTML')],
            [
                'title' => 'Dasar HTML',
                'description' => 'Pelajari fundamentals HTML untuk membangun struktur website yang kuat dan semantic.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=300&fit=crop',
                'order' => 1,
                'difficulty' => 'beginner',
                'is_published' => true,
                'estimated_hours' => 5,
            ]
        );

        // TOPIC 1: Pengenalan HTML
        $topic1 = Topic::updateOrCreate(
            ['learning_path_id' => $htmlPath->id, 'slug' => Str::slug('Pengenalan HTML')],
            [
                'title' => 'Pengenalan HTML',
                'description' => 'Memahami dasar-dasar HTML dan struktur dokumen web.',
                'order' => 1,
            ]
        );

        // Lesson 1.1: Apa itu HTML?
        Lesson::updateOrCreate(
            ['topic_id' => $topic1->id, 'title' => 'Apa itu HTML?'],
            [
                'title' => 'Apa itu HTML?',
                'type' => 'video',
                'order' => 1,
                'xp_reward' => 10,
                'is_free' => true,
                'video_url' => 'https://www.youtube.com/embed/qz0aGYrrlhU',
                'content' => '<h2>Apa itu HTML?</h2><p>HTML (HyperText Markup Language) adalah bahasa markup standar untuk membuat halaman web. HTML bukan bahasa pemrograman — ia adalah bahasa markup yang mendeskripsikan struktur halaman web.</p><p>Setiap website yang kamu kunjungi dibangun menggunakan HTML sebagai fondasi. HTML menggunakan "tag" untuk membungkus konten dan memberikan makna struktural.</p><h3>Sejarah Singkat HTML</h3><p>HTML diciptakan oleh Tim Berners-Lee pada tahun 1991. Sejak saat itu, HTML telah berkembang melalui beberapa versi. Saat ini kita menggunakan HTML5 yang dirilis pada 2014.</p><h3>Mengapa HTML Penting?</h3><ul><li>Fondasi dari setiap halaman web</li><li>Menentukan struktur konten</li><li>Bekerja bersama CSS dan JavaScript</li><li>Dipahami oleh semua browser</li></ul><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n  &lt;head&gt;\n    &lt;title&gt;Halaman Pertama&lt;/title&gt;\n  &lt;/head&gt;\n  &lt;body&gt;\n    &lt;h1&gt;Halo Dunia!&lt;/h1&gt;\n  &lt;/body&gt;\n&lt;/html&gt;</code></pre>',
            ]
        );

        // Lesson 1.2: Struktur Dokumen HTML
        Lesson::updateOrCreate(
            ['topic_id' => $topic1->id, 'title' => 'Struktur Dokumen HTML'],
            [
                'title' => 'Struktur Dokumen HTML',
                'type' => 'article',
                'order' => 2,
                'xp_reward' => 10,
                'is_free' => true,
                'video_url' => null,
                'content' => '<h2>Struktur Dokumen HTML</h2><p>Setiap dokumen HTML yang valid memiliki struktur dasar yang harus diikuti. Memahami struktur ini adalah langkah pertama menjadi web developer.</p><h3>DOCTYPE Declaration</h3><p>Baris pertama dokumen HTML selalu dimulai dengan deklarasi DOCTYPE:</p><pre><code>&lt;!DOCTYPE html&gt;</code></pre><p>Deklarasi ini memberitahu browser bahwa dokumen ini menggunakan HTML5. Tanpa deklarasi ini, browser mungkin merender halaman dalam mode kompatibilitas yang dapat menyebabkan tampilan yang tidak konsisten.</p><h3>Elemen HTML Root</h3><p>Seluruh konten HTML dibungkus dalam tag &lt;html&gt;. Tag ini adalah elemen root dari setiap halaman HTML. Atribut lang menentukan bahasa konten:</p><pre><code>&lt;html lang="id"&gt;\n  ...\n&lt;/html&gt;</code></pre><h3>Bagian Head</h3><p>Elemen &lt;head&gt; berisi informasi metadata tentang halaman yang tidak ditampilkan secara langsung kepada pengguna:</p><ul><li>&lt;title&gt; - Judul halaman (muncul di tab browser)</li><li>&lt;meta charset="UTF-8"&gt; - Encoding karakter</li><li>&lt;meta name="viewport"&gt; - Pengaturan tampilan mobile</li><li>&lt;link&gt; - Menghubungkan file CSS eksternal</li></ul><h3>Bagian Body</h3><p>Semua konten yang terlihat oleh pengguna ditempatkan di dalam elemen &lt;body&gt;. Ini termasuk teks, gambar, video, form, dan semua elemen HTML lainnya.</p>',
            ]
        );

        // Lesson 1.3: Tag dan Elemen HTML
        Lesson::updateOrCreate(
            ['topic_id' => $topic1->id, 'title' => 'Tag dan Elemen HTML'],
            [
                'title' => 'Tag dan Elemen HTML',
                'type' => 'article',
                'order' => 3,
                'xp_reward' => 15,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Tag dan Elemen HTML</h2><p>Memahami perbedaan antara tag dan elemen adalah hal fundamental dalam belajar HTML.</p><h3>Apa itu Tag HTML?</h3><p>Tag HTML adalah tanda yang menggunakan kurung sudut (< dan >). Sebagian besar tag HTML berpasangan: tag pembuka dan tag penutup.</p><pre><code>&lt;p&gt;Ini adalah sebuah paragraf.&lt;/p&gt;\n&lt;h1&gt;Ini adalah heading.&lt;/h1&gt;\n&lt;strong&gt;Ini teks tebal.&lt;/strong&gt;</code></pre><h3>Tag Tanpa Penutup (Void Elements)</h3><p>Beberapa tag HTML tidak memerlukan tag penutup karena tidak memiliki konten di dalamnya:</p><ul><li>&lt;br&gt; - Baris baru</li><li>&lt;hr&gt; - Garis horizontal</li><li>&lt;img&gt; - Gambar</li><li>&lt;input&gt; - Input form</li><li>&lt;meta&gt; - Metadata</li></ul><h3>Atribut HTML</h3><p>Tag HTML dapat memiliki atribut yang memberikan informasi tambahan. Atribut selalu ditulis di tag pembuka:</p><pre><code>&lt;a href="https://google.com" target="_blank"&gt;Google&lt;/a&gt;\n&lt;img src="foto.jpg" alt="Foto saya" width="300"&gt;\n&lt;input type="text" name="nama" placeholder="Masukkan nama"&gt;</code></pre><p>Atribut terdiri dari nama dan nilai yang dipisahkan tanda sama dengan (=), dengan nilai diapit tanda kutip.</p>',
            ]
        );

        // Lesson 1.4: Heading dan Paragraf
        Lesson::updateOrCreate(
            ['topic_id' => $topic1->id, 'title' => 'Heading dan Paragraf'],
            [
                'title' => 'Heading dan Paragraf',
                'type' => 'article',
                'order' => 4,
                'xp_reward' => 15,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Heading dan Paragraf dalam HTML</h2><p>Heading dan paragraf adalah elemen teks paling dasar dalam HTML. Memahami penggunaannya yang tepat penting untuk aksesibilitas dan SEO.</p><h3>Elemen Heading (H1-H6)</h3><p>HTML menyediakan 6 level heading, dari H1 (terpenting, terbesar) hingga H6 (terkecil):</p><pre><code>&lt;h1&gt;Heading Level 1 - Judul Utama&lt;/h1&gt;\n&lt;h2&gt;Heading Level 2 - Sub Judul&lt;/h2&gt;\n&lt;h3&gt;Heading Level 3&lt;/h3&gt;\n&lt;h4&gt;Heading Level 4&lt;/h4&gt;\n&lt;h5&gt;Heading Level 5&lt;/h5&gt;\n&lt;h6&gt;Heading Level 6&lt;/h6&gt;</code></pre><h3>Praktik Terbaik Heading</h3><ul><li>Gunakan hanya SATU H1 per halaman (judul utama)</li><li>Jangan skip level (dari H1 langsung H3)</li><li>Heading digunakan untuk struktur, bukan hanya untuk ukuran teks</li></ul><h3>Elemen Paragraf</h3><p>Paragraf dibuat menggunakan tag &lt;p&gt;. Browser otomatis menambahkan margin atas dan bawah untuk setiap paragraf:</p><pre><code>&lt;p&gt;Ini adalah paragraf pertama dengan beberapa teks konten.&lt;/p&gt;\n&lt;p&gt;Ini adalah paragraf kedua yang terpisah dari yang pertama.&lt;/p&gt;</code></pre><h3>Format Teks Inline</h3><p>Dalam paragraf, kamu bisa menggunakan tag inline untuk memformat bagian teks:</p><ul><li>&lt;strong&gt; atau &lt;b&gt; - Teks <strong>tebal</strong></li><li>&lt;em&gt; atau &lt;i&gt; - Teks <em>miring</em></li><li>&lt;u&gt; - Teks bergaris bawah</li><li>&lt;mark&gt; - Teks disorot</li><li>&lt;small&gt; - Teks lebih kecil</li></ul>',
            ]
        );

        // Lesson 1.5: Link dan Gambar
        Lesson::updateOrCreate(
            ['topic_id' => $topic1->id, 'title' => 'Link dan Gambar'],
            [
                'title' => 'Link dan Gambar',
                'type' => 'code_example',
                'order' => 5,
                'xp_reward' => 20,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Link dan Gambar dalam HTML</h2><p>Link (tautan) dan gambar adalah dua elemen yang paling sering digunakan dalam pembuatan website.</p><h3>Membuat Hyperlink dengan Tag &lt;a&gt;</h3><p>Tag anchor &lt;a&gt; digunakan untuk membuat hyperlink. Atribut href menentukan URL tujuan:</p><pre><code>&lt;!-- Link ke website eksternal --&gt;\n&lt;a href="https://www.google.com"&gt;Kunjungi Google&lt;/a&gt;\n\n&lt;!-- Link ke halaman lain di website yang sama --&gt;\n&lt;a href="/tentang.html"&gt;Tentang Kami&lt;/a&gt;\n\n&lt;!-- Link yang membuka di tab baru --&gt;\n&lt;a href="https://github.com" target="_blank" rel="noopener"&gt;GitHub&lt;/a&gt;\n\n&lt;!-- Link ke bagian dalam halaman yang sama --&gt;\n&lt;a href="#kontak"&gt;Ke Bagian Kontak&lt;/a&gt;\n\n&lt;!-- Link email --&gt;\n&lt;a href="mailto:admin@eduplay.id"&gt;Kirim Email&lt;/a&gt;</code></pre><h3>Menampilkan Gambar dengan Tag &lt;img&gt;</h3><p>Tag &lt;img&gt; adalah void element (tidak perlu tag penutup) yang menampilkan gambar:</p><pre><code>&lt;!-- Gambar dari file lokal --&gt;\n&lt;img src="foto-profil.jpg" alt="Foto profil saya" width="200" height="200"&gt;\n\n&lt;!-- Gambar dari URL --&gt;\n&lt;img src="https://example.com/gambar.png" alt="Deskripsi gambar"&gt;</code></pre><h3>Atribut Penting pada &lt;img&gt;</h3><ul><li>src - URL sumber gambar (wajib)</li><li>alt - Teks alternatif untuk aksesibilitas (wajib)</li><li>width & height - Ukuran gambar</li><li>loading="lazy" - Lazy loading untuk performa</li></ul>',
            ]
        );

        // TOPIC 2: Elemen Teks dan List
        $topic2 = Topic::updateOrCreate(
            ['learning_path_id' => $htmlPath->id, 'slug' => Str::slug('Elemen Teks dan List')],
            [
                'title' => 'Elemen Teks dan List',
                'description' => 'Menguasai penggunaan list, tabel, dan elemen teks dalam HTML.',
                'order' => 2,
            ]
        );

        // Lesson 2.1: List Ordered dan Unordered
        Lesson::updateOrCreate(
            ['topic_id' => $topic2->id, 'title' => 'List Ordered dan Unordered'],
            [
                'title' => 'List Ordered dan Unordered',
                'type' => 'video',
                'order' => 1,
                'xp_reward' => 10,
                'is_free' => true,
                'video_url' => 'https://www.youtube.com/embed/PlxWf493en4',
                'content' => '<h2>List Ordered dan Unordered</h2><p>List adalah cara yang sempurna untuk mengorganisir informasi yang bersifat urutan atau koleksi. HTML menyediakan dua jenis list utama: ordered list dan unordered list.</p><h3>Unordered List (&lt;ul&gt;)</h3><p>Unordered list digunakan ketika urutan item tidak penting. Setiap item ditandai dengan bullet point.</p><pre><code>&lt;ul&gt;\n  &lt;li&gt;Apel&lt;/li&gt;\n  &lt;li&gt;Jeruk&lt;/li&gt;\n  &lt;li&gt;Pisang&lt;/li&gt;\n  &lt;li&gt;Mangga&lt;/li&gt;\n&lt;/ul&gt;</code></pre><h3>Ordered List (&lt;ol&gt;)</h3><p>Ordered list digunakan ketika urutan item sangat penting. Setiap item diberi nomor otomatis.</p><pre><code>&lt;ol&gt;\n  &lt;li&gt;Buka browser&lt;/li&gt;\n  &lt;li&gt;Kunjungi website&lt;/li&gt;\n  &lt;li&gt;Klik link&lt;/li&gt;\n  &lt;li&gt;Baca konten&lt;/li&gt;\n&lt;/ol&gt;</code></pre><h3>List Bersarang (Nested Lists)</h3><p>List dapat bersarang di dalam list lain untuk membuat struktur yang lebih kompleks:</p><pre><code>&lt;ul&gt;\n  &lt;li&gt;Buah-buahan\n    &lt;ul&gt;\n      &lt;li&gt;Apel&lt;/li&gt;\n      &lt;li&gt;Jeruk&lt;/li&gt;\n    &lt;/ul&gt;\n  &lt;/li&gt;\n  &lt;li&gt;Sayuran\n    &lt;ul&gt;\n      &lt;li&gt;Bayam&lt;/li&gt;\n      &lt;li&gt;Brokoli&lt;/li&gt;\n    &lt;/ul&gt;\n  &lt;/li&gt;\n&lt;/ul&gt;</code></pre>',
            ]
        );

        // Lesson 2.2: Tabel HTML
        Lesson::updateOrCreate(
            ['topic_id' => $topic2->id, 'title' => 'Tabel HTML'],
            [
                'title' => 'Tabel HTML',
                'type' => 'article',
                'order' => 2,
                'xp_reward' => 15,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Tabel HTML</h2><p>Tabel adalah cara yang efektif untuk menyajikan data dalam format baris dan kolom. HTML menyediakan elemen khusus untuk membuat tabel yang terstruktur dengan baik.</p><h3>Struktur Dasar Tabel</h3><p>Tabel HTML terdiri dari beberapa elemen utama:</p><ul><li>&lt;table&gt; - Container tabel</li><li>&lt;thead&gt; - Header tabel</li><li>&lt;tbody&gt; - Body/isi tabel</li><li>&lt;tr&gt; - Table row (baris)</li><li>&lt;th&gt; - Table header cell (header kolom)</li><li>&lt;td&gt; - Table data cell (sel data)</li></ul><h3>Contoh Tabel Lengkap</h3><pre><code>&lt;table&gt;\n  &lt;thead&gt;\n    &lt;tr&gt;\n      &lt;th&gt;Nama&lt;/th&gt;\n      &lt;th&gt;Kota&lt;/th&gt;\n      &lt;th&gt;Usia&lt;/th&gt;\n    &lt;/tr&gt;\n  &lt;/thead&gt;\n  &lt;tbody&gt;\n    &lt;tr&gt;\n      &lt;td&gt;Ahmad&lt;/td&gt;\n      &lt;td&gt;Jakarta&lt;/td&gt;\n      &lt;td&gt;25&lt;/td&gt;\n    &lt;/tr&gt;\n    &lt;tr&gt;\n      &lt;td&gt;Siti&lt;/td&gt;\n      &lt;td&gt;Surabaya&lt;/td&gt;\n      &lt;td&gt;23&lt;/td&gt;\n    &lt;/tr&gt;\n    &lt;tr&gt;\n      &lt;td&gt;Budi&lt;/td&gt;\n      &lt;td&gt;Bandung&lt;/td&gt;\n      &lt;td&gt;27&lt;/td&gt;\n    &lt;/tr&gt;\n  &lt;/tbody&gt;\n&lt;/table&gt;</code></pre><h3>Atribut Tabel Penting</h3><ul><li>colspan - Menggabungkan beberapa kolom</li><li>rowspan - Menggabungkan beberapa baris</li><li>border - Menambahkan border tabel</li></ul><h3>Contoh dengan Colspan dan Rowspan</h3><pre><code>&lt;table&gt;\n  &lt;tr&gt;\n    &lt;th colspan="2"&gt;Data Siswa&lt;/th&gt;\n  &lt;/tr&gt;\n  &lt;tr&gt;\n    &lt;td&gt;Nama&lt;/td&gt;\n    &lt;td&gt;Nilai&lt;/td&gt;\n  &lt;/tr&gt;\n&lt;/table&gt;</code></pre>',
            ]
        );

        // Lesson 2.3: Form dan Input
        Lesson::updateOrCreate(
            ['topic_id' => $topic2->id, 'title' => 'Form dan Input'],
            [
                'title' => 'Form dan Input',
                'type' => 'video',
                'order' => 3,
                'xp_reward' => 15,
                'is_free' => false,
                'video_url' => 'https://www.youtube.com/embed/fNcJuPIZ2WE',
                'content' => '<h2>Form dan Input dalam HTML</h2><p>Form adalah cara utama untuk mengumpulkan input dari pengguna di website. Form dapat berisi berbagai jenis input fields seperti text, email, password, checkbox, radio button, dan banyak lagi.</p><h3>Struktur Dasar Form</h3><p>Setiap form dimulai dengan tag &lt;form&gt; dan memiliki atribut action (tujuan pengiriman) dan method (GET atau POST):</p><pre><code>&lt;form action="/submit" method="POST"&gt;\n  &lt;label for="nama"&gt;Nama:&lt;/label&gt;\n  &lt;input type="text" id="nama" name="nama" required&gt;\n  \n  &lt;label for="email"&gt;Email:&lt;/label&gt;\n  &lt;input type="email" id="email" name="email" required&gt;\n  \n  &lt;button type="submit"&gt;Kirim&lt;/button&gt;\n&lt;/form&gt;</code></pre><h3>Jenis-jenis Input</h3><ul><li>type="text" - Input teks biasa</li><li>type="email" - Input email dengan validasi</li><li>type="password" - Input password yang ter-mask</li><li>type="number" - Input angka</li><li>type="date" - Input tanggal</li><li>type="checkbox" - Checkbox untuk pilihan multiple</li><li>type="radio" - Radio button untuk pilihan tunggal</li></ul><h3>Element Form Lainnya</h3><ul><li>&lt;textarea&gt; - Area teks multi-baris</li><li>&lt;select&gt; - Dropdown selection list</li><li>&lt;option&gt; - Pilihan dalam dropdown</li><li>&lt;label&gt; - Label untuk form field</li></ul>',
            ]
        );

        // Lesson 2.4: Div dan Span
        Lesson::updateOrCreate(
            ['topic_id' => $topic2->id, 'title' => 'Div dan Span'],
            [
                'title' => 'Div dan Span',
                'type' => 'article',
                'order' => 4,
                'xp_reward' => 10,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Div dan Span - Container Generic HTML</h2><p>Div dan span adalah dua elemen HTML yang paling umum digunakan untuk membungkus dan mengelompokkan konten. Keduanya tidak memiliki makna semantik khusus, tetapi sangat berguna untuk styling dan layout.</p><h3>Elemen Div (&lt;div&gt;)</h3><p>Div adalah elemen block-level yang digunakan untuk mengelompokkan blok konten yang besar. Setiap div akan memulai baris baru dan mengambil lebar penuh dari parent element.</p><pre><code>&lt;div class="container"&gt;\n  &lt;h1&gt;Judul Halaman&lt;/h1&gt;\n  &lt;p&gt;Paragraf konten&lt;/p&gt;\n  &lt;button&gt;Klik Saya&lt;/button&gt;\n&lt;/div&gt;</code></pre><h3>Elemen Span (&lt;span&gt;)</h3><p>Span adalah elemen inline yang digunakan untuk membungkus sejumlah kecil konten dalam baris teks. Span tidak memulai baris baru dan hanya mengambil ruang yang diperlukan untuk kontennya.</p><pre><code>&lt;p&gt;Halo &lt;span style="color: red;"&gt;Dunia&lt;/span&gt;!&lt;/p&gt;\n&lt;p&gt;Saya sedang &lt;span class="highlight"&gt;belajar&lt;/span&gt; HTML.&lt;/p&gt;</code></pre><h3>Perbedaan Block vs Inline</h3><ul><li>Block elements: Menempati lebar penuh, memulai baris baru (div, p, h1-h6, ul, ol)</li><li>Inline elements: Hanya menempati ruang yang diperlukan, tidak memulai baris baru (span, a, strong, em)</li></ul><h3>Menggunakan Div untuk Layout</h3><p>Div sering digunakan untuk membuat struktur layout website:</p><pre><code>&lt;div class="header"&gt;Header&lt;/div&gt;\n&lt;div class="sidebar"&gt;Sidebar&lt;/div&gt;\n&lt;div class="main-content"&gt;Main Content&lt;/div&gt;\n&lt;div class="footer"&gt;Footer&lt;/div&gt;</code></pre>',
            ]
        );

        // Lesson 2.5: HTML Semantik
        Lesson::updateOrCreate(
            ['topic_id' => $topic2->id, 'title' => 'HTML Semantik'],
            [
                'title' => 'HTML Semantik',
                'type' => 'article',
                'order' => 5,
                'xp_reward' => 20,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>HTML Semantik</h2><p>HTML semantik berarti menggunakan HTML tags yang memiliki makna yang jelas tentang konten yang dibungkusnya. Semantic HTML meningkatkan aksesibilitas, SEO, dan keterbacaan kode.</p><h3>Elemen-elemen Semantik Utama</h3><p>HTML5 memperkenalkan beberapa elemen semantik yang menggantikan penggunaan div generik:</p><ul><li>&lt;header&gt; - Header halaman atau section</li><li>&lt;nav&gt; - Navigation/menu</li><li>&lt;main&gt; - Konten utama halaman</li><li>&lt;article&gt; - Konten independen seperti blog post</li><li>&lt;section&gt; - Bagian tematik dari konten</li><li>&lt;aside&gt; - Sidebar atau konten sampingan</li><li>&lt;footer&gt; - Footer halaman atau section</li></ul><h3>Struktur Halaman Semantik</h3><pre><code>&lt;header&gt;\n  &lt;nav&gt;\n    &lt;ul&gt;\n      &lt;li&gt;&lt;a href="/"&gt;Home&lt;/a&gt;&lt;/li&gt;\n      &lt;li&gt;&lt;a href="/about"&gt;Tentang&lt;/a&gt;&lt;/li&gt;\n      &lt;li&gt;&lt;a href="/blog"&gt;Blog&lt;/a&gt;&lt;/li&gt;\n    &lt;/ul&gt;\n  &lt;/nav&gt;\n&lt;/header&gt;\n\n&lt;main&gt;\n  &lt;article&gt;\n    &lt;h1&gt;Judul Blog Post&lt;/h1&gt;\n    &lt;p&gt;Konten artikel&lt;/p&gt;\n  &lt;/article&gt;\n  \n  &lt;aside&gt;\n    &lt;h3&gt;Artikel Terbaru&lt;/h3&gt;\n    &lt;ul&gt;\n      &lt;li&gt;&lt;a href="#">Article 1&lt;/a&gt;&lt;/li&gt;\n      &lt;li&gt;&lt;a href="#">Article 2&lt;/a&gt;&lt;/li&gt;\n    &lt;/ul&gt;\n  &lt;/aside&gt;\n&lt;/main&gt;\n\n&lt;footer&gt;\n  &lt;p&gt;&copy; 2024 EduPlay&lt;/p&gt;\n&lt;/footer&gt;</code></pre><h3>Manfaat HTML Semantik</h3><ul><li>Meningkatkan aksesibilitas untuk screen readers</li><li>Memudahkan mesin pencari memahami struktur halaman (SEO)</li><li>Kode lebih mudah dibaca dan dipahami developer</li><li>Membantu browser memahami layout dengan lebih baik</li></ul>',
            ]
        );

        // TOPIC 3: Multimedia dan Formulir
        $topic3 = Topic::updateOrCreate(
            ['learning_path_id' => $htmlPath->id, 'slug' => Str::slug('Multimedia dan Formulir')],
            [
                'title' => 'Multimedia dan Formulir',
                'description' => 'Menguasai elemen multimedia dan form validation dalam HTML5.',
                'order' => 3,
            ]
        );

        // Lesson 3.1: Audio dalam HTML
        Lesson::updateOrCreate(
            ['topic_id' => $topic3->id, 'title' => 'Audio dalam HTML'],
            [
                'title' => 'Audio dalam HTML',
                'type' => 'video',
                'order' => 1,
                'xp_reward' => 10,
                'is_free' => true,
                'video_url' => 'https://www.youtube.com/embed/K0NI3DM5p6A',
                'content' => '<h2>Audio dalam HTML</h2><p>HTML5 memperkenalkan tag &lt;audio&gt; yang memungkinkan kamu untuk menyematkan file audio langsung dalam halaman web tanpa memerlukan plugin eksternal.</p><h3>Tag Audio Dasar</h3><p>Tag &lt;audio&gt; memiliki atribut controls yang menampilkan player audio dengan tombol play/pause, volume, dan progress bar:</p><pre><code>&lt;audio controls&gt;\n  &lt;source src="lagu.mp3" type="audio/mpeg"&gt;\n  Browser Anda tidak mendukung tag audio.\n&lt;/audio&gt;</code></pre><h3>Atribut Audio Penting</h3><ul><li>controls - Menampilkan player controls</li><li>autoplay - Memutar otomatis saat halaman dimuat</li><li>loop - Mengulang pemutaran</li><li>muted - Mute audio secara default</li><li>preload - Preload audio (none, metadata, auto)</li></ul><h3>Format Audio yang Didukung</h3><ul><li>MP3 (audio/mpeg) - Format paling kompatibel</li><li>WAV (audio/wav)</li><li>OGG (audio/ogg)</li></ul><h3>Contoh Lengkap Audio</h3><pre><code>&lt;audio controls preload="metadata"&gt;\n  &lt;source src="musik.mp3" type="audio/mpeg"&gt;\n  &lt;source src="musik.ogg" type="audio/ogg"&gt;\n  Maaf, browser Anda tidak mendukung audio HTML5.\n&lt;/audio&gt;</code></pre>',
            ]
        );

        // Lesson 3.2: Video dalam HTML
        Lesson::updateOrCreate(
            ['topic_id' => $topic3->id, 'title' => 'Video dalam HTML'],
            [
                'title' => 'Video dalam HTML',
                'type' => 'video',
                'order' => 2,
                'xp_reward' => 15,
                'is_free' => true,
                'video_url' => 'https://www.youtube.com/embed/9-oFJL-S1kU',
                'content' => '<h2>Video dalam HTML</h2><p>Tag &lt;video&gt; HTML5 memungkinkan kamu untuk menyematkan video langsung dalam halaman web dengan kontrol player yang lengkap.</p><h3>Tag Video Dasar</h3><p>Mirip dengan audio, tag video juga menggunakan elemen &lt;source&gt; untuk menentukan file video dan format nya:</p><pre><code>&lt;video width="640" height="480" controls&gt;\n  &lt;source src="film.mp4" type="video/mp4"&gt;\n  Browser Anda tidak mendukung tag video.\n&lt;/video&gt;</code></pre><h3>Atribut Video Penting</h3><ul><li>width & height - Ukuran video</li><li>controls - Menampilkan video controls</li><li>autoplay - Memutar otomatis saat halaman dimuat</li><li>loop - Mengulang pemutaran</li><li>muted - Mute audio video secara default</li><li>poster - Gambar thumbnail sebelum video dimulai</li><li>preload - Preload video (none, metadata, auto)</li></ul><h3>Format Video yang Didukung</h3><ul><li>MP4 (video/mp4) - Format paling kompatibel, codec H.264</li><li>WebM (video/webm) - Format terbuka, compression lebih baik</li><li>Ogg (video/ogg)</li></ul><h3>Contoh Lengkap Video</h3><pre><code>&lt;video width="800" height="600" controls poster="thumbnail.jpg"&gt;\n  &lt;source src="video.mp4" type="video/mp4"&gt;\n  &lt;source src="video.webm" type="video/webm"&gt;\n  Maaf, browser Anda tidak mendukung video HTML5.\n&lt;/video&gt;</code></pre>',
            ]
        );

        // Lesson 3.3: Input Validation
        Lesson::updateOrCreate(
            ['topic_id' => $topic3->id, 'title' => 'Input Validation'],
            [
                'title' => 'Input Validation',
                'type' => 'article',
                'order' => 3,
                'xp_reward' => 15,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Input Validation dalam HTML5</h2><p>HTML5 menyediakan validasi input bawaan yang dapat membantu memastikan data yang dimasukkan pengguna valid tanpa perlu JavaScript tambahan.</p><h3>Atribut Validasi HTML5</h3><ul><li>required - Field wajib diisi</li><li>minlength & maxlength - Panjang minimum dan maksimum</li><li>min & max - Nilai minimum dan maksimum untuk input number</li><li>pattern - Validasi menggunakan regular expression</li><li>type - Type input dengan validasi bawaan (email, number, url, date, dsb)</li></ul><h3>Contoh Validasi Input</h3><pre><code>&lt;form&gt;\n  &lt;!-- Email validation --&gt;\n  &lt;input type="email" required placeholder="Masukkan email"&gt;\n  \n  &lt;!-- Password dengan minimum length --&gt;\n  &lt;input type="password" minlength="8" required placeholder="Minimal 8 karakter"&gt;\n  \n  &lt;!-- Number dengan range --&gt;\n  &lt;input type="number" min="1" max="100" required placeholder="Angka 1-100"&gt;\n  \n  &lt;!-- URL validation --&gt;\n  &lt;input type="url" required placeholder="https://example.com"&gt;\n  \n  &lt;!-- Date input --&gt;\n  &lt;input type="date" required&gt;\n  \n  &lt;!-- Text dengan pattern (hanya angka) --&gt;\n  &lt;input type="text" pattern="[0-9]{10}" placeholder="10 digit angka"&gt;\n  \n  &lt;button type="submit"&gt;Kirim&lt;/button&gt;\n&lt;/form&gt;</code></pre><h3>Custom Validation Message</h3><pre><code>&lt;input type="email" required placeholder="Masukkan email"&gt;\n&lt;script&gt;\n  document.querySelector(\'input[type="email"]\').addEventListener("invalid", function() {\n    this.setCustomValidity("Silakan masukkan email yang valid!");\n  });\n&lt;/script&gt;</code></pre>',
            ]
        );

        // Lesson 3.4: Advanced Form Elements
        Lesson::updateOrCreate(
            ['topic_id' => $topic3->id, 'title' => 'Advanced Form Elements'],
            [
                'title' => 'Advanced Form Elements',
                'type' => 'article',
                'order' => 4,
                'xp_reward' => 15,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>Advanced Form Elements HTML5</h2><p>HTML5 memperkenalkan beberapa input types dan form elements baru yang mempermudah pengambilan input khusus dari pengguna.</p><h3>Input Types HTML5 Baru</h3><ul><li>color - Pemilih warna</li><li>date - Pemilih tanggal</li><li>datetime-local - Pemilih tanggal dan waktu</li><li>month - Pemilih bulan</li><li>time - Pemilih waktu</li><li>week - Pemilih minggu</li><li>range - Slider input</li><li>search - Input pencarian</li><li>tel - Input telepon</li><li>url - Input URL dengan validasi</li><li>email - Input email dengan validasi</li></ul><h3>Contoh Advanced Input Types</h3><pre><code>&lt;form&gt;\n  &lt;!-- Color picker --&gt;\n  &lt;label for="color"&gt;Pilih Warna:&lt;/label&gt;\n  &lt;input type="color" id="color" value="#FF5733"&gt;\n  \n  &lt;!-- Date picker --&gt;\n  &lt;label for="tanggal"&gt;Tanggal Lahir:&lt;/label&gt;\n  &lt;input type="date" id="tanggal"&gt;\n  \n  &lt;!-- Range slider --&gt;\n  &lt;label for="volume"&gt;Volume:&lt;/label&gt;\n  &lt;input type="range" id="volume" min="0" max="100" value="50"&gt;\n  \n  &lt;!-- Tel input --&gt;\n  &lt;label for="telpon"&gt;No. Telpon:&lt;/label&gt;\n  &lt;input type="tel" id="telpon" placeholder="62-812-3456-7890"&gt;\n  \n  &lt;!-- Search input --&gt;\n  &lt;label for="cari"&gt;Cari:&lt;/label&gt;\n  &lt;input type="search" id="cari" placeholder="Cari sesuatu..."&gt;\n&lt;/form&gt;</code></pre><h3>Datalist dan Output Elements</h3><pre><code>&lt;input list="browsers" placeholder="Pilih browser"&gt;\n&lt;datalist id="browsers"&gt;\n  &lt;option value="Chrome"&gt;\n  &lt;option value="Firefox"&gt;\n  &lt;option value="Safari"&gt;\n  &lt;option value="Edge"&gt;\n&lt;/datalist&gt;</code></pre>',
            ]
        );

        // Lesson 3.5: HTML5 Features
        Lesson::updateOrCreate(
            ['topic_id' => $topic3->id, 'title' => 'HTML5 Features'],
            [
                'title' => 'HTML5 Features',
                'type' => 'article',
                'order' => 5,
                'xp_reward' => 20,
                'is_free' => false,
                'video_url' => null,
                'content' => '<h2>HTML5 Features Tambahan</h2><p>HTML5 memperkenalkan banyak fitur baru yang meningkatkan fungsionalitas dan kemampuan web development.</p><h3>Data Attributes</h3><p>Data attributes memungkinkan kamu menyimpan data custom pada element HTML yang dapat diakses via JavaScript:</p><pre><code>&lt;div data-user-id="12345" data-username="ahmad"&gt;\n  Ahmad\n&lt;/div&gt;\n\n&lt;script&gt;\n  const div = document.querySelector("div");\n  console.log(div.dataset.userId);  // "12345"\n  console.log(div.dataset.username); // "ahmad"\n&lt;/script&gt;</code></pre><h3>Embed dan Progress</h3><pre><code>&lt;!-- Embed external content --&gt;\n&lt;embed src="document.pdf" type="application/pdf"&gt;\n\n&lt;!-- Progress bar --&gt;\n&lt;progress value="70" max="100"&gt;&lt;/progress&gt;</code></pre><h3>Canvas dan SVG</h3><p>HTML5 memperkenalkan canvas dan SVG untuk membuat grafis:</p><pre><code>&lt;!-- Canvas untuk drawing dengan JavaScript --&gt;\n&lt;canvas id="myCanvas" width="400" height="300"&gt;&lt;/canvas&gt;\n\n&lt;!-- SVG untuk vector graphics --&gt;\n&lt;svg width="200" height="200"&gt;\n  &lt;circle cx="100" cy="100" r="80" fill="blue"&gt;\n&lt;/svg&gt;</code></pre><h3>Web Storage API</h3><p>HTML5 menyediakan Local Storage dan Session Storage untuk menyimpan data di browser:</p><pre><code>&lt;script&gt;\n  // Menyimpan data\n  localStorage.setItem("nama", "Ahmad");\n  \n  // Mengambil data\n  const nama = localStorage.getItem("nama");\n  \n  // Menghapus data\n  localStorage.removeItem("nama");\n&lt;/script&gt;</code></pre><h3>Geolocation API</h3><pre><code>&lt;script&gt;\n  navigator.geolocation.getCurrentPosition(function(position) {\n    const lat = position.coords.latitude;\n    const lon = position.coords.longitude;\n    console.log("Lokasi: " + lat + ", " + lon);\n  });\n&lt;/script&gt;</code></pre>',
            ]
        );
    }
}
