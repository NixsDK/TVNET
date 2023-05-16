<?php
use app\Controllers\ArticleController;

return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => [ArticleController::class, 'articles'],
    ],
    [
        'method' => 'GET',
        'path' => '/articles',
        'handler' => [ArticleController::class, 'articles'],
    ],
    [
        'method' => 'GET',
        'path' => '/articles/{id:\d+}',
        'handler' => [ArticleController::class, 'singleArticle'],
    ],
    [
        'method' => 'GET',
        'path' => '/users',
        'handler' => [ArticleController::class, 'users'],
    ],
    [
        'method' => 'GET',
        'path' => '/users/{id:\d+}',
        'handler' => [ArticleController::class, 'singleUser'],
    ],
];
