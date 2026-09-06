<?php

require_once 'User.php';

class UserRepo
{

public function findById(int $id): ?User 
    {

        return null; 
    }

    public function findByEmail(string $email): ?User 
    {
        return null;
    }

    public function save(User $user): void 
    {
    }
}