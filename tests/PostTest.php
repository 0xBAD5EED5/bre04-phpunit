<?php

declare(strict_types=1);

class Post {
    private string $title;
    private string $content;
    private string $slug;
    private bool $private;
    
    public function __construct(
        string $title, 
        string $content, 
        string $slug, 
        bool $private = false) {
            
        $this->ensureIsValidTitle($title);
        $this->ensureIsValidSlug($slug);
        $this->ensureIsValidContent($content);
            
        $this->title = $title;
        $this->content = $content;
        $this->slug = $slug;
        $this->private = $private;
    }
    
    
    public function getTitle(): string {
        return $this->title;
    }
    
    public function setTitle(string $title): void {
        $this->ensureIsValidTitle($title);
        $this->title = $title;
    }
    
    public function getContent(): string {
        return $this->content;
    }
    
    public function setContent(string $content): void {
        $this->ensureIsValidContent($content);
        $this->content = $content;
    }
    
    public function getSlug(): string {
        return $this->slug;
    }
    
    public function setSlug(string $slug): void {
        $this->ensureIsValidSlug($slug);
        $this->slug = $slug;
    }
    
    public function isPrivate(): bool {
        return $this->private;
    }
    
    public function setPrivate(bool $private): void {
        $this->private = $private;
    }
    
    private function ensureIsValidTitle(string $title): void {
        if (empty($title)) {
            throw new InvalidArgumentException('Title cannot be empty');
        }
    }
    
    private function ensureIsValidSlug(string $slug): void {
        if (empty($slug)) {
            throw new InvalidArgumentException('Slug cannot be empty');
        } else if (!preg_match('/^[a-zA-Z0-9-]+$/', $slug)) {
            throw new InvalidArgumentException('Slug must be URL safe');
        }
    }
    
    private function ensureIsValidContent(string $content): void {
        if (empty($content)) {
            throw new InvalidArgumentException('Content cannot be empty');
        }
    }
}