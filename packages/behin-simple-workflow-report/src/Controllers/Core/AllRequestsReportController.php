<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AllRequestsReportController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->except('page');
        $perPage = (int) ($filters['per_page'] ?? 15);

        return view('SimpleWorkflowReportView::Core.AllRequests.index', [
            'rows' => $this->fetchRows($filters, $perPage),
            'filters' => $filters,
            'perPage' => $perPage,
        ]);
    }

    protected function fetchRows(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $perPage = $this->resolvePerPage($perPage);
        $filters = Arr::except($filters, ['per_page']);

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

        $taskStyledNameColumn = Schema::hasColumn('wf_task', 'styled_name')
            ? 'tasks.styled_name'
            : 'tasks.name';

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
                DB::raw($taskStyledNameColumn . ' as task_styled_name')
            );

        $query = DB::table('wf_cases as cases')
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
                'last_status.task_styled_name',
                DB::raw('COALESCE(last_status.task_styled_name, last_status.task_name, last_status.inbox_status, cases.status) as last_status')
            ])
            ->orderByDesc('cases.created_at');

        $query = $this->applyFilters($query, $filters);

        $appendFilters = array_filter($filters, function ($value) {
            return $value !== null && $value !== '';
        });

        $appendFilters['per_page'] = $perPage;

        $paginator = $query->paginate($perPage)->appends($appendFilters);

        $paginator->setCollection(
            $paginator->getCollection()->map(function ($row) {
                $lastStatus = trim(strip_tags($row->last_status ?? ''));

                if ($lastStatus === '') {
                    $lastStatus = $row->inbox_status ?? $row->case_status ?? null;
                }

                $row->last_status = $lastStatus;

                return $row;
            })
        );

        return $paginator;
    }

    protected function resolvePerPage(int $perPage): int
    {
        $allowed = [10, 15, 25, 50, 100];

        if (!in_array($perPage, $allowed, true)) {
            $perPage = 15;
        }

        return $perPage;
    }

    protected function applyFilters($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if ($value === null || $value === '') {
                unset($filters[$key]);
            }
        }

        if (!empty($filters['case_number'])) {
            $query->where('cases.number', 'like', '%' . $filters['case_number'] . '%');
        }

        if (!empty($filters['user_firstname'])) {
            $query->where('vars.user_firstname', 'like', '%' . $filters['user_firstname'] . '%');
        }

        if (!empty($filters['user_lastname'])) {
            $query->where('vars.user_lastname', 'like', '%' . $filters['user_lastname'] . '%');
        }

        if (!empty($filters['electricity_bill_id'])) {
            $query->where('vars.electricity_bill_id', 'like', '%' . $filters['electricity_bill_id'] . '%');
        }

        if (!empty($filters['powerhouse_type'])) {
            $query->where('vars.powerhouse_type', 'like', '%' . $filters['powerhouse_type'] . '%');
        }

        if (!empty($filters['powerhouse_province'])) {
            $query->where(function ($subQuery) use ($filters) {
                $subQuery
                    ->where('vars.powerhouse_place_info_province', 'like', '%' . $filters['powerhouse_province'] . '%')
                    ->orWhere('place.province', 'like', '%' . $filters['powerhouse_province'] . '%');
            });
        }

        if (!empty($filters['requested_capacity_of_powerhouse'])) {
            $query->where('vars.requested_capacity_of_powerhouse', 'like', '%' . $filters['requested_capacity_of_powerhouse'] . '%');
        }

        if (!empty($filters['first_call_result'])) {
            $query->where('vars.first_call_result', 'like', '%' . $filters['first_call_result'] . '%');
        }

        if (!empty($filters['loan_interest'])) {
            $query->where('vars.loan_interest', 'like', '%' . $filters['loan_interest'] . '%');
        }

        if (!empty($filters['initial_amount'])) {
            $query->where('vars.initial_amount', 'like', '%' . $filters['initial_amount'] . '%');
        }

        if (!empty($filters['feasibility_study'])) {
            $query->where('vars.feasibility_study', 'like', '%' . $filters['feasibility_study'] . '%');
        }

        if (!empty($filters['last_status'])) {
            $query->where(function ($subQuery) use ($filters) {
                $subQuery
                    ->where('last_status.task_styled_name', 'like', '%' . $filters['last_status'] . '%')
                    ->orWhere('last_status.task_name', 'like', '%' . $filters['last_status'] . '%')
                    ->orWhere('last_status.inbox_status', 'like', '%' . $filters['last_status'] . '%')
                    ->orWhere('cases.status', 'like', '%' . $filters['last_status'] . '%');
            });
        }

        return $query;
    }
}
