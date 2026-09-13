@php($content = $content ?? null)

<div class="row g-3">
    <div class="col-12 col-lg-4">
        {{-- بخش تولید محتوا با هوش مصنوعی --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h2 class="h6 mb-3">🤖 تولید با هوش مصنوعی</h2>

                <div class="mb-2">
                    <label class="form-label">موضوع / دستور</label>
                    <textarea id="ai-prompt" class="form-control" rows="4"
                              placeholder="مثلاً: مقاله‌ای درباره مزایای انرژی خورشیدی در ایران">{{ old('prompt', $content->prompt ?? '') }}</textarea>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label">لحن</label>
                        <select id="ai-tone" class="form-select">
                            <option>رسمی</option>
                            <option>صمیمی</option>
                            <option>خبری</option>
                            <option>تبلیغاتی</option>
                            <option>آموزشی</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">تعداد کلمات</label>
                        <input id="ai-words" type="number" class="form-control" value="600" min="100" max="3000">
                    </div>
                </div>

                <button type="button" id="ai-generate" class="btn btn-success w-100 mt-3">
                    <span class="spinner-border spinner-border-sm d-none" id="ai-spinner"></span>
                    تولید محتوا
                </button>

                <div id="ai-error" class="alert alert-danger mt-3 d-none"></div>
            </div>
        </div>

        {{-- بخش مدیریت تصویر شاخص --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h6 mb-3">🖼️ تصویر شاخص</h2>

                <div class="mb-3">
                    <label class="form-label">انتخاب تصویر</label>
                    <input type="file" name="image" id="field-image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/gif">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-1">فرمت‌های مجاز: JPG, PNG, WEBP, GIF (حداکثر ۲ مگابایت)</small>
                </div>

                {{-- کانتینر پیش‌نمایش --}}
                <div id="image-preview-container" class="{{ ($content && $content->image_path) ? '' : 'd-none' }}">
                    <label class="form-label">پیش‌نمایش تصویر:</label>
                    <div class="border rounded p-1 text-center bg-light">
                        {{-- تصویر اولیه از دیتابیس لود می‌شود --}}
                        <img id="image-preview" 
                             src="{{ ($content && $content->image_path) ? asset('storage/' . ltrim($content->image_path, '/')) : '#' }}" 
                             alt="پیش‌نمایش" 
                             class="img-fluid rounded" 
                             style="max-height: 180px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- بخش فرم اصلی --}}
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <input type="hidden" name="prompt" id="field-prompt" value="{{ old('prompt', $content->prompt ?? '') }}">
                <input type="hidden" name="model" id="field-model" value="{{ old('model', $content->model ?? '') }}">

                <div class="mb-3">
                    <label class="form-label">عنوان <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="field-title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $content->title ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">خلاصه</label>
                    <textarea name="summary" id="field-summary" class="form-control" rows="2">{{ old('summary', $content->summary ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">متن محتوا <span class="text-danger">*</span></label>
                    <textarea name="body" id="field-body" class="form-control @error('body') is-invalid @enderror" rows="14" required>{{ old('body', $content->body ?? '') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-8">
                        <label class="form-label">کلمات کلیدی</label>
                        <input type="text" name="keywords" id="field-keywords" class="form-control" value="{{ old('keywords', $content->keywords ?? '') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label">وضعیت</label>
                        <select name="status" class="form-select">
                            <option value="draft" @selected(old('status', $content->status ?? 'draft') === 'draft')>پیش‌نویس</option>
                            <option value="published" @selected(old('status', $content->status ?? '') === 'published')>منتشر شده</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">ذخیره</button>
                    <a href="{{ route('contents.index') }}" class="btn btn-light">انصراف</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    // پیش‌نمایش تصویر (در صورت انتخاب فایل جدید)
    $('#field-image').on('change', function (e) {
        const file = e.target.files && e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                // آپدیت کردن سورس تصویر موجود به فایل جدید انتخاب شده
                $('#image-preview').attr('src', event.target.result);
                // نمایش کانتینر در صورتی که مخفی بوده
                $('#image-preview-container').removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // تولید محتوا با هوش مصنوعی
    $('#ai-generate').on('click', function () {
        const prompt = $('#ai-prompt').val().trim();
        const $btn = $(this), $spinner = $('#ai-spinner'), $err = $('#ai-error');

        $err.addClass('d-none').text('');
        if (prompt.length < 3) return $err.removeClass('d-none').text('لطفاً موضوع محتوا را وارد کنید.');

        $btn.prop('disabled', true);
        $spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('contents.generate') }}",
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', prompt, tone: $('#ai-tone').val(), words: $('#ai-words').val() }
        }).done(function (res) {
            const d = res.data || {};
            $('#field-title').val(d.title || '');
            $('#field-summary').val(d.summary || '');
            $('#field-body').val(d.body || '');
            $('#field-keywords').val(d.keywords || '');
            $('#field-model').val(d.model || '');
            $('#field-prompt').val(prompt);
        }).fail(function (xhr) {
            const msg = (xhr.responseJSON?.message) || 'خطا در ارتباط با سرویس هوش مصنوعی.';
            $err.removeClass('d-none').text(msg);
        }).always(function () {
            $btn.prop('disabled', false);
            $spinner.addClass('d-none');
        });
    });
});
</script>
@endpush
