<?php

namespace App\Enums;

enum UserChatRole: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case OWNER = 'owner';
}
