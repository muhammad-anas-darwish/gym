<?php

namespace App\Http\Controllers;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Filters\Filter;
use App\Http\Requests\ChangeReportStatusRequest;
use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Services\Reports\ReportCreatorFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reports = Report::filter(function ($filter) use ($request) {
            $filter->where('issue_type', $request->query('issue_type'))
                ->where('status', $request->query('report_status'))
                ->where('user_id', $request->query('user_id'));
        })->paginate(20);
        
        return response()->json($reports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();

        $issueType = ReportType::from($data['issue_type']);

        $creator = ReportCreatorFactory::create($issueType);
        $creator->createReport(Auth::id(), $data['description'], $issueType);

        return $this->respondOk('Report added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        if ($report['status'] === ReportStatus::NEW) {
            $report->update(['status' => ReportStatus::VIEWED->value]);
        }

        return response()->json($report->load('user:id,name,username', 'reportable'));
    }

    public function changeStatus(ChangeReportStatusRequest $request, Report $report)
    {
        $data = $request->validated();

        $report->update($data);

        return $this->respondOk('Report status updated.');
    }
}
