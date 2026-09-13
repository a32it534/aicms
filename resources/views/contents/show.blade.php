@extends('layouts.app')

@section('title', $content->title)

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        {{-- وضعیت و عملیات --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pb-3 border-bottom">
            <div>
                <span class="badge {{ $content->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }} mb-2">
                    {{ $content->status === 'published' ? 'منتشر شده' : 'پیش‌نویس' }}
                </span>
                <h1 class="h4 mb-0 fw-bold">{{ $content->title }}</h1>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('contents.index') }}" class="btn btn-sm btn-outline-secondary">بازگشت به لیست</a>
                <a href="{{ route('contents.edit', $content) }}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                <form action="{{ route('contents.destroy', $content) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('آیا از حذف این محتوا اطمینان دارید؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                </form>
            </div>
        </div>

        {{-- نمایش تصویر شاخص (بهینه‌سازی شده با Aspect Ratio) --}}
        @if ($content->image_path)
            <div class="mb-4" style="width: 100%; aspect-ratio: 16 / 9; overflow: hidden; border-radius: 0.5rem; background-color: #f8f9fa;">
                <img src="{{ asset('storage/' . ltrim($content->image_path, '/')) }}" 
                     alt="{{ $content->title }}" 
                     loading="lazy"
                     onerror="this.parentElement.style.display='none'"
                     style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>
        @endif

        {{-- چکیده محتوا --}}
        @if ($content->summary)
            <div class="alert alert-light border-start border-4 border-primary p-3 mb-4 bg-light">
                <h6 class="fw-bold text-primary mb-2">چکیده مقاله:</h6>
                <p class="mb-0 text-secondary" style="line-height: 1.8;">{{ $content->summary }}</p>
            </div>
        @endif

        <hr class="my-4">

        {{-- متن اصلی --}}
        <div class="content-body mb-4" style="line-height: 2.1; font-size: 1.05rem;">
            {!! $content->body !!}
        </div>

        {{-- کلمات کلیدی --}}
        @if ($content->keywords)
            <div class="pt-3 border-top mb-3">
                <span class="text-muted small me-2">کلمات کلیدی:</span>
                @foreach (array_filter(array_map('trim', explode(',', $content->keywords))) as $keyword)
                    <span class="badge bg-light text-dark border me-1">{{ $keyword }}</span>
                @endforeach
            </div>
        @endif

        {{-- اطلاعات نویسنده و متادیتا --}}
        <div class="text-muted small border-top pt-3 mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                
                @if ($content->user)
                    <span class="ms-3">نویسنده: <strong>{{ $content->user->name }}</strong></span>
                @endif
            </div>
            <div>
                <span>تاریخ ایجاد: {{ $content->created_at ? $content->created_at->format('Y-m-d H:i') : '-' }}</span>
            </div>
        </div>

    </div>
</div>
@endsection
