<?php

return [
    'ssr' => [
        'enabled' => false,
        'url' => 'http://127.0.0.1:13714',
    ],
    'testing' => [
        'view_finder' => [resource_path('js/pages')],
        'page_extension' => 'vue',
        'ensure_pages_exist' => false,
    ],
];