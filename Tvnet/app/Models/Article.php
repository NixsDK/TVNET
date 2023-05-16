<?php
declare(strict_types=1);

namespace App\Models;

class Article
{
    private User $author;
    private int $id;
    private string $title;
    private string $body;
    private string $imageUrl;

    public function __construct(User $author, int $id, string $title, string $body, string $imageUrl)
    {
        $this->author = $author;
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->imageUrl = $imageUrl;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function toArray(): array
    {
        return [
            'author' => $this->author->toArray(),
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'imageUrl' => $this->imageUrl,
        ];
    }

    public static function fromArray(array $data): self
    {
        $author = User::fromArray($data['author']);
        return new self($author, $data['id'], $data['title'], $data['body'], $data['imageUrl']);
    }
}
