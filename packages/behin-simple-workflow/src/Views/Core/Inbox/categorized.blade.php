@extends('behin-layouts.app')

@section('style')
    <style>
        .categorized-inbox-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(25, 118, 210, 0.08);
        }

        .categorized-inbox-card .card-body {
            padding: 2rem;
        }

        .task-category-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .task-category-scroll {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .category-chip {
            border: none;
            border-radius: 999px;
            padding: 0.6rem 1.2rem;
            background: #e3f2fd;
            color: #1976d2;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .category-chip .chip-count {
            background-color: rgba(25, 118, 210, 0.15);
            padding: 0.1rem 0.65rem;
            border-radius: 999px;
            font-size: 0.85rem;
        }

        .category-chip:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(25, 118, 210, 0.25);
        }

        .category-chip.active {
            background: linear-gradient(135deg, #1976d2, #42a5f5);
            color: #fff;
        }

        .category-chip.active .chip-count {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .task-category-select {
            max-width: 260px;
        }

        .active-filter-card {
            background: #e8f5e9;
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }

        .active-filter-card strong {
            color: #2e7d32;
        }

        .active-filter-card button {
            border: none;
            background: transparent;
            color: #2e7d32;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            cursor: pointer;
        }

        .table-modern {
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .table-modern thead {
            background: #f1f5f9;
            color: #374151;
        }

        .table-modern tbody tr {
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .table-modern tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
        }

        .table-modern td,
        .table-modern th {
            vertical-align: middle;
        }

        .status-badge {
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-new {
            background: rgba(25, 118, 210, 0.15);
            color: #0d47a1;
        }

        .status-in-progress {
            background: rgba(255, 193, 7, 0.2);
            color: #ff8f00;
        }

        .status-draft {
            background: rgba(3, 169, 244, 0.15);
            color: #0277bd;
        }

        .status-canceled {
            background: rgba(244, 67, 54, 0.18);
            color: #c62828;
        }

        .status-done {
            background: rgba(76, 175, 80, 0.18);
            color: #2e7d32;
        }

        @media (max-width: 768px) {
            .categorized-inbox-card .card-body {
                padding: 1.5rem;
            }

            .task-category-select {
                width: 100%;
                max-width: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-3">
        <div class="card categorized-inbox-card">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
                    <div>
                        <h2 class="h4 fw-bold text-dark mb-1">{{ trans('fields.Categorized Inbox') }}</h2>
                        <p class="text-muted mb-0 small">{{ trans('fields.Categorized Inbox Hint') }}</p>
                    </div>
                    <a href="{{ route('simpleWorkflow.inbox.index') }}" class="btn btn-outline-primary rounded-pill">
                        <i class="material-icons align-middle">inbox</i>
                        <span class="align-middle">{{ trans('fields.User Inbox') }}</span>
                    </a>
                </div>

                @if ($taskCategories->isNotEmpty())
                    <div class="task-category-wrapper mb-4">
                        <div class="task-category-scroll">
                            <button type="button" class="category-chip {{ $selectedTaskId === null ? 'active' : '' }}"
                                data-task-filter="">
                                <span class="chip-label">{{ trans('fields.All Tasks') }}</span>
                                <span class="chip-count">{{ $totalCount }}</span>
                            </button>
                            @foreach ($taskCategories as $category)
                                <button type="button"
                                    class="category-chip {{ $selectedTaskId === $category['id'] ? 'active' : '' }}"
                                    data-task-filter="{{ $category['id'] }}">
                                    <span class="chip-label">{{ $category['label'] }}</span>
                                    <span class="chip-count">{{ $category['count'] }}</span>
                                </button>
                            @endforeach
                        </div>
                        <div class="task-category-select">
                            <label for="task-filter" class="form-label text-muted small mb-1">{{ trans('fields.Switch Task') }}</label>
                            <select id="task-filter" class="form-select rounded-pill">
                                <option value="" {{ $selectedTaskId === null ? 'selected' : '' }}>{{ trans('fields.All Tasks') }}</option>
                                @foreach ($taskCategories as $category)
                                    <option value="{{ $category['id'] }}"
                                        {{ $selectedTaskId === $category['id'] ? 'selected' : '' }}>
                                        {{ $category['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mb-0">{{ trans('fields.You have no items in your inbox') }}</div>
                @endif

                @if ($selectedTaskLabel)
                    <div class="active-filter-card d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-muted small">{{ trans('fields.Selected Task') }}</span>
                            <strong>{{ $selectedTaskLabel }}</strong>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-muted small">{{ trans('fields.Items Count') }}: {{ $rows->count() }}</div>
                            <button type="button" data-task-filter="">
                                <i class="material-icons">close</i>
                                {{ trans('fields.Clear Filter') }}
                            </button>
                        </div>
                    </div>
                @endif

                @if ($rows->isEmpty())
                    <div class="alert alert-light border text-muted">{{ trans('fields.You have no items in your inbox') }}</div>
                @else
                    <div class="table-responsive table-modern">
                        <table class="table align-middle mb-0" id="categorized-inbox-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>{{ trans('fields.Case Title') }}</th>
                                    <th>{{ trans('fields.Process Title') }}</th>
                                    <th>{{ trans('fields.Case Number') }}</th>
                                    <th>{{ trans('fields.Status') }}</th>
                                    <th>{{ trans('fields.Received At') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr ondblclick="window.location.href = '{{ route('simpleWorkflow.inbox.view', $row->id) }}'">
                                        <td class="text-nowrap">
                                            <a href="{{ route('simpleWorkflow.inbox.view', $row->id) }}" class="text-primary me-2">
                                                <i class="material-icons">open_in_new</i>
                                            </a>
                                            @if ($row->task && $row->task->allow_cancel)
                                                <a href="{{ route('simpleWorkflow.inbox.cancel', $row->id) }}"
                                                    title="{{ trans('fields.Cancel') }}"
                                                    onclick="return confirm('آیا از لغو درخواست مطمئن هستید؟')"
                                                    class="text-danger">
                                                    <i class="material-icons">cancel</i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $row->case_name ?? '-' }}</div>
                                        </td>
                                        <td>{{ optional($row->task->process ?? null)->name ?? '-' }}</td>
                                        <td>{{ optional($row->case ?? null)->number ?? '-' }}</td>
                                        <td>
                                            @php
                                                $status = $row->status;
                                            @endphp
                                            @if ($status === 'new')
                                                <span class="status-badge status-new">{{ trans('fields.New') }}</span>
                                            @elseif($status === 'in_progress' || $status === 'inProgress')
                                                <span class="status-badge status-in-progress">{{ trans('fields.In Progress') }}</span>
                                            @elseif($status === 'draft')
                                                <span class="status-badge status-draft">{{ trans('fields.Draft') }}</span>
                                            @elseif($status === 'canceled')
                                                <span class="status-badge status-canceled">{{ trans('fields.Canceled') }}</span>
                                            @else
                                                <span class="status-badge status-done">{{ trans('fields.Completed') }}</span>
                                            @endif
                                        </td>
                                        <td dir="ltr" class="text-muted">
                                            {{ toJalali($row->created_at)->format('Y-m-d') }}
                                            <span class="d-block small">{{ toJalali($row->created_at)->format('H:i') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateTaskFilter(taskId) {
            const url = new URL(window.location.href);
            if (taskId) {
                url.searchParams.set('task', taskId);
            } else {
                url.searchParams.delete('task');
            }
            window.location.href = url.toString();
        }

        document.querySelectorAll('[data-task-filter]').forEach((button) => {
            button.addEventListener('click', () => updateTaskFilter(button.dataset.taskFilter));
        });

        const taskSelect = document.getElementById('task-filter');
        if (taskSelect) {
            taskSelect.addEventListener('change', () => updateTaskFilter(taskSelect.value));
        }

        $(document).ready(function() {
            if ($('#categorized-inbox-table').length) {
                $('#categorized-inbox-table').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json'
                    },
                    order: [
                        [6, 'desc']
                    ],
                    pageLength: 15,
                    lengthChange: false,
                    responsive: true
                });
            }
        });
    </script>
@endsection
