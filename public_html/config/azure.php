<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

// Access environment through the config helper
// This will avoid issues when using Laravel's config caching
// https://laravel.com/docs/8.x/configuration#configuration-caching
return [
    'appId' => env('OAUTH_APP_ID', '8af3923f-2e65-4b7c-bc0b-8b52b19de073'),
    'appSecret' => env('OAUTH_APP_SECRET', 'ZdO8Q~~N6drWEx6FqR_MRRwD2QhwIXvsvN2Wwbs-'),
    'redirectUri' => env('OAUTH_REDIRECT_URI', 'https://dtdp.local/admin/index/onedrive'),
    'scopes' => env('OAUTH_SCOPES', 'files.read files.read.all files.readwrite files.readwrite.all offline_access'),
    'authority' => env('OAUTH_AUTHORITY', 'https://login.microsoftonline.com/common'),
    'authorizeEndpoint' => env('OAUTH_AUTHORIZE_ENDPOINT', '/oauth2/v2.0/authorize'),
    'tokenEndpoint' => env('OAUTH_TOKEN_ENDPOINT', '/oauth2/v2.0/token'),
];
