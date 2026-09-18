<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Monitor API token
    |--------------------------------------------------------------------------
    |
    | Shared secret the status console presents on every request to
    | /api/monitor/*, either as `Authorization: Bearer <token>` or as the
    | `X-Monitor-Token` header. Compared in constant time.
    |
    | Left unset, the monitor routes refuse every request rather than silently
    | accepting anything — an unconfigured token must never mean "no auth
    | required", which is what this install did before.
    |
    | /api/health is deliberately NOT behind this. It reports liveness only,
    | and the console must still be able to tell whether the application is up
    | when the token is missing or wrong.
    |
    */
    'token' => env('MONITOR_API_TOKEN'),

];
