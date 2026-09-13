<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'وبلاگ هوش مصنوعی') }} - جدیدترین مقالات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- هدر سایت -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-xl font-black('home') }}" class="text-xl font-black-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>مجله هوش مصنوعی</span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('contents.index') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition">
                        پنل مدیریت مقالات
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">ورود مدیر</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- بخش اصلی محتوا -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">

        <!-- بنر بالا و نوار جستجو -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                جدیدترین مقالات و تحلیل‌های هوشمند
            </h1>
            <p class="text-gray-600 text-base mb-6">
                مطالبی غنی و تولید شده با کمک مدرن‌ترین مدل‌های زبانی هوش مصنوعی.
            </p>

            <form method="GET" action="{{ route('home') }}" class="flex gap-2 max-w-lg mx-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجو در مقالات..."
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white shadow-sm text-sm">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm transition text-sm flex items-center gap-1">
                    جستجو
                </button>
            </form>
        </div>

        <!-- لیست مقالات -->
        @if($contents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($contents as $article)
                    <article class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">

                        {{-- تصویر شاخص با نسبت ابعاد ثابت 16:9 --}}
                        <a href="{{ route('public.articles.show', $article->slug) }}"
                           class="block relative w-full aspect-video overflow-hidden bg-gray-100">
                            @if($article->image_path)
                                <img src="{{ asset('storage/' . ltrim($article->image_path, '/')) }}"
                                     alt="{{ $article->title }}"
                                     loading="lazy"
                                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-bl from-indigo-500 to-purple-600 flex items-center justify-center\'><svg class=\'w-10 h-10 text-white opacity-80\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13 10V3L4 14h7v7l9-11h-7z\' /></svg></div>';">
                            @else
                                <div class="w-full h-full bg-gradient-to-bl from-indigo-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            @endif
                        </a>

                        <div class="p-6 flex flex-col flex-grow">
                            <h2 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 hover:text-indigo-600 transition">
                                <a href="{{ route('public.articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                                {{ $article->summary ?: Str::limit(strip_tags($article->body), 120) }}
                            </p>
                        </div>

                        <div class="px-6 py-4 mt-auto flex items-center justify-between border-t border-gray-100">
                            @if($article->keywords)
                                <div class="flex gap-1 flex-wrap">
                                    @foreach(array_slice(explode(',', $article->keywords), 0, 2) as $tag)
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">#{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span></span>
                            @endif

                            <a href="{{ route('public.articles.show', $article->slug) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                ادامه مطلب
                                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- صفحه‌بندی -->
            <div class="mt-10">
                {{ $contents->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
                <p class="text-gray-500 text-base">هنوز مقاله‌ای منتشر نشده است یا موردی با جستجوی شما مطابقت ندارد.</p>
            </div>
        @endif

    </main>

    <!-- فوتر -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-16 text-center text-xs text-gray-500">
        <p>© {{ date('Y') }} تمام حقوق برای این وبلاگ محفوظ است.</p>
    </footer>

</body>
</html>
