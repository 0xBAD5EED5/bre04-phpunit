<?php

declare(strict_types=1);

class Post
{
    private string $title;
    private string $content;
    private string $slug;
    private bool $private;

    public function __construct(string $title, string $content, string $slug, bool $private = false)
    {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setSlug($slug);
        $this->setPrivate($private);
    }

    // --- Getters ---

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    // --- Setters ---

    public function setTitle(string $title): void
    {
        $this->validateTitle($title);
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->validateContent($content);
        $this->content = $content;
    }

    public function setSlug(string $slug): void
    {
        $this->validateSlug($slug);
        $this->slug = $slug;
    }

    public function setPrivate(bool $private): void
    {
        $this->private = $private;
    }

    // --- Méthodes privées de validation ---

    private function validateTitle(string $title): void
    {
        if (trim($title) === '') {
            throw new InvalidArgumentException('Title cannot be empty');
        }
    }

    private function validateContent(string $content): void
    {
        if (trim($content) === '') {
            throw new InvalidArgumentException('Content cannot be empty');
        }
    }

    private function validateSlug(string $slug): void
    {
        if (trim($slug) === '') {
            throw new InvalidArgumentException('Slug cannot be empty');
        }
        if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $slug)) {
            throw new InvalidArgumentException('Slug contains invalid characters');
        }
    }
}
