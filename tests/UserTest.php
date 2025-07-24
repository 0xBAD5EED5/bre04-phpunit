<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUserCreation()
    {
        $user = new User('Alice', 'Martin', 'alice@example.com', 'Strong1!');
        $this->assertSame('Alice', $user->getFirstName());
        $this->assertSame('Martin', $user->getLastName());
        $this->assertSame('alice@example.com', $user->getEmail());
        $this->assertSame('Strong1!', $user->getPassword());
        $this->assertSame(['ANONYMOUS'], $user->getRoles()); // Valeur par défaut
    }

    public function testSetters()
    {
        $user = new User('a', 'b', 'a@b.fr', 'A1!azerty');
        $user->setFirstName('Bob');
        $user->setLastName('Smith');
        $user->setEmail('bob@smith.com');
        $user->setPassword('Password1!');
        $user->setRoles(['USER']);

        $this->assertSame('Bob', $user->getFirstName());
        $this->assertSame('Smith', $user->getLastName());
        $this->assertSame('bob@smith.com', $user->getEmail());
        $this->assertSame('Password1!', $user->getPassword());
        $this->assertSame(['USER'], $user->getRoles());
    }

    public function testFirstNameCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('', 'Martin', 'alice@example.com', 'Strong1!');
    }

    public function testLastNameCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('Alice', '', 'alice@example.com', 'Strong1!');
    }

    public function testEmailMustBeValid()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('Alice', 'Martin', 'not-an-email', 'Strong1!');
    }

    public function testPasswordMustBeStrong()
    {
        $this->expectException(InvalidArgumentException::class);
        // Trop court, pas de majuscule, pas de caractère spécial
        new User('Alice', 'Martin', 'alice@example.com', 'azertyu');
    }

    public function testRolesCannotMixAnonymousWithUserOrAdmin()
    {
        $this->expectException(InvalidArgumentException::class);
        new User('Alice', 'Martin', 'alice@example.com', 'Strong1!', ['ANONYMOUS', 'USER']);
    }
}
