<?php

namespace App\Services\Reports;

use App\Enums\ReportType;

class ReportCreatorFactory {
    public static function create(ReportType $issueType): ReportCreator {
        return match ($issueType) {
            default => new GeneralReportCreator(),
        };
    }
}