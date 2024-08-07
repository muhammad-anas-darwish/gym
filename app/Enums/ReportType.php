<?php

namespace App\Enums;

enum ReportType: string
{
    case TRAINEE_WITHOUT_COACH = 'trainee_without_coach';
    case NEED_COACHES = 'need_coaches';
    case OFFENSIVE_MESSAGES = 'offensive_messages';
    case REQUEST_COACH_CHANGE = 'request_coach_change';
    case TECHNICAL_ISSUE = 'technical_issue';
    case OTHER = 'other';
}

