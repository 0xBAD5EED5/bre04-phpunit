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
        $this->assertSame(['ANONYMOUS'], $user->getRoles());
    }

    public function testUserCanBeAdmin()
    {
        $user = new User('Alice', 'Martin', 'alice@example.com', 'Strong1!', ['ADMIN']);
        $this->assertSame(['ADMIN'], $user->getRoles());
        // Changement du rôle
        $user->addRole('USER');
        $this->assertSame(['ADMIN', 'USER'], $user->getRoles());
        // Retrait de tous les rôles spéciaux
        $user->removeRole('ADMIN');
        $user->removeRole('USER');
        $this->assertSame(['ANONYMOUS'], $user->getRoles());
    }

    public function testFirstNameCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('First name cannot be empty');
        new User('', 'Martin', 'alice@example.com', 'Strong1!');
    }

    public function testLastNameCannotBeEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Last name cannot be empty');
        new User('Alice', '', 'alice@example.com', 'Strong1!');
    }

    public function testEmailMustBeValid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address');
        new User('Alice', 'Martin', 'not-an-email', 'Strong1!');
    }

    public function testPasswordTooShort()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be at least 8 characters');
        new User('Alice', 'Martin', 'alice@example.com', 'Az1!');
    }

    public function testPasswordNoUppercase()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must contain at least one uppercase letter');
        new User('Alice', 'Martin', 'alice@example.com', 'password1!');
    }

    public function testPasswordNoDigit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must contain at least one digit');
        new User('Alice', 'Martin', 'alice@example.com', 'Password!');
    }

    public function testPasswordNoSpecialChar()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must contain at least one special character');
        new User('Alice', 'Martin', 'alice@example.com', 'Password1');
    }

    public function testRolesCannotMixAnonymousWithUserOrAdmin()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot have ANONYMOUS with USER or ADMIN roles');
        new User('Alice', 'Martin', 'alice@example.com', 'Strong1!', ['ANONYMOUS', 'USER']);
    }

    public function testAddInvalidRole()
    {
        $user = new User('Alice', 'Martin', 'alice@example.com', 'Strong1!');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid role name: SUPERUSER');
        $user->addRole('SUPERUSER');
    }
}
