<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testValidPrivatePost() {
        $post = new Post('Title', "Content", 'slug', true);
        
        $this->assertSame('Title', $post->getTitle());
        $this->assertSame('Content', $post->getContent());
        $this->assertSame('slug', $post->getSlug());
        $this->assertTrue($post->isPrivate());
    }
    
    public function testValidPublicPost() {
        $post = new Post('Title', "Content", 'slug');
        
        $this->assertSame('Title', $post->getTitle());
        $this->assertSame('Content', $post->getContent());
        $this->assertSame('slug', $post->getSlug());
        $this->assertFalse($post->isPrivate());
    }
    
    public function testEmptyTitle() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Title cannot be empty');
        
        new Post('', 'Content', 'slug');
    }
    
    public function testEmptyContent() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Content cannot be empty');
        
        new Post('Title', '', 'slug');
    }
    
    public function testEmptySlug() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Slug cannot be empty');
        
        new Post('Title', 'Content', '');
    }
    
    public function testInvalidSlug() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Slug must be URL safe');
        
        new Post('Title', 'Content', 'invalid slug');
    }
}