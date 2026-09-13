@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">ایجاد محتوای جدید</h1>
        <a href="{{ route('contents.index') }}" class="btn btn-outline-secondary btn-sm">بازگشت به لیست</a>
    </div>

    <form action="{{ route('contents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('contents._form')
    </form>
</div>
@endsection
