<?php

namespace App\Repositories;

use App\Contracts\Repositories\SystemUserRepositoryContract;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SystemUserRepository implements SystemUserRepositoryContract
{
    public function findOrFail(): User
    {
        $user = User::firstWhere('name', 'Michigan Cannabis Club');
        
        if (empty($user)) {
            throw new ModelNotFoundException('System User not found');
        }

        return $user;
    }
}