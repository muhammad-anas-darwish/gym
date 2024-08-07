<?php

namespace App\Services\Reports;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Report;

abstract class ReportCreator {
    public function createReport($user_id, $description, ReportType $issueType) {
        $report = new Report();
        $report->user_id = $user_id;
        $report->description = $description;
        $report->issue_type = $issueType->value;
        
        $this->associateReportable($report);

        $report->save();

        return $report;
    }

    abstract protected function associateReportable(Report $report);
}