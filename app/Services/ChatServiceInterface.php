<?php 

namespace App\Services;

use Illuminate\Support\Collection;

interface ChatServiceInterface
{
    public function getUserChats(int $userId): Collection;
}