@extends('layouts.app')
@section('page-title', 'Code Editor')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">💻 Code Editor</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Tulis, jalankan, dan simpan kode langsung di browser.</p>
    </div>
    <div class="flex gap-2">
        @php $lang = request('lang', 'html'); @endphp
        @foreach(['html'=>'🌐 HTML','css'=>'🎨 CSS','javascript'=>'⚡ JS','php'=>'🐘 PHP'] as $l => $label)
        <a href="{{ route('editor.index', ['lang' => $l]) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all
                  {{ $lang === $l ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 h-[65vh]">
    {{-- Editor --}}
    <div class="bg-slate-950 rounded-2xl overflow-hidden flex flex-col border border-slate-700">
        <div class="flex items-center justify-between px-4 py-2.5 bg-slate-900 border-b border-slate-700">
            <div class="flex gap-1.5">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
            </div>
            <span class="text-xs text-slate-400 font-mono">{{ $lang }}.{{ $lang === 'javascript' ? 'js' : $lang }}</span>
            <button onclick="runCode()" class="text-xs bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded-lg font-semibold transition-colors">
                ▶ Run
            </button>
        </div>
        <textarea id="codeInput"
                  class="flex-1 bg-slate-950 text-green-400 font-mono text-sm p-4 resize-none outline-none w-full"
                  spellcheck="false"
                  placeholder="// Tulis kode kamu di sini...">{{ $starterCode ?? '' }}</textarea>
    </div>
{{-- Preview --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden flex flex-col border border-slate-200 dark:border-slate-700">
    <div class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center gap-2">
        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
        <span class="text-xs text-slate-500">Output Preview</span>
    </div>
    <iframe id="preview" class="flex-1 w-full border-0" sandbox="allow-scripts allow-same-origin"></iframe>
</div>
</div>
{{-- Save snippet button --}}
<div class="mt-4 flex gap-3">
    <input id="snippetTitle" type="text" placeholder="Judul snippet..." value="Untitled"
           class="flex-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500">
    <form action="{{ route('editor.save') }}" method="POST" id="saveForm">
        @csrf
        <input type="hidden" name="title" id="saveTitle">
        <input type="hidden" name="language" value="{{ $lang }}">
        <input type="hidden" name="code" id="saveCode">
        <button type="submit" onclick="prepSave()"
                class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm">
            💾 Simpan
        </button>
    </form>
</div>
@push('scripts')
<script>
function runCode() {
    const code = document.getElementById('codeInput').value;
    const lang = '{{ $lang }}';
    const preview = document.getElementById('preview');
    if (lang === 'html') {
        preview.srcdoc = code;
    } else if (lang === 'css') {
        preview.srcdoc = `<html><head><style>${code}</style></head><body><h1>Preview</h1><p>Teks ini dipengaruhi style kamu.</p><button>Tombol</button></body></html>`;
} else if (lang === 'javascript') {
    preview.srcdoc = `<html><body style="font-family:sans-serif;padding:1rem"><div id="output">Output muncul di sini...</div><button id="btn" style="padding:.5rem 1rem;background:#4f46e5;color:white;border:none;border-radius:.5rem;cursor:pointer;margin-top:1rem">Klik</button><script>${code}<\/script></body></html>`;
} else {
    preview.srcdoc = `<html><body style="font-family:monospace;padding:1rem;background:#1e1e1e;color:#d4d4d4"><pre>PHP tidak bisa dijalankan langsung di browser.\nSimpan snippet dan buka di server.</pre></body></html>`;
}
}
function prepSave() {
document.getElementById('saveTitle').value = document.getElementById('snippetTitle').value;
document.getElementById('saveCode').value = document.getElementById('codeInput').value;
}
// Auto run saat halaman load
window.onload = () => runCode();
</script>
@endpush
@endsection