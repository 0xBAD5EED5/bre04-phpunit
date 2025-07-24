<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PostTest extends TestCase
{
    public function testPostCreation()
    {
        // Création d'un post valide
        $post = new Post('Titre', 'Contenu', 'mon-slug');

        // On vérifie que les valeurs sont bien enregistrées
        $this->assertSame('Titre', $post->getTitle());
        $this->assertSame('Contenu', $post->getContent());
        $this->assertSame('mon-slug', $post->getSlug());
        $this->assertFalse($post->isPrivate()); // Valeur par défaut
    }

    public function testSetters()
    {
        $post = new Post('a', 'b', 'c');
        $post->setTitle('Nouveau titre');
        $post->setContent('Nouveau contenu');
        $post->setSlug('nouveau-slug');
        $post->setPrivate(true);

        $this->assertSame('Nouveau titre', $post->getTitle());
        $this->assertSame('Nouveau contenu', $post->getContent());
        $this->assertSame('nouveau-slug', $post->getSlug());
        $this->assertTrue($post->isPrivate());
    }

    public function testTitleCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('', 'Contenu', 'slug');
    }

    public function testContentCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('Titre', '', 'slug');
    }

    public function testSlugCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('Titre', 'Contenu', '');
    }

    public function testSlugMustBeUrlSafe()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('Titre', 'Contenu', 'slug pas ok !');
    }
}
