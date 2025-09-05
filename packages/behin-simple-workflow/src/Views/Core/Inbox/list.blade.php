@extends('behin-layouts.app')

@section('content')
    <div class="container table-responsive card p-2">
        <h2>{{ trans('fields.User Inbox') }}</h2>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (auth()->user()->access('کارتابل: فیلتر بر اساس فرایند'))
            <div class="mb-3">
                <label for="process-filter" class="form-label">{{ trans('fields.Process') }}</label>
                <select id="process-filter" class="form-select">
                    <option value="">{{ trans('fields.All') }}</option>
                    @foreach ($processes as $process)
                        <option value="{{ $process->id }}"
                            {{ isset($selectedProcess) && $selectedProcess == $process->id ? 'selected' : '' }}>
                            {{ $process->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if ($rows->isEmpty())
            <div class="alert alert-info">
                {{ trans('You have no items in your inbox.') }}
            </div>
        @else
            <table class="table table-striped" id="inbox-list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('fields.Case Title') }}</th>
                        <th>{{ trans('fields.Process Title') }}</th>
                        <th>{{ trans('fields.Task Title') }}</th>
                        <th>{{ trans('fields.Case Number') }}</th>
                        <th>{{ trans('fields.Status') }}</th>
                        <th>{{ trans('fields.Received At') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $index => $row)
                        <tr ondblclick="window.location.href = '{{ route('simpleWorkflow.inbox.view', $row->id) }}'">
                            <td>
                                <a href="{{ route('simpleWorkflow.inbox.view', $row->id) }}" class=""><i
                                        class="fa fa-external-link"></i></a>
                                {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}

                                @if ($row->status == 'draft')
                                    <a href="{{ route('simpleWorkflow.inbox.delete', $row->id) }}"
                                        class="btn btn-sm btn-danger">{{ trans('fields.Delete') }}
                                        <i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                            <td><a href="{{ route('simpleWorkflow.inbox.view', $row->id) }}"
                                    class="">{!! $row->task->styled_name !!}</a></td>
                            <td>{{ $row->task->process->name }}</td>
                            <td>{{ $row->case->number ?? '' }}</td>
                            <td>{{ $row->case_name }}</td>
                            <td>
                                @if ($row->status == 'new')
                                    <span class="badge bg-primary">{{ trans('fields.New') }}</span>
                                @elseif($row->status == 'in_progress')
                                    <span class="badge bg-warning">{{ trans('fields.In Progress') }}</span>
                                @elseif($row->status == 'draft')
                                    <span class="badge bg-info">{{ trans('fields.Draft') }}</span>
                                @else
                                    <span class="badge bg-success">{{ trans('fields.Completed') }}</span>
                                @endif
                            </td>
                            <td dir="ltr">
                                {{ toJalali($row->created_at)->format('Y-m-d') }}&nbsp;&nbsp;{{ toJalali($row->created_at)->format('H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
    <script>
        document.getElementById('process-filter').addEventListener('change', function() {
            const url = new URL(window.location.href);
            if (this.value) {
                url.searchParams.set('process', this.value);
            } else {
                url.searchParams.delete('process');
            }
            window.location.href = url.toString();
        });
    </script>
@endsection

@section('script')
    <script>
        $('#inbox-list').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
            },
            order: [
                [6, 'desc']
            ],
            pageLength: 25,
            "lengthChange": false
        });
    </script>
@endsection
