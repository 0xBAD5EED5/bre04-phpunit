<?php

declare(strict_types=1);

class User
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        array $roles = ['ANONYMOUS']
    ) {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRoles($roles);
    }

    // --- Getters ---
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRoles(): array
    {
        return $this->roles;
    }

    // --- Setters avec validation ---
    public function setFirstName(string $firstName): void
    {
        $this->validateFirstName($firstName);
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->validateLastName($lastName);
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        $this->validateEmail($email);
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->validatePassword($password);
        $this->password = $password;
    }

    public function setRoles(array $roles): void
    {
        $this->validateRoles($roles);
        $this->roles = $roles;
    }

    // --- Méthodes publiques add/remove ---

    public function addRole(string $newRole): array
    {
        $this->validateRoleName($newRole);

        if (!in_array($newRole, $this->roles, true)) {
            $this->roles[] = $newRole;
        }

        // Si on ajoute USER ou ADMIN, on retire ANONYMOUS
        if (in_array('USER', $this->roles, true) || in_array('ADMIN', $this->roles, true)) {
            $this->roles = array_diff($this->roles, ['ANONYMOUS']);
        }

        // Toujours garder les rôles uniques
        $this->roles = array_values(array_unique($this->roles));

        return $this->roles;
    }

    public function removeRole(string $role): array
    {
        $this->validateRoleName($role);

        if (in_array($role, $this->roles, true)) {
            $this->roles = array_diff($this->roles, [$role]);
        }

        // Si plus de rôle USER ou ADMIN => ANONYMOUS obligatoire
        if (
            !in_array('USER', $this->roles, true) &&
            !in_array('ADMIN', $this->roles, true)
        ) {
            if (!in_array('ANONYMOUS', $this->roles, true)) {
                $this->roles[] = 'ANONYMOUS';
            }
        }

        // Toujours garder les rôles uniques
        $this->roles = array_values(array_unique($this->roles));

        return $this->roles;
    }

    // --- 6 validateurs privés ---

    private function validateFirstName(string $firstName): void
    {
        if (trim($firstName) === '') {
            throw new InvalidArgumentException('First name cannot be empty');
        }
    }

    private function validateLastName(string $lastName): void
    {
        if (trim($lastName) === '') {
            throw new InvalidArgumentException('Last name cannot be empty');
        }
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }
    }

    private function validatePassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters');
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one uppercase letter');
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one digit');
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one special character');
        }
    }

    private function validateRoles(array $roles): void
    {
        $possibleRoles = ['ANONYMOUS', 'USER', 'ADMIN'];
        foreach ($roles as $role) {
            $this->validateRoleName($role);
        }

        // Règle : ANONYMOUS interdit avec USER ou ADMIN
        if (
            (in_array('USER', $roles, true) || in_array('ADMIN', $roles, true)) &&
            in_array('ANONYMOUS', $roles, true)
        ) {
            throw new InvalidArgumentException('Cannot have ANONYMOUS with USER or ADMIN roles');
        }
        // Règle : Au moins ANONYMOUS si rien d'autre
        if (
            !in_array('ANONYMOUS', $roles, true) &&
            !in_array('USER', $roles, true) &&
            !in_array('ADMIN', $roles, true)
        ) {
            throw new InvalidArgumentException('At least ANONYMOUS, USER, or ADMIN role is required');
        }
    }

    private function validateRoleName(string $role): void
    {
        $possibleRoles = ['ANONYMOUS', 'USER', 'ADMIN'];
        if (!in_array($role, $possibleRoles, true)) {
            throw new InvalidArgumentException('Invalid role name: ' . $role);
        }
    }
}