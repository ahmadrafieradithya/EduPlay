<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'html');

        // Normalize possible aliases
        if ($lang === 'js') {
            $lang = 'javascript';
        }

        $starters = [
            'html' => "<!doctype html>\n<html>\n<head>\n  <meta charset=\"utf-8\">\n  <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n  <title>EduPlay - Preview</title>\n</head>\n<body>\n  <h1>Hello EduPlay</h1>\n  <p>Mulai menulis HTML di sini...</p>\n</body>\n</html>",
            'css' => "/* CSS Starter */\nbody {\n  font-family: system-ui, -apple-system, 'Segoe UI', Roboto;\n  background: #fff;\n  color: #111827;\n}\n/* Tambahkan gaya Anda di sini */",
            'javascript' => "// JavaScript Starter\nconsole.log('Hello EduPlay');\n// Tulis kode JS Anda di sini",
            'php' => "<?php\n// PHP Starter\necho \"Halo EduPlay!\";\n// Gunakan ini untuk snippet PHP sederhana\n",
        ];

        $starter = $starters[$lang] ?? $starters['html'];

        // View expects $starterCode variable
        $starterCode = $starter;

        return view('editor.index', compact('lang', 'starterCode'));
    }

    // ✅ TAMBAHKAN METHOD INI di bawah method index():
    public function save(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:100',
            'language' => 'required|in:html,css,javascript,php,js',
            'code'     => 'required|string',
        ]);

        $language = $request->language === 'js' ? 'javascript' : $request->language;

        \App\Models\CodeSnippet::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'language'    => $language,
            'code'        => $request->code,
            'is_public'   => false,
            'share_token' => \Illuminate\Support\Str::random(16),
        ]);

        return back()->with('success', 'Snippet berhasil disimpan! 💾');
    }
}