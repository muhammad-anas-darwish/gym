<?php

namespace App\Enums;

enum ChatType: string
{
    case MEMBERS_ONLY = 'members only';
    case ADMINS_ONLY = 'admins only';
}
