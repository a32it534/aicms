<?php

return [

    // ... سایر سرویس‌های پیش‌فرض لاراول را حفظ کنید

    'gapgpt' => [
        'key'      => env('GAPGPT_API_KEY'),
        'base_url' => env('GAPGPT_BASE_URL', 'https://api.gapgpt.app/v1'),
        'model'    => env('GAPGPT_MODEL', 'gpt-4o'),
    ],

];
