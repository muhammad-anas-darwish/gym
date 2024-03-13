<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reports = Report::query();

        if ($request->query('is_read') !== null) {
            $reports = $reports->where('is_read', $request->query('is_read'));
        }

        $reports = $reports->select('title', 'is_read')
            ->with('user:id,name,email')
            ->paginate(20);

        return response()->json($reports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = 1;

        Report::create($data);

        return response()->json(['message' => 'Report added.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return response()->json($report);
    }

    /**
     * Mark The specified report as read
     */
    public function markAsRead(Report $report)
    {
        $report->update(['is_read' => true]);

        return response()->json(['message' => 'The report has been marked as read.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return response()->json(['message' => 'Records deleted.'], 204);
    }
}
