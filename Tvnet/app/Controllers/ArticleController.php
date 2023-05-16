<?php
declare(strict_types=1);

namespace app\Controllers;

use app\ApiClient;
use app\Core\View;

class ArticleController
{
    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function articles(): View
    {
        $articles = $this->client->getArticles();
        return new View('articles', ['articles' => $articles]);
    }

    public function users(): View
    {
        $users = $this->client->getUsers();
        return new View('users', ['users' => $users]);
    }

    public function singleArticle(array $vars): View
    {
        $articleId = (int)implode('', $vars);
        $article = $this->client->getSingleArticle($articleId);

        if (!$article) {
            return $this->notFoundView();
        }

        $comments = $this->client->getCommentsById($article->getId());
        return new View('singleArticle', ['article' => $article, 'comments' => $comments]);
    }

    public function singleUser(array $vars): View
    {
        $userId = (int)implode('', $vars);
        $user = $this->client->getSingleUser($userId);

        if (!$user) {
            return $this->notFoundView();
        }

        $articles = $this->client->getArticlesByUser($user->getId());
        return new View('singleUser', ['user' => $user, 'articles' => $articles]);
    }

    private function notFoundView(): View
    {
        return new View('notFound', []);
    }
}
