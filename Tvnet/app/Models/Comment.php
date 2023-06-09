<?php


namespace App\Models;

class Comment
{
    private int $postId;
    private int $id;
    private string $name;
    private string $email;
    private string $body;

    public function __construct(int $postId, int $id, string $name, string $email, string $body)
    {
        $this->postId = $postId;
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function toArray(): array
    {
        return [
            'postId' => $this->postId,
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'body' => $this->body,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['postId'],
            $data['id'],
            $data['name'],
            $data['email'],
            $data['body']
        );
    }
}
