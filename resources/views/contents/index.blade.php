@extends('layouts.app')
@section('title', 'لیست محتواها')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">لیست محتواها</h1>
    <a href="{{ route('contents.create') }}" class="btn btn-primary">+ تولید محتوای جدید</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form class="row g-2" method="GET">
            <div class="col-12 col-md-9">
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="جستجو در عنوان یا کلمات کلیدی...">
            </div>
            <div class="col-12 col-md-3 d-grid">
                <button class="btn btn-outline-secondary">جستجو</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>تصویر</th>
                    <th>عنوان</th>
                    <th class="d-none d-md-table-cell">کلمات کلیدی</th>
                    <th>وضعیت</th>
                    <th class="d-none d-lg-table-cell">تاریخ</th>
                    <th class="text-start">عملیات</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($contents as $content)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if(!empty($content->image_path))
                            <img src="{{ asset('storage/' . ltrim($content->image_path, '/')) }}" 
                                 alt="{{ $content->title }}" 
                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                 class="rounded border shadow-sm"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'bg-light rounded border d-flex align-items-center justify-content-center\' style=\'width:50px;height:50px;font-size:20px;\'>🖼️</div>';">
                        @else
                            <div class="bg-light rounded border d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <span class="text-muted" style="font-size: 20px;">🖼️</span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('contents.show', $content) }}" class="text-decoration-none fw-semibold">
                            {{ $content->title }}
                        </a>
                        <div class="small text-muted d-md-none">{{ $content->keywords }}</div>
                    </td>
                    <td class="d-none d-md-table-cell small text-muted">{{ $content->keywords }}</td>
                    <td>
                        <span class="badge bg-{{ $content->status === 'published' ? 'success' : 'secondary' }}">
                            {{ $content->status === 'published' ? 'منتشر شده' : 'پیش‌نویس' }}
                        </span>
                    </td>
                    <td class="d-none d-lg-table-cell small text-muted">{{ $content->created_at ? $content->created_at->format('Y/m/d H:i') : '—' }}</td>
                    <td class="text-start text-nowrap">
                        <a href="{{ route('contents.edit', $content) }}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                        <form action="{{ route('contents.destroy', $content) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('این محتوا حذف شود؟');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">هنوز محتوایی ثبت نشده است.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $contents->links() }}</div>
@endsection
