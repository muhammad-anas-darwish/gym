<?php 

namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Collection;

interface ChatServiceInterface
{
    public function getUserChats(int $userId): Collection;

    public function destroyChat(Chat $chat): void;
}