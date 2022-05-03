<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface SystemUserRepositoryContract
{
    public function findOrFail(): User;
}