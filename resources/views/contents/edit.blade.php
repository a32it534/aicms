@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">ویرایش محتوا</h1>
        <a href="{{ route('contents.index') }}" class="btn btn-outline-secondary btn-sm">بازگشت به لیست</a>
    </div>

    <form action="{{ route('contents.update', $content) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('contents._form', ['content' => $content])
    </form>
</div>
@endsection
