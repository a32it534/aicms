<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\GapGptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $contents = Content::query()
            ->when($q !== '', fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('keywords', 'like', "%{$q}%");
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('contents.index', compact('contents', 'q'));
    }

    public function create()
    {
        return view('contents.create');
    }

    /** تولید محتوا با هوش مصنوعی (AJAX) */
    public function generate(Request $request, GapGptService $ai)
    {
        $data = $request->validate([
            'prompt' => ['required', 'string', 'min:3', 'max:1000'],
            'tone'   => ['nullable', 'string', 'max:50'],
            'words'  => ['nullable', 'integer', 'min:100', 'max:3000'],
        ]);

        try {
            $result = $ai->generateArticle(
                $data['prompt'],
                $data['tone'] ?? 'رسمی',
                (int) ($data['words'] ?? 600),
            );

            return response()->json(['ok' => true, 'data' => $result]);
        } catch (Throwable $e) {
            Log::error('GapGPT generate failed', ['error' => $e->getMessage()]);

            return response()->json([
                'ok'      => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()?->id;

        // ذخیره تصویر در صورت ارسال
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('contents', 'public');
        }

        Content::create($data);

        return redirect()->route('contents.index')
            ->with('success', 'محتوا با موفقیت ذخیره شد.');
    }

    public function show(Content $content)
    {
        return view('contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        return view('contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $data = $this->validated($request);

        // مدیریت تغییر یا آپلود تصویر جدید
        if ($request->hasFile('image')) {
            // حذف تصویر قبلی از فضای ذخیره‌سازی
            if ($content->image_path && Storage::disk('public')->exists($content->image_path)) {
                Storage::disk('public')->delete($content->image_path);
            }

            // ذخیره تصویر جدید
            $data['image_path'] = $request->file('image')->store('contents', 'public');
        }

        $content->update($data);

        return redirect()->route('contents.index')
            ->with('success', 'محتوا بروزرسانی شد.');
    }

    public function destroy(Content $content)
    {
        // حذف فایل تصویر محتوا در صورت وجود
        if ($content->image_path && Storage::disk('public')->exists($content->image_path)) {
            Storage::disk('public')->delete($content->image_path);
        }

        $content->delete();

        return redirect()->route('contents.index')
            ->with('success', 'محتوا حذف شد.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'summary'  => ['nullable', 'string', 'max:1000'],
            'body'     => ['required', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'prompt'   => ['nullable', 'string', 'max:1000'],
            'model'    => ['nullable', 'string', 'max:100'],
            'status'   => ['required', 'in:draft,published'],
            'image'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
        ]);
    }

    /**
     * صفحه اصلی عمومی برای نمایش مقالات منتشر شده به کاربران
     */
    public function publicHome(Request $request)
    {
        $query = Content::where('status', 'published');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%");
            });
        }

        $contents = $query->latest()->paginate(9)->withQueryString();

        return view('home', compact('contents'));
    }

    /**
     * صفحه مشاهده تکی مقاله عمومی
     */
    public function publicShow(Content $content)
    {
        // اگر مقاله هنوز پیش‌نویس است و کاربر لاگین نیست، خطای 404 بدهد
        if ($content->status !== 'published' && !auth()->check()) {
            abort(404);
        }

        return view('contents.public_show', compact('content'));
    }
}
