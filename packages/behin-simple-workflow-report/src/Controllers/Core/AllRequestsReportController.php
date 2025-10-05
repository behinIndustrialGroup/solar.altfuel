<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\Ami\Services\CallHistoryService;
use Behin\SimpleWorkflow\Models\Core\Cases;
use Behin\SimpleWorkflow\Models\Core\Inbox;
use Behin\SimpleWorkflowReport\Exports\AllRequestsReportExport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Behin\SimpleWorkflow\Models\Core\ViewModel;

class AllRequestsReportController extends Controller
{
    protected array $openStatuses = ['new', 'opened', 'inProgress', 'draft'];

    public function index(Request $request)
    {
        $filters = $request->except('page');
        $perPage = (int) ($filters['per_page'] ?? 15);
        $query = DB::table('wf_cases as c')
            ->leftJoin('wf_variables as v', 'c.id', '=', 'v.case_id')
            ->select(
                'c.id',
                'c.number',
                DB::raw("MAX(CASE WHEN v.key IN ('user-firstname', 'user_firstname') THEN v.value END) as user_firstname"),
                DB::raw("MAX(CASE WHEN v.key = 'user-lastname' THEN v.value END) as user_lastname"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_type', 'powerhouse-type') THEN value END) as powerhouse_type"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_place_info-id', 'powerhouse_place_info_id') THEN value END) as powerhouse_place_info_id"),
                DB::raw("MAX(CASE WHEN `key` = 'powerhouse_place_info-province' THEN value END) as powerhouse_place_info_province"),
                DB::raw("MAX(CASE WHEN `key` IN ('requested_capacity_of_powerhouse', 'requested-capacity-of-powerhouse') THEN value END) as requested_capacity_of_powerhouse"),
                DB::raw("MAX(CASE WHEN `key` IN ('first_call_result', 'first-call-result') THEN value END) as first_call_result"),
                DB::raw("MAX(CASE WHEN `key` IN ('loan_interest', 'loan-interest') THEN value END) as loan_interest"),
                DB::raw("MAX(CASE WHEN `key` IN ('initial_amount', 'initial-amount') THEN value END) as initial_amount"),
                DB::raw("MAX(CASE WHEN `key` IN ('feasibility_study', 'feasibility-study') THEN value END) as feasibility_study"),
                DB::raw("MAX(CASE WHEN `key` IN ('mobile', 'user-mobile', 'user_mobile') THEN value END) as mobile"),
                DB::raw("MAX(CASE WHEN `key` IN ('user-national_id', 'user_national_id', 'national_id') THEN value END) as user_national_id"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_place_info-postal_code', 'powerhouse_place_info_postal_code') THEN value END) as powerhouse_place_info_postal_code"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_place_info-address', 'powerhouse_place_info_address') THEN value END) as powerhouse_place_info_address")
            )
            ->groupBy('c.id', 'c.number');
        $query = $this->applyFilters($query, $filters);
        $rows = $query->paginate($perPage);
        $rows->getCollection()->transform(function ($row) {
            $row->last_status = Inbox::where('case_id', $row->id)
                ->whereNotIn('status', ['done', 'doneByOther', 'canceled'])
                ->get();
            return $row;
        });

        // return $rows;
        return view('SimpleWorkflowReportView::Core.AllRequests.index', [
            'rows' => $rows,
            'filters' => $filters,
            'perPage' => $perPage,
        ]);

        return view('SimpleWorkflowReportView::Core.AllRequests.index', [
            'rows' => $this->fetchRows($filters, $perPage),
            'filters' => $filters,
            'perPage' => $perPage,
        ]);
    }

    public function export(Request $request): BinaryFileResponse
    {
        $filters = Arr::except($request->except('page'), ['per_page']);

        $rows = $this->prepareRows(
            $this->applyFilters(
                $this->baseQuery($filters),
                $filters
            )->get()
        );

        return Excel::download(
            new AllRequestsReportExport($rows),
            'all-requests-report.xlsx'
        );
    }

    protected function fetchRows(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $perPage = $this->resolvePerPage($perPage);

        $query = $this->baseQuery($filters);

        $filters = Arr::except($filters, ['per_page']);

        $query = $this->applyFilters($query, $filters);

        $appendFilters = array_filter($filters, function ($value) {
            return $value !== null && $value !== '';
        });

        $appendFilters['per_page'] = $perPage;

        $paginator = $query->paginate($perPage)->appends($appendFilters);

        $paginator->setCollection(
            $this->prepareRows($paginator->getCollection())
        );

        return $paginator;
    }

    protected function baseQuery(array $filters)
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
                DB::raw("MAX(CASE WHEN `key` IN ('feasibility_study', 'feasibility-study') THEN value END) as feasibility_study"),
                DB::raw("MAX(CASE WHEN `key` IN ('mobile', 'user-mobile', 'user_mobile') THEN value END) as mobile"),
                DB::raw("MAX(CASE WHEN `key` IN ('user-national_id', 'user_national_id', 'national_id') THEN value END) as user_national_id"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_place_info-postal_code', 'powerhouse_place_info_postal_code') THEN value END) as powerhouse_place_info_postal_code"),
                DB::raw("MAX(CASE WHEN `key` IN ('powerhouse_place_info-address', 'powerhouse_place_info_address') THEN value END) as powerhouse_place_info_address")
            )
            ->groupBy('case_id');

        $latestInbox = DB::table('wf_inbox')
            ->select('case_id', DB::raw('MAX(id) as latest_id'))
            ->groupBy('case_id');

        $taskStyledNameColumn = Schema::hasColumn('wf_task', 'styled_name')
            ? 'tasks.styled_name'
            : 'tasks.name';

        $lastStatuses = DB::table('wf_inbox as inbox')
            ->joinSub($latestInbox, 'latest', function ($join) {
                $join->on('inbox.case_id', '=', 'latest.case_id')
                    ->on('inbox.id', '=', 'latest.latest_id');
            })
            ->leftJoin('wf_task as tasks', 'tasks.id', '=', 'inbox.task_id')
            ->select(
                'inbox.case_id',
                'inbox.status as inbox_status',
                'tasks.name as task_name',
                DB::raw($taskStyledNameColumn . ' as task_styled_name')
            );

        $activeStatuses = DB::table('wf_inbox as inbox')
            ->leftJoin('wf_task as tasks', 'tasks.id', '=', 'inbox.task_id')
            ->select(
                'inbox.case_id',
                DB::raw("GROUP_CONCAT(DISTINCT COALESCE($taskStyledNameColumn, tasks.name, inbox.status) ORDER BY inbox.id SEPARATOR '|||') as active_statuses")
            )
            ->whereIn('inbox.status', $this->openStatuses)
            ->groupBy('inbox.case_id');

        return DB::table('wf_cases as cases')
            ->leftJoinSub($caseVariables, 'vars', function ($join) {
                $join->on('cases.id', '=', 'vars.case_id');
            })
            ->leftJoin('wf_entity_powerhouse_place_info as place', 'place.id', '=', 'vars.powerhouse_place_info_id')
            ->leftJoinSub($lastStatuses, 'last_status', function ($join) {
                $join->on('cases.id', '=', 'last_status.case_id');
            })
            ->leftJoinSub($activeStatuses, 'active_statuses', function ($join) {
                $join->on('cases.id', '=', 'active_statuses.case_id');
            })
            ->select([
                'cases.id as case_id',
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
                'vars.mobile',
                'vars.user_national_id',
                DB::raw('COALESCE(vars.powerhouse_place_info_postal_code, place.postal_code) as powerhouse_postal_code'),
                DB::raw('COALESCE(vars.powerhouse_place_info_address, place.address) as powerhouse_address'),
                'cases.status as case_status',
                'last_status.inbox_status',
                'last_status.task_name',
                'last_status.task_styled_name',
                'active_statuses.active_statuses',
                DB::raw('COALESCE(last_status.task_styled_name, last_status.task_name, last_status.inbox_status, cases.status) as last_status')
            ])
            ->orderByDesc('cases.created_at');
    }

    public function show(string $caseNumber): View
    {
        $row = $this->baseQuery([])
            ->where('cases.number', $caseNumber)
            ->first();

        if (!$row) {
            abort(404);
        }

        $row = $this->prepareRows(collect([$row]))->first();

        /** @var CallHistoryService $callHistoryService */
        $callHistoryService = app(CallHistoryService::class);

        $callRecords = collect();
        $callRecordsError = null;
        $searchedNumbers = [];

        if (!empty($row->mobile)) {
            $callRecords = $callHistoryService->getCallsByPhone($row->mobile);
            $callRecordsError = $callHistoryService->getLastError();
            $searchedNumbers = $callHistoryService->getLastSearchNumbers();
        }

        return view('SimpleWorkflowReportView::Core.AllRequests.show', [
            'requestRow' => $row,
            'conversationViewModel' => ViewModel::find('912880ce-7acf-4735-9170-cbc34b39362b'),
            'callRecords' => $callRecords,
            'callRecordsError' => $callRecordsError,
            'callRecordsSearchedNumbers' => $searchedNumbers,
        ]);
    }

    protected function prepareRows(Collection $rows): Collection
    {
        return $rows->map(function ($row) {
            $activeStatuses = $this->extractStatuses($row->active_statuses ?? null);

            if ($activeStatuses->isNotEmpty()) {
                $row->last_status = $activeStatuses->implode('، ');
            } else {
                $lastStatus = trim(strip_tags($row->last_status ?? ''));

                if ($lastStatus === '') {
                    $lastStatus = $row->inbox_status ?? $row->case_status ?? null;
                }

                $row->last_status = $lastStatus;
            }

            unset($row->active_statuses);

            return $row;
        });
    }

    protected function extractStatuses(?string $rawStatuses): Collection
    {
        if (! $rawStatuses) {
            return collect();
        }

        return collect(explode('|||', $rawStatuses))
            ->map(function ($value) {
                $value = trim(strip_tags($value ?? ''));

                return $value === '' ? null : $value;
            })
            ->filter()
            ->unique()
            ->values();
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
            $query->having('number', 'like', '%' . $filters['case_number'] . '%');
        }

        if (!empty($filters['user_firstname'])) {
            $query->having('user_firstname', 'like', '%' . $filters['user_firstname'] . '%');
        }

        if (!empty($filters['user_lastname'])) {
            $query->having('user_lastname', 'like', '%' . $filters['user_lastname'] . '%');
        }

        if (!empty($filters['electricity_bill_id'])) {
            $query->having('electricity_bill_id', 'like', '%' . $filters['electricity_bill_id'] . '%');
        }

        if (!empty($filters['powerhouse_type'])) {
            $query->having('powerhouse_type', 'like', '%' . $filters['powerhouse_type'] . '%');
        }

        if (!empty($filters['requested_capacity_of_powerhouse'])) {
            $query->having('requested_capacity_of_powerhouse', 'like', '%' . $filters['requested_capacity_of_powerhouse'] . '%');
        }

        if (!empty($filters['first_call_result'])) {
            $query->having('first_call_result', 'like', '%' . $filters['first_call_result'] . '%');
        }

        if (!empty($filters['loan_interest'])) {
            $query->having('loan_interest', 'like', '%' . $filters['loan_interest'] . '%');
        }

        if (!empty($filters['initial_amount'])) {
            $query->having('initial_amount', 'like', '%' . $filters['initial_amount'] . '%');
        }

        if (!empty($filters['feasibility_study'])) {
            $query->where('feasibility_study', 'like', '%' . $filters['feasibility_study'] . '%');
        }


        return $query;
    }
}
