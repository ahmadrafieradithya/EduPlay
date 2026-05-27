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
        // =====================================================
        // PATH 1: Dasar HTML (5 hours)
        // =====================================================
        $path1 = LearningPath::updateOrCreate(
            ['slug' => Str::slug('Dasar HTML')],
            [
                'title' => 'Dasar HTML',
                'slug' => Str::slug('Dasar HTML'),
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
            ['learning_path_id' => $path1->id, 'title' => 'Pengenalan HTML'],
            [
                'learning_path_id' => $path1->id,
                'title' => 'Pengenalan HTML',
                'slug' => Str::slug('Pengenalan HTML - Path 1'),
                'description' => 'Memahami dasar-dasar HTML dan struktur dokumen web.',
                'order' => 1,
            ]
        );

        $topic1Lessons = [
            ['order' => 1, 'title' => 'Apa itu HTML?', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/qz0aGYrrlhU', 'content' => '<h2>Apa itu HTML?</h2><p>HTML (HyperText Markup Language) adalah bahasa markup standar untuk membuat halaman web. HTML bukan bahasa pemrograman — ia adalah bahasa markup yang mendeskripsikan struktur halaman web.</p><p>Setiap website yang kamu kunjungi dibangun menggunakan HTML sebagai fondasi. HTML menggunakan "tag" untuk membungkus konten dan memberikan makna struktural.</p><h3>Sejarah Singkat HTML</h3><p>HTML diciptakan oleh Tim Berners-Lee pada tahun 1991. Sejak saat itu, HTML telah berkembang melalui beberapa versi. Saat ini kita menggunakan HTML5 yang dirilis pada 2014.</p><h3>Mengapa HTML Penting?</h3><ul><li>Fondasi dari setiap halaman web</li><li>Menentukan struktur konten</li><li>Bekerja bersama CSS dan JavaScript</li><li>Dipahami oleh semua browser</li></ul><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n  &lt;head&gt;\n    &lt;title&gt;Halaman Pertama&lt;/title&gt;\n  &lt;/head&gt;\n  &lt;body&gt;\n    &lt;h1&gt;Halo Dunia!&lt;/h1&gt;\n  &lt;/body&gt;\n&lt;/html&gt;</code></pre>'],
            ['order' => 2, 'title' => 'Struktur Dokumen HTML', 'type' => 'article', 'xp_reward' => 10, 'is_free' => true, 'video_url' => null, 'content' => '<h2>Struktur Dokumen HTML</h2><p>Setiap dokumen HTML yang valid memiliki struktur dasar yang harus diikuti. Memahami struktur ini adalah langkah pertama menjadi web developer.</p><h3>DOCTYPE Declaration</h3><p>Baris pertama dokumen HTML selalu dimulai dengan deklarasi DOCTYPE:</p><pre><code>&lt;!DOCTYPE html&gt;</code></pre><p>Deklarasi ini memberitahu browser bahwa dokumen ini menggunakan HTML5. Tanpa deklarasi ini, browser mungkin merender halaman dalam mode kompatibilitas yang dapat menyebabkan tampilan yang tidak konsisten.</p><h3>Elemen HTML Root</h3><p>Seluruh konten HTML dibungkus dalam tag &lt;html&gt;. Tag ini adalah elemen root dari setiap halaman HTML. Atribut lang menentukan bahasa konten:</p><pre><code>&lt;html lang="id"&gt;\n  ...\n&lt;/html&gt;</code></pre><h3>Bagian Head</h3><p>Elemen &lt;head&gt; berisi informasi metadata tentang halaman yang tidak ditampilkan secara langsung kepada pengguna:</p><ul><li>&lt;title&gt; - Judul halaman (muncul di tab browser)</li><li>&lt;meta charset="UTF-8"&gt; - Encoding karakter</li><li>&lt;meta name="viewport"&gt; - Pengaturan tampilan mobile</li><li>&lt;link&gt; - Menghubungkan file CSS eksternal</li></ul><h3>Bagian Body</h3><p>Semua konten yang terlihat oleh pengguna ditempatkan di dalam elemen &lt;body&gt;. Ini termasuk teks, gambar, video, form, dan semua elemen HTML lainnya.</p>'],
            ['order' => 3, 'title' => 'Tag dan Elemen HTML', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Tag dan Elemen HTML</h2><p>Memahami perbedaan antara tag dan elemen adalah hal fundamental dalam belajar HTML.</p><h3>Apa itu Tag HTML?</h3><p>Tag HTML adalah tanda yang menggunakan kurung sudut (< dan >). Sebagian besar tag HTML berpasangan: tag pembuka dan tag penutup.</p><pre><code>&lt;p&gt;Ini adalah sebuah paragraf.&lt;/p&gt;\n&lt;h1&gt;Ini adalah heading.&lt;/h1&gt;\n&lt;strong&gt;Ini teks tebal.&lt;/strong&gt;</code></pre><h3>Tag Tanpa Penutup (Void Elements)</h3><p>Beberapa tag HTML tidak memerlukan tag penutup karena tidak memiliki konten di dalamnya:</p><ul><li>&lt;br&gt; - Baris baru</li><li>&lt;hr&gt; - Garis horizontal</li><li>&lt;img&gt; - Gambar</li><li>&lt;input&gt; - Input form</li><li>&lt;meta&gt; - Metadata</li></ul><h3>Atribut HTML</h3><p>Tag HTML dapat memiliki atribut yang memberikan informasi tambahan. Atribut selalu ditulis di tag pembuka:</p><pre><code>&lt;a href="https://google.com" target="_blank"&gt;Google&lt;/a&gt;\n&lt;img src="foto.jpg" alt="Foto saya" width="300"&gt;\n&lt;input type="text" name="nama" placeholder="Masukkan nama"&gt;</code></pre><p>Atribut terdiri dari nama dan nilai yang dipisahkan tanda sama dengan (=), dengan nilai diapit tanda kutip.</p>'],
            ['order' => 4, 'title' => 'Heading dan Paragraf', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Heading dan Paragraf dalam HTML</h2><p>Heading dan paragraf adalah elemen teks paling dasar dalam HTML. Memahami penggunaannya yang tepat penting untuk aksesibilitas dan SEO.</p><h3>Elemen Heading (H1-H6)</h3><p>HTML menyediakan 6 level heading, dari H1 (terpenting, terbesar) hingga H6 (terkecil):</p><pre><code>&lt;h1&gt;Heading Level 1 - Judul Utama&lt;/h1&gt;\n&lt;h2&gt;Heading Level 2 - Sub Judul&lt;/h2&gt;\n&lt;h3&gt;Heading Level 3&lt;/h3&gt;\n&lt;h4&gt;Heading Level 4&lt;/h4&gt;\n&lt;h5&gt;Heading Level 5&lt;/h5&gt;\n&lt;h6&gt;Heading Level 6&lt;/h6&gt;</code></pre><h3>Praktik Terbaik Heading</h3><ul><li>Gunakan hanya SATU H1 per halaman (judul utama)</li><li>Jangan skip level (dari H1 langsung H3)</li><li>Heading digunakan untuk struktur, bukan hanya untuk ukuran teks</li></ul><h3>Elemen Paragraf</h3><p>Paragraf dibuat menggunakan tag &lt;p&gt;. Browser otomatis menambahkan margin atas dan bawah untuk setiap paragraf:</p><pre><code>&lt;p&gt;Ini adalah paragraf pertama dengan beberapa teks konten.&lt;/p&gt;\n&lt;p&gt;Ini adalah paragraf kedua yang terpisah dari yang pertama.&lt;/p&gt;</code></pre><h3>Format Teks Inline</h3><p>Dalam paragraf, kamu bisa menggunakan tag inline untuk memformat bagian teks:</p><ul><li>&lt;strong&gt; atau &lt;b&gt; - Teks <strong>tebal</strong></li><li>&lt;em&gt; atau &lt;i&gt; - Teks <em>miring</em></li><li>&lt;u&gt; - Teks bergaris bawah</li><li>&lt;mark&gt; - Teks disorot</li><li>&lt;small&gt; - Teks lebih kecil</li></ul>'],
            ['order' => 5, 'title' => 'Link dan Gambar', 'type' => 'code_example', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Link dan Gambar dalam HTML</h2><p>Link (tautan) dan gambar adalah dua elemen yang paling sering digunakan dalam pembuatan website.</p><h3>Membuat Hyperlink dengan Tag &lt;a&gt;</h3><p>Tag anchor &lt;a&gt; digunakan untuk membuat hyperlink. Atribut href menentukan URL tujuan:</p><pre><code>&lt;!-- Link ke website eksternal --&gt;\n&lt;a href="https://www.google.com"&gt;Kunjungi Google&lt;/a&gt;\n\n&lt;!-- Link ke halaman lain di website yang sama --&gt;\n&lt;a href="/tentang.html"&gt;Tentang Kami&lt;/a&gt;\n\n&lt;!-- Link yang membuka di tab baru --&gt;\n&lt;a href="https://github.com" target="_blank" rel="noopener"&gt;GitHub&lt;/a&gt;\n\n&lt;!-- Link ke bagian dalam halaman yang sama --&gt;\n&lt;a href="#kontak"&gt;Ke Bagian Kontak&lt;/a&gt;\n\n&lt;!-- Link email --&gt;\n&lt;a href="mailto:admin@eduplay.id"&gt;Kirim Email&lt;/a&gt;</code></pre><h3>Menampilkan Gambar dengan Tag &lt;img&gt;</h3><p>Tag &lt;img&gt; adalah void element (tidak perlu tag penutup) yang menampilkan gambar:</p><pre><code>&lt;!-- Gambar dari file lokal --&gt;\n&lt;img src="foto-profil.jpg" alt="Foto profil saya" width="200" height="200"&gt;\n\n&lt;!-- Gambar dari URL --&gt;\n&lt;img src="https://example.com/gambar.png" alt="Deskripsi gambar"&gt;</code></pre><h3>Atribut Penting pada &lt;img&gt;</h3><ul><li>&lt;code&gt;src&lt;/code&gt; - URL sumber gambar (wajib)</li><li>&lt;code&gt;alt&lt;/code&gt; - Teks alternatif untuk aksesibilitas (wajib)</li><li>&lt;code&gt;width&lt;/code&gt; &amp; &lt;code&gt;height&lt;/code&gt; - Ukuran gambar</li><li>&lt;code&gt;loading="lazy"&lt;/code&gt; - Lazy loading untuk performa</li></ul>'],
        ];

        foreach ($topic1Lessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic1->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic1->id])
            );
        }

        // TOPIC 2: Elemen Teks dan List
        $topic2 = Topic::updateOrCreate(
            ['learning_path_id' => $path1->id, 'title' => 'Elemen Teks dan List'],
            [
                'learning_path_id' => $path1->id,
                'title' => 'Elemen Teks dan List',
                'slug' => Str::slug('Elemen Teks dan List - Path 1'),
                'description' => 'Menguasai penggunaan list, tabel, dan elemen teks dalam HTML.',
                'order' => 2,
            ]
        );

        $topic2Lessons = [
            ['order' => 1, 'title' => 'List Ordered dan Unordered', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/PlxWf493en4', 'content' => '<h2>List Ordered dan Unordered</h2><p>List adalah cara yang sempurna untuk mengorganisir informasi yang bersifat urutan atau koleksi. HTML menyediakan dua jenis list utama: ordered list dan unordered list.</p><h3>Unordered List (&lt;ul&gt;)</h3><p>Unordered list digunakan ketika urutan item tidak penting. Setiap item ditandai dengan bullet point.</p><pre><code>&lt;ul&gt;\n  &lt;li&gt;Apel&lt;/li&gt;\n  &lt;li&gt;Jeruk&lt;/li&gt;\n  &lt;li&gt;Pisang&lt;/li&gt;\n  &lt;li&gt;Mangga&lt;/li&gt;\n&lt;/ul&gt;</code></pre><h3>Ordered List (&lt;ol&gt;)</h3><p>Ordered list digunakan ketika urutan item sangat penting. Setiap item diberi nomor otomatis.</p><pre><code>&lt;ol&gt;\n  &lt;li&gt;Buka browser&lt;/li&gt;\n  &lt;li&gt;Kunjungi website&lt;/li&gt;\n  &lt;li&gt;Klik link&lt;/li&gt;\n  &lt;li&gt;Baca konten&lt;/li&gt;\n&lt;/ol&gt;</code></pre><h3>List Bersarang (Nested Lists)</h3><p>List dapat bersarang di dalam list lain untuk membuat struktur yang lebih kompleks:</p><pre><code>&lt;ul&gt;\n  &lt;li&gt;Buah-buahan\n    &lt;ul&gt;\n      &lt;li&gt;Apel&lt;/li&gt;\n      &lt;li&gt;Jeruk&lt;/li&gt;\n    &lt;/ul&gt;\n  &lt;/li&gt;\n  &lt;li&gt;Sayuran\n    &lt;ul&gt;\n      &lt;li&gt;Bayam&lt;/li&gt;\n      &lt;li&gt;Brokoli&lt;/li&gt;\n    &lt;/ul&gt;\n  &lt;/li&gt;\n&lt;/ul&gt;</code></pre>'],
            ['order' => 2, 'title' => 'Tabel HTML', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Tabel HTML</h2><p>Tabel adalah cara yang efektif untuk menyajikan data dalam format baris dan kolom. HTML menyediakan elemen khusus untuk membuat tabel yang terstruktur dengan baik.</p><h3>Struktur Dasar Tabel</h3><p>Tabel HTML terdiri dari beberapa elemen utama:</p><ul><li>&lt;table&gt; - Container tabel</li><li>&lt;thead&gt; - Header tabel</li><li>&lt;tbody&gt; - Body/isi tabel</li><li>&lt;tr&gt; - Table row (baris)</li><li>&lt;th&gt; - Table header cell (header kolom)</li><li>&lt;td&gt; - Table data cell (sel data)</li></ul><h3>Contoh Tabel Lengkap</h3><pre><code>&lt;table&gt;\n  &lt;thead&gt;\n    &lt;tr&gt;\n      &lt;th&gt;Nama&lt;/th&gt;\n      &lt;th&gt;Kota&lt;/th&gt;\n      &lt;th&gt;Usia&lt;/th&gt;\n    &lt;/tr&gt;\n  &lt;/thead&gt;\n  &lt;tbody&gt;\n    &lt;tr&gt;\n      &lt;td&gt;Ahmad&lt;/td&gt;\n      &lt;td&gt;Jakarta&lt;/td&gt;\n      &lt;td&gt;25&lt;/td&gt;\n    &lt;/tr&gt;\n    &lt;tr&gt;\n      &lt;td&gt;Siti&lt;/td&gt;\n      &lt;td&gt;Surabaya&lt;/td&gt;\n      &lt;td&gt;23&lt;/td&gt;\n    &lt;/tr&gt;\n    &lt;tr&gt;\n      &lt;td&gt;Budi&lt;/td&gt;\n      &lt;td&gt;Bandung&lt;/td&gt;\n      &lt;td&gt;27&lt;/td&gt;\n    &lt;/tr&gt;\n  &lt;/tbody&gt;\n&lt;/table&gt;</code></pre><h3>Atribut Tabel Penting</h3><ul><li>colspan - Menggabungkan beberapa kolom</li><li>rowspan - Menggabungkan beberapa baris</li><li>border - Menambahkan border tabel</li></ul>'],
            ['order' => 3, 'title' => 'Form dan Input', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/fNcJuPIZ2WE', 'content' => '<h2>Form dan Input</h2><p>Form adalah cara utama untuk mengumpulkan input dari pengguna di website. Form dapat berisi berbagai jenis input fields seperti text, email, password, checkbox, radio button, dan banyak lagi.</p><h3>Struktur Dasar Form</h3><p>Setiap form dimulai dengan tag &lt;form&gt; dan memiliki atribut action (tujuan pengiriman) dan method (GET atau POST):</p><pre><code>&lt;form action="/submit" method="POST"&gt;\n  &lt;label for="nama"&gt;Nama:&lt;/label&gt;\n  &lt;input type="text" id="nama" name="nama" required&gt;\n  \n  &lt;label for="email"&gt;Email:&lt;/label&gt;\n  &lt;input type="email" id="email" name="email" required&gt;\n  \n  &lt;button type="submit"&gt;Kirim&lt;/button&gt;\n&lt;/form&gt;</code></pre><h3>Jenis-jenis Input</h3><ul><li>type="text" - Input teks biasa</li><li>type="email" - Input email dengan validasi</li><li>type="password" - Input password yang ter-mask</li><li>type="number" - Input angka</li><li>type="date" - Input tanggal</li><li>type="checkbox" - Checkbox untuk pilihan multiple</li><li>type="radio" - Radio button untuk pilihan tunggal</li></ul>'],
            ['order' => 4, 'title' => 'Div dan Span', 'type' => 'article', 'xp_reward' => 10, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Div dan Span</h2><p>Div dan span adalah dua elemen HTML yang paling umum digunakan untuk membungkus dan mengelompokkan konten. Keduanya tidak memiliki makna semantik khusus, tetapi sangat berguna untuk styling dan layout.</p><h3>Elemen Div (&lt;div&gt;)</h3><p>Div adalah elemen block-level yang digunakan untuk mengelompokkan blok konten yang besar. Setiap div akan memulai baris baru dan mengambil lebar penuh dari parent element.</p><pre><code>&lt;div class="container"&gt;\n  &lt;h1&gt;Judul Halaman&lt;/h1&gt;\n  &lt;p&gt;Paragraf konten&lt;/p&gt;\n  &lt;button&gt;Klik Saya&lt;/button&gt;\n&lt;/div&gt;</code></pre><h3>Elemen Span (&lt;span&gt;)</h3><p>Span adalah elemen inline yang digunakan untuk membungkus sejumlah kecil konten dalam baris teks. Span tidak memulai baris baru dan hanya mengambil ruang yang diperlukan untuk kontennya.</p><pre><code>&lt;p&gt;Halo &lt;span style="color: red;"&gt;Dunia&lt;/span&gt;!&lt;/p&gt;\n&lt;p&gt;Saya sedang &lt;span class="highlight"&gt;belajar&lt;/span&gt; HTML.&lt;/p&gt;</code></pre>'],
            ['order' => 5, 'title' => 'HTML Semantik', 'type' => 'article', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>HTML Semantik</h2><p>HTML semantik berarti menggunakan HTML tags yang memiliki makna yang jelas tentang konten yang dibungkusnya. Semantic HTML meningkatkan aksesibilitas, SEO, dan keterbacaan kode.</p><h3>Elemen-elemen Semantik Utama</h3><p>HTML5 memperkenalkan beberapa elemen semantik yang menggantikan penggunaan div generik:</p><ul><li>&lt;header&gt; - Header halaman atau section</li><li>&lt;nav&gt; - Navigation/menu</li><li>&lt;main&gt; - Konten utama halaman</li><li>&lt;article&gt; - Konten independen seperti blog post</li><li>&lt;section&gt; - Bagian tematik dari konten</li><li>&lt;aside&gt; - Sidebar atau konten sampingan</li><li>&lt;footer&gt; - Footer halaman atau section</li></ul><h3>Manfaat HTML Semantik</h3><ul><li>Meningkatkan aksesibilitas untuk screen readers</li><li>Memudahkan mesin pencari memahami struktur halaman (SEO)</li><li>Kode lebih mudah dibaca dan dipahami developer</li><li>Membantu browser memahami layout dengan lebih baik</li></ul>'],
        ];

        foreach ($topic2Lessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic2->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic2->id])
            );
        }

        // TOPIC 3: Multimedia dan Formulir
        $topic3 = Topic::updateOrCreate(
            ['learning_path_id' => $path1->id, 'title' => 'Multimedia dan Formulir'],
            [
                'learning_path_id' => $path1->id,
                'title' => 'Multimedia dan Formulir',
                'slug' => Str::slug('Multimedia dan Formulir - Path 1'),
                'description' => 'Menguasai elemen multimedia dan form validation dalam HTML5.',
                'order' => 3,
            ]
        );

        $topic3Lessons = [
            ['order' => 1, 'title' => 'Audio dalam HTML', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/K0NI3DM5p6A', 'content' => '<h2>Audio dalam HTML</h2><p>HTML5 memperkenalkan tag &lt;audio&gt; yang memungkinkan kamu untuk menyematkan file audio langsung dalam halaman web tanpa memerlukan plugin eksternal.</p><h3>Tag Audio Dasar</h3><p>Tag &lt;audio&gt; memiliki atribut controls yang menampilkan player audio dengan tombol play/pause, volume, dan progress bar:</p><pre><code>&lt;audio controls&gt;\n  &lt;source src="lagu.mp3" type="audio/mpeg"&gt;\n  Browser Anda tidak mendukung tag audio.\n&lt;/audio&gt;</code></pre><h3>Atribut Audio Penting</h3><ul><li>controls - Menampilkan player controls</li><li>autoplay - Memutar otomatis saat halaman dimuat</li><li>loop - Mengulang pemutaran</li><li>muted - Mute audio secara default</li><li>preload - Preload audio (none, metadata, auto)</li></ul>'],
            ['order' => 2, 'title' => 'Video dalam HTML', 'type' => 'video', 'xp_reward' => 15, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/9-oFJL-S1kU', 'content' => '<h2>Video dalam HTML</h2><p>Tag &lt;video&gt; HTML5 memungkinkan kamu untuk menyematkan video langsung dalam halaman web dengan kontrol player yang lengkap.</p><h3>Tag Video Dasar</h3><p>Mirip dengan audio, tag video juga menggunakan elemen &lt;source&gt; untuk menentukan file video dan format nya:</p><pre><code>&lt;video width="640" height="480" controls&gt;\n  &lt;source src="film.mp4" type="video/mp4"&gt;\n  Browser Anda tidak mendukung tag video.\n&lt;/video&gt;</code></pre><h3>Atribut Video Penting</h3><ul><li>width & height - Ukuran video</li><li>controls - Menampilkan video controls</li><li>autoplay - Memutar otomatis saat halaman dimuat</li><li>loop - Mengulang pemutaran</li><li>muted - Mute audio video secara default</li><li>poster - Gambar thumbnail sebelum video dimulai</li></ul>'],
            ['order' => 3, 'title' => 'Input Validation', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Input Validation dalam HTML5</h2><p>HTML5 menyediakan validasi input bawaan yang dapat membantu memastikan data yang dimasukkan pengguna valid tanpa perlu JavaScript tambahan.</p><h3>Atribut Validasi HTML5</h3><ul><li>required - Field wajib diisi</li><li>minlength & maxlength - Panjang minimum dan maksimum</li><li>min & max - Nilai minimum dan maksimum untuk input number</li><li>pattern - Validasi menggunakan regular expression</li><li>type - Type input dengan validasi bawaan (email, number, url, date, dsb)</li></ul><h3>Contoh Validasi Input</h3><pre><code>&lt;form&gt;\n  &lt;!-- Email validation --&gt;\n  &lt;input type="email" required placeholder="Masukkan email"&gt;\n  \n  &lt;!-- Password dengan minimum length --&gt;\n  &lt;input type="password" minlength="8" required placeholder="Minimal 8 karakter"&gt;\n  \n  &lt;!-- Number dengan range --&gt;\n  &lt;input type="number" min="1" max="100" required placeholder="Angka 1-100"&gt;\n  \n  &lt;!-- URL validation --&gt;\n  &lt;input type="url" required placeholder="https://example.com"&gt;\n  \n  &lt;!-- Date input --&gt;\n  &lt;input type="date" required&gt;\n  \n  &lt;button type="submit"&gt;Kirim&lt;/button&gt;\n&lt;/form&gt;</code></pre>'],
            ['order' => 4, 'title' => 'Advanced Form Elements', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Advanced Form Elements HTML5</h2><p>HTML5 memperkenalkan beberapa input types dan form elements baru yang mempermudah pengambilan input khusus dari pengguna.</p><h3>Input Types HTML5 Baru</h3><ul><li>color - Pemilih warna</li><li>date - Pemilih tanggal</li><li>datetime-local - Pemilih tanggal dan waktu</li><li>month - Pemilih bulan</li><li>time - Pemilih waktu</li><li>week - Pemilih minggu</li><li>range - Slider input</li><li>search - Input pencarian</li><li>tel - Input telepon</li><li>url - Input URL dengan validasi</li><li>email - Input email dengan validasi</li></ul>'],
            ['order' => 5, 'title' => 'HTML5 Features', 'type' => 'article', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>HTML5 Features Tambahan</h2><p>HTML5 memperkenalkan banyak fitur baru yang meningkatkan fungsionalitas dan kemampuan web development.</p><h3>Data Attributes</h3><p>Data attributes memungkinkan kamu menyimpan data custom pada element HTML yang dapat diakses via JavaScript:</p><pre><code>&lt;div data-user-id="12345" data-username="ahmad"&gt;\n  Ahmad\n&lt;/div&gt;\n\n&lt;script&gt;\n  const div = document.querySelector("div");\n  console.log(div.dataset.userId);  // "12345"\n  console.log(div.dataset.username); // "ahmad"\n&lt;/script&gt;</code></pre><h3>Progress Bar</h3><pre><code>&lt;progress value="70" max="100"&gt;&lt;/progress&gt;</code></pre>'],
        ];

        foreach ($topic3Lessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic3->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic3->id])
            );
        }

        // =====================================================
        // PATH 2: CSS & Styling Modern (8 hours)
        // =====================================================
        $path2 = LearningPath::updateOrCreate(
            ['slug' => Str::slug('CSS & Styling Modern')],
            [
                'title' => 'CSS & Styling Modern',
                'slug' => Str::slug('CSS & Styling Modern'),
                'description' => 'Kuasai CSS modern termasuk Flexbox, Grid, dan responsive design untuk membuat UI yang indah.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=300&fit=crop',
                'order' => 2,
                'difficulty' => 'beginner',
                'is_published' => true,
                'estimated_hours' => 8,
            ]
        );

        // TOPIC 1: Dasar CSS
        $topic2_1 = Topic::updateOrCreate(
            ['learning_path_id' => $path2->id, 'title' => 'Dasar CSS'],
            [
                'learning_path_id' => $path2->id,
                'title' => 'Dasar CSS',
                'slug' => Str::slug('Dasar CSS - Path 2'),
                'description' => 'Pelajari fundamentals CSS untuk styling halaman web.',
                'order' => 1,
            ]
        );

        $lessonsData = [
            ['order' => 1, 'title' => 'Pengenalan CSS', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/OXGznpKZ_Aw', 'content' => '<h2>Pengenalan CSS</h2><p>CSS (Cascading Style Sheets) adalah bahasa yang digunakan untuk menata dan mengatur tampilan elemen HTML. CSS memisahkan konten (HTML) dari presentasi (CSS).</p><h3>Tiga Cara Menggunakan CSS</h3><ul><li>Inline CSS - CSS langsung di tag HTML</li><li>Internal CSS - CSS di dalam tag &lt;style&gt; di head</li><li>External CSS - CSS di file terpisah (.css)</li></ul><h3>Contoh Dasar</h3><pre><code>/* External CSS (style.css) */\nbody {\n  background-color: #f0f0f0;\n  font-family: Arial, sans-serif;\n}\n\nh1 {\n  color: #333;\n  font-size: 28px;\n}</code></pre>'],
            ['order' => 2, 'title' => 'Selectors dan Properti CSS', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Selectors dan Properti CSS</h2><p>Selector adalah cara CSS memilih elemen HTML yang ingin kita style. Properti CSS menentukan gaya apa yang akan diterapkan.</p><h3>Jenis Selector Utama</h3><ul><li>Element selector: h1, p, div</li><li>Class selector: .class-name</li><li>ID selector: #id-name</li><li>Attribute selector: [type="text"]</li><li>Pseudo-class: :hover, :focus, :first-child</li></ul><h3>Properti CSS Umum</h3><ul><li>color - Warna teks</li><li>background-color - Warna latar belakang</li><li>font-size - Ukuran font</li><li>padding - Ruang dalam</li><li>margin - Ruang luar</li></ul>'],
            ['order' => 3, 'title' => 'Box Model CSS', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/rIO5326Z-2Y', 'content' => '<h2>Box Model CSS</h2><p>Box Model adalah konsep dasar CSS yang menggambarkan bagaimana setiap elemen direpresentasikan sebagai kotak persegi.</p><h3>Komponen Box Model</h3><ul><li>Content - Konten elemen (teks, gambar)</li><li>Padding - Ruang di dalam kotak</li><li>Border - Garis di sekeliling padding</li><li>Margin - Ruang di luar border</li></ul><pre><code>.box {\n  width: 200px;\n  padding: 20px;\n  border: 2px solid #333;\n  margin: 10px;\n}</code></pre>'],
            ['order' => 4, 'title' => 'Positioning dan Display', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Positioning dan Display CSS</h2><p>Properti position dan display mengontrol bagaimana elemen ditata di halaman.</p><h3>Nilai Display</h3><ul><li>block - Menempati lebar penuh</li><li>inline - Hanya menempati ruang konten</li><li>inline-block - Kombinasi block dan inline</li><li>flex - Flexbox layout</li><li>grid - CSS Grid layout</li></ul><h3>Nilai Position</h3><ul><li>static - Default positioning</li><li>relative - Relative ke posisi normalnya</li><li>absolute - Absolute ke parent yang positioned</li><li>fixed - Fixed relative to viewport</li><li>sticky - Sticky positioning</li></ul>'],
            ['order' => 5, 'title' => 'CSS Color dan Typography', 'type' => 'article', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>CSS Color dan Typography</h2><p>Warna dan tipografi adalah elemen penting dalam desain web.</p><h3>Format Warna CSS</h3><ul><li>Named colors: red, blue, green</li><li>Hex: #FF5733</li><li>RGB: rgb(255, 87, 51)</li><li>RGBA: rgba(255, 87, 51, 0.5)</li><li>HSL: hsl(9, 100%, 60%)</li></ul><h3>Font Properties</h3><pre><code>body {\n  font-family: "Poppins", sans-serif;\n  font-size: 16px;\n  font-weight: 400;\n  line-height: 1.6;\n  letter-spacing: 0.5px;\n}</code></pre>'],
        ];

        foreach ($lessonsData as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic2_1->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic2_1->id])
            );
        }

        // TOPIC 2: Layout dengan Flexbox
        $topic2_2 = Topic::updateOrCreate(
            ['learning_path_id' => $path2->id, 'title' => 'Layout dengan Flexbox'],
            [
                'learning_path_id' => $path2->id,
                'title' => 'Layout dengan Flexbox',
                'slug' => Str::slug('Layout dengan Flexbox - Path 2'),
                'description' => 'Kuasai Flexbox untuk membuat layout responsive dengan mudah.',
                'order' => 2,
            ]
        );

        $flexLessons = [
            ['order' => 1, 'title' => 'Pengenalan Flexbox', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/FTlczfKDsAU', 'content' => '<h2>Pengenalan Flexbox</h2><p>Flexbox adalah cara modern untuk membuat layout yang flexible dan responsive dengan minimal CSS.</p><h3>Display Flex</h3><pre><code>.container {\n  display: flex;\n  flex-direction: row; /* atau column */\n  justify-content: center; /* align horizontal */\n  align-items: center; /* align vertical */\n  gap: 1rem; /* space between items */\n}</code></pre>'],
            ['order' => 2, 'title' => 'Flex Properties', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Flex Properties</h2><p>Properti flex mengontrol bagaimana flex items tumbuh dan menyusut.</p><h3>Main Flex Properties</h3><ul><li>flex-grow - Grow factor</li><li>flex-shrink - Shrink factor</li><li>flex-basis - Base size</li><li>flex - Shorthand</li></ul>'],
            ['order' => 3, 'title' => 'Flexbox Layout Patterns', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/k-_28FM1qEc', 'content' => '<h2>Flexbox Layout Patterns</h2><p>Common patterns dengan Flexbox untuk layout web yang complex.</p><h3>Navigation Bar</h3><pre><code>nav {\n  display: flex;\n  justify-content: space-between;\n  align-items: center;\n}</code></pre>'],
            ['order' => 4, 'title' => 'Centering dengan Flexbox', 'type' => 'article', 'xp_reward' => 10, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Centering dengan Flexbox</h2><p>Cara termudah untuk center elemen di halaman.</p><pre><code>.center-box {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  height: 100vh; /* Full viewport height */\n}</code></pre>'],
            ['order' => 5, 'title' => 'Responsive Flexbox', 'type' => 'code_example', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Responsive Flexbox</h2><p>Membuat Flexbox yang responsive untuk semua ukuran layar.</p><pre><code>.gallery {\n  display: flex;\n  flex-wrap: wrap;\n  gap: 1rem;\n}\n\n@media (max-width: 768px) {\n  .gallery {\n    flex-direction: column;\n  }\n}</code></pre>'],
        ];

        foreach ($flexLessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic2_2->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic2_2->id])
            );
        }

        // TOPIC 3: Responsive Design
        $topic2_3 = Topic::updateOrCreate(
            ['learning_path_id' => $path2->id, 'title' => 'Responsive Design'],
            [
                'learning_path_id' => $path2->id,
                'title' => 'Responsive Design',
                'slug' => Str::slug('Responsive Design - Path 2'),
                'description' => 'Buat website yang responsive di semua perangkat.',
                'order' => 3,
            ]
        );

        $responsiveLessons = [
            ['order' => 1, 'title' => 'Media Queries', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/yU7jJ3NbPdA', 'content' => '<h2>Media Queries</h2><p>Media queries memungkinkan CSS berbeda untuk device yang berbeda.</p><pre><code>@media (max-width: 768px) {\n  .container {\n    padding: 1rem;\n  }\n}</code></pre>'],
            ['order' => 2, 'title' => 'Mobile First Design', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Mobile First Design</h2><p>Mobile first adalah pendekatan design yang dimulai dari mobile.</p>'],
            ['order' => 3, 'title' => 'CSS Grid Layout', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/EiNiSFIPIQE', 'content' => '<h2>CSS Grid Layout</h2><p>CSS Grid adalah sistem layout dua dimensi yang powerful.</p><pre><code>.grid {\n  display: grid;\n  grid-template-columns: repeat(3, 1fr);\n  gap: 1rem;\n}</code></pre>'],
            ['order' => 4, 'title' => 'CSS Animations', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>CSS Animations</h2><p>Buat animasi dengan CSS tanpa JavaScript.</p><pre><code>@keyframes slideIn {\n  from { transform: translateX(-100%); }\n  to { transform: translateX(0); }\n}\n\n.slide {\n  animation: slideIn 0.5s ease;\n}</code></pre>'],
            ['order' => 5, 'title' => 'CSS Variables', 'type' => 'article', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>CSS Variables</h2><p>Gunakan CSS variables untuk theme yang dinamis.</p><pre><code>:root {\n  --primary-color: #6366f1;\n  --spacing: 1rem;\n}\n\n.button {\n  background: var(--primary-color);\n  padding: var(--spacing);\n}</code></pre>'],
        ];

        foreach ($responsiveLessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic2_3->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic2_3->id])
            );
        }

        // =====================================================
        // PATH 3: PHP & Laravel (15 hours)
        // =====================================================
        $path3 = LearningPath::updateOrCreate(
            ['slug' => Str::slug('PHP & Laravel')],
            [
                'title' => 'PHP & Laravel',
                'slug' => Str::slug('PHP & Laravel'),
                'description' => 'Pelajari PHP dan Laravel framework untuk backend web development yang kuat.',
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=300&fit=crop',
                'order' => 3,
                'difficulty' => 'intermediate',
                'is_published' => true,
                'estimated_hours' => 15,
            ]
        );

        // TOPIC 1: Dasar PHP
        $topic3_1 = Topic::updateOrCreate(
            ['learning_path_id' => $path3->id, 'title' => 'Dasar PHP'],
            [
                'learning_path_id' => $path3->id,
                'title' => 'Dasar PHP',
                'slug' => Str::slug('Dasar PHP - Path 3'),
                'description' => 'Pelajari fundamentals PHP untuk web development.',
                'order' => 1,
            ]
        );

        $phpLessons = [
            ['order' => 1, 'title' => 'PHP Syntax & Variables', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/OK_JCtsSRA0', 'content' => '<h2>PHP Syntax & Variables</h2><p>PHP adalah bahasa server-side yang powerful untuk web development.</p><h3>Syntax Dasar</h3><pre><code>&lt;?php\n  echo "Hello World";\n  $name = "Ahmad";\n  echo "Nama saya: " . $name;\n?&gt;</code></pre>'],
            ['order' => 2, 'title' => 'Control Structures', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Control Structures PHP</h2><p>If, loops, dan switch untuk logic programming.</p><pre><code>if ($age >= 18) {\n  echo "Dewasa";\n} else {\n  echo "Anak-anak";\n}\n\nfor ($i = 0; $i < 10; $i++) {\n  echo $i;\n}</code></pre>'],
            ['order' => 3, 'title' => 'Functions & Arrays', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/jFCHUg3ZrzE', 'content' => '<h2>Functions & Arrays</h2><p>Buat reusable code dengan functions dan kelola data dengan arrays.</p><pre><code>function greet($name) {\n  return "Hello, " . $name;\n}\n\n$fruits = ["Apple", "Banana", "Orange"];\necho $fruits[0]; // Apple</code></pre>'],
            ['order' => 4, 'title' => 'Working with Forms', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Working with Forms PHP</h2><p>Proses form data dengan $_GET dan $_POST.</p><pre><code>if ($_SERVER["REQUEST_METHOD"] == "POST") {\n  $name = $_POST["name"];\n  echo "Hello, " . htmlspecialchars($name);\n}</code></pre>'],
            ['order' => 5, 'title' => 'Database Basics', 'type' => 'code_example', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Database Basics</h2><p>Connect ke MySQL dan execute queries.</p><pre><code>$mysqli = new mysqli("localhost", "user", "pass", "database");\n$result = $mysqli->query("SELECT * FROM users");\nwhile($row = $result->fetch_assoc()) {\n  echo $row["name"];\n}</code></pre>'],
        ];

        foreach ($phpLessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic3_1->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic3_1->id])
            );
        }

        // TOPIC 2: OOP PHP
        $topic3_2 = Topic::updateOrCreate(
            ['learning_path_id' => $path3->id, 'title' => 'OOP PHP'],
            [
                'learning_path_id' => $path3->id,
                'title' => 'OOP PHP',
                'slug' => Str::slug('OOP PHP - Path 3'),
                'description' => 'Object-Oriented Programming dalam PHP.',
                'order' => 2,
            ]
        );

        $oopLessons = [
            ['order' => 1, 'title' => 'Classes & Objects', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/bHn8RnfAQZ4', 'content' => '<h2>Classes & Objects</h2><p>Object-oriented programming dengan classes.</p><pre><code>class Car {\n  public $brand;\n  \n  public function __construct($brand) {\n    $this->brand = $brand;\n  }\n  \n  public function drive() {\n    return "Driving " . $this->brand;\n  }\n}\n\n$car = new Car("Toyota");</code></pre>'],
            ['order' => 2, 'title' => 'Inheritance & Polymorphism', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Inheritance & Polymorphism</h2><p>Inheritance untuk reusable code dan polymorphism untuk flexibility.</p><pre><code>class Vehicle {\n  public function start() {\n    return "Starting...";\n  }\n}\n\nclass Motorcycle extends Vehicle {\n  public function start() {\n    return "Motorcycle starting...";\n  }\n}</code></pre>'],
            ['order' => 3, 'title' => 'Interfaces & Traits', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/z0W8V5qwWJI', 'content' => '<h2>Interfaces & Traits</h2><p>Gunakan interfaces untuk kontrak dan traits untuk code sharing.</p>'],
            ['order' => 4, 'title' => 'Namespaces & Autoloading', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Namespaces & Autoloading</h2><p>Organise code dengan namespaces dan autoload classes dengan composer.</p>'],
            ['order' => 5, 'title' => 'Design Patterns', 'type' => 'code_example', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Design Patterns</h2><p>Common design patterns seperti Singleton, Factory, dan Observer.</p>'],
        ];

        foreach ($oopLessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic3_2->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic3_2->id])
            );
        }

        // TOPIC 3: Laravel Fundamentals
        $topic3_3 = Topic::updateOrCreate(
            ['learning_path_id' => $path3->id, 'title' => 'Laravel Fundamentals'],
            [
                'learning_path_id' => $path3->id,
                'title' => 'Laravel Fundamentals',
                'slug' => Str::slug('Laravel Fundamentals - Path 3'),
                'description' => 'Pelajari Laravel framework untuk modern PHP development.',
                'order' => 3,
            ]
        );

        $laravelLessons = [
            ['order' => 1, 'title' => 'Laravel Setup & Project Structure', 'type' => 'video', 'xp_reward' => 10, 'is_free' => true, 'video_url' => 'https://www.youtube.com/embed/MFh0Fd7BsjE', 'content' => '<h2>Laravel Setup & Project Structure</h2><p>Install Laravel dan pahami struktur project.</p><pre><code>composer create-project laravel/laravel myapp\ncd myapp\nphp artisan serve</code></pre>'],
            ['order' => 2, 'title' => 'Routing & Controllers', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Routing & Controllers</h2><p>Definisikan routes dan buat controllers untuk handle request.</p><pre><code>// routes/web.php\nRoute::get("/dashboard", [DashboardController::class, "index"]);</code></pre>'],
            ['order' => 3, 'title' => 'Blade Template Engine', 'type' => 'video', 'xp_reward' => 15, 'is_free' => false, 'video_url' => 'https://www.youtube.com/embed/SdXm5Y73XMc', 'content' => '<h2>Blade Template Engine</h2><p>Laravel Blade untuk powerful templating.</p><pre><code>{{-- resources/views/welcome.blade.php --}}\n@extends("layouts.app")\n\n@section("content")\n  &lt;h1&gt;{{ $title }}&lt;/h1&gt;\n@endsection</code></pre>'],
            ['order' => 4, 'title' => 'Eloquent ORM', 'type' => 'article', 'xp_reward' => 15, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Eloquent ORM</h2><p>Eloquent untuk database operations dengan elegant syntax.</p><pre><code>$posts = Post::where("is_published", true)->get();\n$post = Post::find($id);\n$post->update(["title" => "New Title"]);</code></pre>'],
            ['order' => 5, 'title' => 'Migrations & Seeding', 'type' => 'code_example', 'xp_reward' => 20, 'is_free' => false, 'video_url' => null, 'content' => '<h2>Migrations & Seeding</h2><p>Manage database schema dengan migrations dan seed data dengan seeders.</p><pre><code>php artisan make:migration create_posts_table\nphp artisan migrate\nphp artisan db:seed</code></pre>'],
        ];

        foreach ($laravelLessons as $lessonData) {
            Lesson::updateOrCreate(
                ['topic_id' => $topic3_3->id, 'title' => $lessonData['title']],
                array_merge($lessonData, ['topic_id' => $topic3_3->id])
            );
        }
    }
}
