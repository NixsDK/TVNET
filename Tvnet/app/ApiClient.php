<?php


namespace app;

use app\Models\Article;
use app\Models\Comment;
use app\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class ApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getArticles(): array
    {
        try {
            $responseContent = $this->getResponseContent('articles');
            if ($responseContent === null) {
                return [];
            }

            $articleCollection = [];
            foreach ($responseContent as $article) {
                $articleCollection[] = $this->createArticle($article);
            }
            return $articleCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getUsers(): array
    {
        try {
            $responseContent = $this->getResponseContent('users');
            if ($responseContent === null) {
                return [];
            }

            $userCollection = [];
            foreach ($responseContent as $user) {
                $userCollection[] = $this->createUser($user);
            }
            return $userCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getArticlesByUser(int $id): array
    {
        try {
            $responseContent = $this->getResponseContent('articles_user_' . $id);
            if ($responseContent === null) {
                return [];
            }

            $articleCollection = [];
            foreach ($responseContent as $article) {
                $articleCollection[] = $this->createArticle($article);
            }
            return $articleCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getCommentsById(int $id): array
    {
        try {
            $responseContent = $this->getResponseContent('comments_' . $id);
            if ($responseContent === null) {
                return [];
            }

            $commentCollection = [];
            foreach ($responseContent as $comment) {
                $commentCollection[] = $this->createComment($comment);
            }
            return $commentCollection;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getSingleUser(int $id): ?User
    {
        try {
            $responseContent = $this->getResponseContent('user_' . $id);
            if ($responseContent === null) {
                return null;
            }
            return $this->createUser($responseContent);
        } catch (GuzzleException $e) {
            return null;
        }
    }

    public function getSingleArticle(int $id): ?Article
    {
        try {
            $responseContent = $this->getResponseContent('article_' . $id);
            if ($responseContent === null) {
                return null;
            }
            return $this->createArticle($responseContent);
        } catch (GuzzleException $e) {
            return null;
        }
    }

    private function getResponseContent(string $cacheKey): ?array
    {
        try {
            if (!Cache::has($cacheKey)) {
                $response = $this->client->get('https://jsonplaceholder.typicode.com/' . $cacheKey);
                $responseContent = json_decode($response->getBody()->getContents(), true);
                Cache::save($cacheKey, $responseContent);
            } else {
                $responseContent = Cache::get($cacheKey);
            }
            return $responseContent;
        } catch (GuzzleException $e) {
            return null;

        }
    }
    private function createArticle(array $article): Article
    {
        return new Article(
            $this->getSingleUser($article['userId']),
            $article['id'],
            $article['title'],
            $article['body'],
            'https://placehold.co/600x400/gray/white?text=Some+News'
        );
    }

    private function createUser(array $user): User
    {
        return new User(
            $user['id'],
            $user['name'],
            $user['username'],
            $user['email'],
            $user['phone'],
            $user['website']
        );
    }

    private function createComment(array $comment): Comment
    {
        return new Comment(
            $comment['postId'],
            $comment['id'],
            $comment['name'],
            $comment['email'],
            $comment['body']
        );
    }
}