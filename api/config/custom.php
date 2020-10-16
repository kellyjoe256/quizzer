<?php

return [
    'per_page' => env('PER_PAGE', 10),

    'access_cookie_name' => env('ACCESS_COOKIE_NAME', 'access_token'),

    // in minutes
    'access_cookie_duration' => env('ACCESS_COOKIE_DURATION', 60),
];
