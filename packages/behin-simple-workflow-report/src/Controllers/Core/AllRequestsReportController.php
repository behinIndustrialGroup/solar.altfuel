<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AllRequestsReportController extends Controller
{
    public function index(): View
    {
        return view('SimpleWorkflowReportView::Core.AllRequests.index', [
            'rows' => $this->fetchRows(),
        ]);
    }

    protected function fetchRows(): Collection
    {
        $caseVariables = DB::table('wf_variables')
            ->select(
                'case_id',
                DB::raw("MAX(CASE WHEN `key` IN ('user-firstname', 'user_firstname') THEN value END) as user_firstname"),
                DB::raw("MAX(CASE WHEN `key` IN ('user-lastname', 'user_lastname') THEN value END) as user_lastname"),
                DB::raw("MAX(CASE WHEN `key` IN (
                    'electricity_bill_id',
                    'bill_id',
                    'request-bill_id',
                    'powerhouse_place_info-bill_id',
                    'powerhouse_place_info-electricity_bill_id',
                    'electricity_bill_identifier',
                    'subscription_code',
                    'subscription_id',
                    'subscriber_id'
                ) THEN value END) as electricity_bill_id"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_type', 'powerhouse-type') THEN value END) as powerhouse_type"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_place_info-id', 'powerhouse_place_info_id') THEN value END) as powerhouse_place_info_id"),
                DB::raw("MAX(CASE WHEN `key` = 'powerhouse_place_info-province' THEN value END) as powerhouse_place_info_province"),
                DB::raw("MAX(CASE WHEN `key` IN ('requested_capacity_of_powerhouse', 'requested-capacity-of-powerhouse') THEN value END) as requested_capacity_of_powerhouse"),
                DB::raw("MAX(CASE WHEN `key` IN ('first_call_result', 'first-call-result') THEN value END) as first_call_result"),
                DB::raw("MAX(CASE WHEN `key` IN ('loan_interest', 'loan-interest') THEN value END) as loan_interest"),
                DB::raw("MAX(CASE WHEN `key` IN ('initial_amount', 'initial-amount') THEN value END) as initial_amount"),
                DB::raw("MAX(CASE WHEN `key` IN ('feasibility_study', 'feasibility-study') THEN value END) as feasibility_study")
            )
            ->groupBy('case_id');

        $latestInbox = DB::table('wf_inbox')
            ->select('case_id', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('case_id');

        $lastStatuses = DB::table('wf_inbox as inbox')
            ->joinSub($latestInbox, 'latest', function ($join) {
                $join->on('inbox.case_id', '=', 'latest.case_id')
                    ->on('inbox.created_at', '=', 'latest.latest_created_at');
            })
            ->leftJoin('wf_task as tasks', 'tasks.id', '=', 'inbox.task_id')
            ->select(
                'inbox.case_id',
                'inbox.status as inbox_status',
                'tasks.name as task_name',
                'tasks.styled_name as task_styled_name'
            );

        return DB::table('wf_cases as cases')
            ->leftJoinSub($caseVariables, 'vars', function ($join) {
                $join->on('cases.id', '=', 'vars.case_id');
            })
            ->leftJoin('wf_entity_powerhouse_place_info as place', 'place.id', '=', 'vars.powerhouse_place_info_id')
            ->leftJoinSub($lastStatuses, 'last_status', function ($join) {
                $join->on('cases.id', '=', 'last_status.case_id');
            })
            ->select([
                'cases.number as case_number',
                'vars.user_firstname',
                'vars.user_lastname',
                'vars.electricity_bill_id',
                DB::raw('COALESCE(vars.powerhouse_place_info_province, place.province) as powerhouse_province'),
                'vars.powerhouse_type',
                'vars.requested_capacity_of_powerhouse',
                'vars.first_call_result',
                'vars.loan_interest',
                'vars.initial_amount',
                'vars.feasibility_study',
                'cases.status as case_status',
                'last_status.inbox_status',
                'last_status.task_name',
                'last_status.task_styled_name'
            ])
            ->orderByDesc('cases.created_at')
            ->get()
            ->map(function ($row) {
                $lastStatus = trim(strip_tags($row->task_styled_name ?? $row->task_name ?? ''));

                if ($lastStatus === '') {
                    $lastStatus = $row->inbox_status ?? $row->case_status;
                }

                return [
                    'case_number' => $row->case_number,
                    'user_firstname' => $row->user_firstname,
                    'user_lastname' => $row->user_lastname,
                    'electricity_bill_id' => $row->electricity_bill_id,
                    'powerhouse_type' => $row->powerhouse_type,
                    'powerhouse_province' => $row->powerhouse_province,
                    'requested_capacity_of_powerhouse' => $row->requested_capacity_of_powerhouse,
                    'first_call_result' => $row->first_call_result,
                    'loan_interest' => $row->loan_interest,
                    'initial_amount' => $row->initial_amount,
                    'feasibility_study' => $row->feasibility_study,
                    'last_status' => $lastStatus,
                ];
            });
    }
}
