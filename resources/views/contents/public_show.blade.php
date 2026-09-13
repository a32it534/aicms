<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $content->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }

        /* استایل اختصاصی برای محتوای تولیدشده */
        .article-content p {
            margin-bottom: 1.25rem;
            line-height: 2.1;
            color: #374151;
            text-align: justify;
        }

        .article-content h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #111827;
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-right: 0.75rem;
            border-right: 4px solid #4f46e5;
        }

        .article-content h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .article-content ul, .article-content ol {
            margin-right: 1.5rem;
            margin-bottom: 1.25rem;
            list-style-type: disc;
        }

        .article-content li {
            margin-bottom: 0.5rem;
            line-height: 1.9;
            color: #374151;
        }

        .article-content strong {
            color: #111827;
            font-weight: 700;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col justify-between">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-indigo-600 font-bold flex items-center gap-1.5 text-sm hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                بازگشت به صفحه اصلی
            </a>
            @auth
                <a href="{{ route('contents.edit', $content) }}" class="text-xs bg-amber-100 text-amber-800 font-medium px-3 py-1.5 rounded-lg hover:bg-amber-200 transition">
                    ویرایش این مقاله
                </a>
            @endauth
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex-grow w-full">
        <article class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-10 shadow-sm">
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                <span>انتشار: {{ $content->created_at->format('Y/m/d') }}</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $content->title }}
            </h1>

            {{-- نمایش تصویر شاخص --}}
            @if($content->image_path)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . ltrim($content->image_path, '/')) }}" 
                         class="w-full h-64 sm:h-80 object-cover rounded-xl shadow-sm">
                </div>
            @endif

            @if($content->summary)
                <div class="bg-indigo-50 border-r-4 border-indigo-500 p-4 rounded-lg text-indigo-950 text-sm leading-relaxed mb-8">
                    <strong class="block mb-1 font-bold">چکیده مقاله:</strong>
                    {{ $content->summary }}
                </div>
            @endif

            <!-- متن مقاله بدون escape شدن تگ‌های HTML -->
            <div class="article-content max-w-none text-base">
                {!! $content->body !!}
            </div>

            @if($content->keywords)
                <div class="mt-10 pt-6 border-t border-gray-100 flex flex-wrap gap-2 items-center">
                    <span class="text-xs text-gray-400">کلمات کلیدی:</span>
                    @foreach(explode(',', $content->keywords) as $tag)
                        @if(trim($tag))
                            <span class="text-xs bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">#{{ trim($tag) }}</span>
                        @endif
                    @endforeach
                </div>
            @endif
        </article>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 text-center text-xs text-gray-500">
        <p>© {{ date('Y') }} تمام حقوق برای این وبلاگ محفوظ است.</p>
    </footer>

</body>
</html>
