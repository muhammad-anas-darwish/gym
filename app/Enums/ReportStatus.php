<?php

namespace App\Enums;

enum ReportStatus: string
{
    case NEW = 'new';
    case VIEWED = 'viewed';
    case RESOLVED = 'resolved';
    case FALSE = 'false';

}
