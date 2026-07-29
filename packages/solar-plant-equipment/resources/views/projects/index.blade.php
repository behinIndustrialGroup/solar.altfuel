@extends('behin-layouts.app')

@section('title', 'لیست پروژه‌ها')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card card-primary card-outline">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0">
                    <i class="fa fa-list ml-2 text-primary"></i> لیست پروژه‌های نیروگاه خورشیدی
                </h3>
                <a href="{{ route('solar-plant-equipment.projects.create') }}"
                   class="btn btn-primary btn-sm">
                    <i class="fa fa-plus ml-1"></i> ثبت پروژه جدید
                </a>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="icon fa fa-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if ($projects->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fa fa-folder-open-o fa-3x mb-3 d-block"></i>
                        هیچ پروژه‌ای ثبت نشده است.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="projectsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:50px">#</th>
                                    <th>کد درخواست</th>
                                    <th>متقاضی</th>
                                    <th>پیمانکار</th>
                                    <th class="text-center">پنل‌ها</th>
                                    <th class="text-center">اینورترها</th>
                                    <th class="text-center">باتری‌ها</th>
                                    <th>تاریخ ثبت</th>
                                    <th style="width:100px">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($project->request_id)
                                                <span class="badge badge-light border">
                                                    #{{ $project->request_id }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>—</td>
                                        <td>
                                            @if ($project->contractor_id)
                                                <span class="badge badge-secondary">
                                                    #{{ $project->contractor_id }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">
                                                {{ count($project->installed_panel_ids ?? []) }} مدل
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-warning">
                                                {{ count($project->installed_inverter_ids ?? []) }} مدل
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                {{ count($project->installed_battery_ids ?? []) }} مدل
                                            </span>
                                        </td>
                                        <td>
                                            {{ \Morilog\Jalali\Jalalian::fromDateTime($project->created_at)->format('Y/m/d') }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('solar-plant-equipment.projects.show', $project) }}"
                                                   class="btn btn-outline-info" title="مشاهده">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('solar-plant-equipment.projects.edit', $project) }}"
                                                   class="btn btn-outline-warning" title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $projects->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#projectsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fa.json'
        },
        order: [[0, 'desc']],
        pageLength: 15,
        dom: 'Bfrtip',
        buttons: ['excel']
    });
});
</script>
@endsection
