@extends('behin-layouts.app')

@section('title', 'لیست پروژه‌ها')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card card-primary card-outline" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <div class="card-header d-flex align-items-center justify-content-between" style="background: linear-gradient(90deg, #FFB74D 0%, #FF9800 100%); color: #fff;">
                <h3 class="card-title mb-0" style="color: #fff;">
                    <i class="fa fa-solar-panel ml-2" style="color: #fff;"></i> لیست پروژه‌های نیروگاه خورشیدی
                </h3>
                <a href="{{ route('solar-plant-equipment.projects.create') }}"
                   class="btn btn-sm" style="background: #fff; color: #FF9800; border: 2px solid #fff; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#FFF3E0'; this.style.borderColor='#FFF3E0';"
                   onmouseout="this.style.background='#fff'; this.style.borderColor='#fff';">
                    <i class="fa fa-plus ml-1"></i> ثبت پروژه جدید
                </a>
            </div>

            <div class="card-body" style="background: #fafafa;">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible mb-4" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); color: #2E7D32;">
                        <button type="button" class="close" data-dismiss="alert" style="color: #2E7D32; opacity: 0.8;">&times;</button>
                        <i class="icon fa fa-check-circle ml-2" style="font-size: 20px;"></i>
                        <span style="font-weight: 500;">{{ session('success') }}</span>
                    </div>
                @endif

                @php
                    $totalProjects = $projects->count();
                    $approvedProjects = $projects->where('status', 'STATUS_APPROVED')->count();
                    $inProgressProjects = $projects->where('status', 'STATUS_IN_PROGRESS')->count();
                    $activeInspectors = $projects->whereNotNull('inspector_id')->pluck('inspector_id')->unique()->count();
                @endphp

                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="p-4" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: transform 0.2s ease, box-shadow 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.10)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.06)';">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="color: #999; font-size: 13px; font-weight: 500;">تعداد کل پروژه‌ها</p>
                                    <h3 class="mb-0" style="color: #FF9800; font-weight: 700; font-size: 28px;">{{ $totalProjects }}</h3>
                                </div>
                                <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-layer-group" style="font-size: 24px; color: #FF9800;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="p-4" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: transform 0.2s ease, box-shadow 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.10)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.06)';">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="color: #999; font-size: 13px; font-weight: 500;">تأیید شده</p>
                                    <h3 class="mb-0" style="color: #43A047; font-weight: 700; font-size: 28px;">{{ $approvedProjects }}</h3>
                                </div>
                                <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-check-circle" style="font-size: 24px; color: #43A047;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="p-4" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: transform 0.2s ease, box-shadow 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.10)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.06)';">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="color: #999; font-size: 13px; font-weight: 500;">در حال انجام</p>
                                    <h3 class="mb-0" style="color: #FB8C00; font-weight: 700; font-size: 28px;">{{ $inProgressProjects }}</h3>
                                </div>
                                <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #FFF8E1 0%, #FFECB3 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #FB8C00;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="p-4" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: transform 0.2s ease, box-shadow 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.10)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.06)';">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-1" style="color: #999; font-size: 13px; font-weight: 500;">بازرس‌های فعال</p>
                                    <h3 class="mb-0" style="color: #1E88E5; font-weight: 700; font-size: 28px;">{{ $activeInspectors }}</h3>
                                </div>
                                <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-user-tie" style="font-size: 24px; color: #1E88E5;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($projects->isEmpty())
                    <div class="text-center py-5" style="background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
                        <i class="fa fa-folder-open-o mb-4 d-block" style="font-size: 80px; color: #FFCC80; opacity: 0.8;"></i>
                        <h4 style="color: #FF9800; font-weight: 600; margin-bottom: 8px;">هیچ پروژه‌ای ثبت نشده است</h4>
                        <p style="color: #999; margin-bottom: 24px;">برای شروع، اولین پروژه خود را ثبت کنید.</p>
                        <a href="{{ route('solar-plant-equipment.projects.create') }}"
                           class="btn" style="background: linear-gradient(90deg, #FFB74D 0%, #FF9800 100%); color: #fff; border: none; border-radius: 10px; padding: 10px 28px; font-weight: 600; box-shadow: 0 4px 14px rgba(255, 152, 0, 0.35); transition: all 0.3s ease;"
                           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(255, 152, 0, 0.45)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(255, 152, 0, 0.35)';">
                            <i class="fa fa-plus ml-1"></i> ثبت پروژه جدید
                        </a>
                    </div>
                @else
                    <div class="table-responsive" style="background: #fff; border-radius: 12px; padding: 0; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
                        <table class="table table-hover" id="projectsTable" style="margin: 0; border-collapse: separate; border-spacing: 0;">
                            <thead>
                                <tr style="background: #FFF3E0;">
                                    <th style="width:50px; padding: 14px 10px; color: #E65100; font-weight: 700; text-align: center; border-bottom: 2px solid #FFE0B2;">#</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; border-bottom: 2px solid #FFE0B2;">کد پروژه</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; border-bottom: 2px solid #FFE0B2;">کد تقاضا</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; border-bottom: 2px solid #FFE0B2;">نام متقاضی</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; border-bottom: 2px solid #FFE0B2;">پیمانکار</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; border-bottom: 2px solid #FFE0B2;">بازرس</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; text-align: center; border-bottom: 2px solid #FFE0B2;">وضعیت</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; text-align: center; border-bottom: 2px solid #FFE0B2;">تجهیزات</th>
                                    <th style="padding: 14px 10px; color: #E65100; font-weight: 700; border-bottom: 2px solid #FFE0B2;">تاریخ ثبت</th>
                                    <th style="width:130px; padding: 14px 10px; color: #E65100; font-weight: 700; text-align: center; border-bottom: 2px solid #FFE0B2;">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @php
                                        $req = $project->request;
                                        $applicantName = null;
                                        $requestCode = null;
                                        if ($req) {
                                            $requestCode = $req->unique_code;
                                            $type = is_object($req->applicant_type) ? ($req->applicant_type->value ?? $req->applicant_type) : $req->applicant_type;
                                            if ($type === 'company' && !empty($req->company_name)) {
                                                $applicantName = trim($req->company_name);
                                            } else {
                                                $full = trim(($req->first_name ?? '') . ' ' . ($req->last_name ?? ''));
                                                $applicantName = $full ?: null;
                                            }
                                        }
                                    @endphp
                                    <tr style="transition: background 0.2s ease;"
                                        onmouseover="this.style.background='#FFF8E1';"
                                        onmouseout="this.style.background='#fff';">
                                        <td style="padding: 12px 10px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f5f5f5; color: #666; font-weight: 600;">{{ $loop->iteration }}</td>
                                        <td style="padding: 12px 10px; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            <span style="display: inline-block; padding: 5px 12px; background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); color: #0D47A1; border-radius: 8px; font-weight: 600; font-size: 12px; font-family: 'Courier New', monospace;">
                                                PRJ-{{ $project->id }}
                                            </span>
                                        </td>
                                        <td style="padding: 12px 10px; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            @if ($requestCode)
                                                <span style="display: inline-block; padding: 5px 12px; background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); color: #E65100; border-radius: 8px; font-weight: 600; font-size: 12px; font-family: 'Courier New', monospace; letter-spacing: 0.3px;">
                                                    {{ $requestCode }}
                                                </span>
                                            @else
                                                <span style="color: #bdbdbd; font-size: 13px;">—</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 10px; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            @if ($applicantName)
                                                <div class="d-flex align-items-center">
                                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #8E24AA 0%, #6A1B9A 100%); display: flex; align-items: center; justify-content: center; margin-left: 10px; flex-shrink: 0;">
                                                        <i class="fa fa-user" style="font-size: 13px; color: #fff;"></i>
                                                    </div>
                                                    <span style="color: #333; font-weight: 500; font-size: 13px;">{{ $applicantName }}</span>
                                                </div>
                                            @else
                                                <span style="color: #bdbdbd; font-size: 13px;">—</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 10px; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            @if ($project->contractor)
                                                <span style="color: #455A64; font-weight: 500; font-size: 13px;">
                                                    {{ $project->contractor->company_name ?? $project->contractor->name ?? '#' . $project->contractor_id }}
                                                </span>
                                            @elseif ($project->contractor_id)
                                                <span style="display: inline-block; padding: 5px 12px; background: #F5F5F5; color: #616161; border-radius: 8px; font-weight: 500; font-size: 12px;">
                                                    #{{ $project->contractor_id }}
                                                </span>
                                            @else
                                                <span style="color: #bdbdbd; font-size: 13px;">—</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 10px; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            @if ($project->inspector)
                                                <div class="d-flex align-items-center">
                                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #1E88E5 0%, #1565C0 100%); display: flex; align-items: center; justify-content: center; margin-left: 10px; flex-shrink: 0;">
                                                        <i class="fa fa-user" style="font-size: 13px; color: #fff;"></i>
                                                    </div>
                                                    <span style="color: #333; font-weight: 500; font-size: 13px;">{{ optional($project->inspector)->name }}</span>
                                                </div>
                                            @else
                                                <span style="color: #bdbdbd; font-size: 13px;">—</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 10px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            {!! $project->status_label !!}
                                        </td>
                                        <td style="padding: 12px 10px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                                                @php
                                                    $panelCount = count($project->installed_panel_ids ?? []);
                                                    $inverterCount = count($project->installed_inverter_ids ?? []);
                                                    $batteryCount = count($project->installed_battery_ids ?? []);
                                                @endphp
                                                @if($panelCount > 0 || $inverterCount > 0 || $batteryCount > 0)
                                                    <span style="font-size: 12px; color: #424242; font-weight: 500;">
                                                        @if($panelCount > 0)
                                                            <span style="display: inline-flex; align-items: center; gap: 3px; margin-left: 6px;">
                                                                <i class="fa fa-solar-panel" style="color: #FF9800;"></i>
                                                                {{ $panelCount }} پنل
                                                            </span>
                                                        @endif
                                                        @if($inverterCount > 0)
                                                            <span style="display: inline-flex; align-items: center; gap: 3px; margin-left: 6px;">
                                                                <i class="fa fa-bolt" style="color: #FB8C00;"></i>
                                                                {{ $inverterCount }} اینورتر
                                                            </span>
                                                        @endif
                                                        @if($batteryCount > 0)
                                                            <span style="display: inline-flex; align-items: center; gap: 3px;">
                                                                <i class="fa fa-battery-full" style="color: #43A047;"></i>
                                                                {{ $batteryCount }} باتری
                                                            </span>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span style="color: #bdbdbd; font-size: 12px;">بدون تجهیز</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 12px 10px; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-calendar-alt ml-2" style="color: #FFB74D; font-size: 13px;"></i>
                                                <span style="color: #424242; font-weight: 500; font-size: 13px;">{{ \Morilog\Jalali\Jalalian::fromDateTime($project->created_at)->format('Y/m/d') }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 12px 10px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f5f5f5;">
                                            <div style="display: flex; gap: 6px; justify-content: center;">
                                                <a href="{{ route('solar-plant-equipment.projects.show', $project) }}"
                                                   class="btn btn-sm" title="مشاهده"
                                                   style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #039BE5; color: #039BE5; background: transparent; display: inline-flex; align-items: center; justify-content: center; transition: all 0.25s ease;"
                                                   onmouseover="this.style.background='#039BE5'; this.style.color='#fff';"
                                                   onmouseout="this.style.background='transparent'; this.style.color='#039BE5';">
                                                    <i  style="font-size: 10px;">مشاهده</i>
                                                </a>
                                                <a href="{{ route('solar-plant-equipment.projects.edit', $project) }}"
                                                   class="btn btn-sm" title="ویرایش"
                                                   style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #FB8C00; color: #FB8C00; background: transparent; display: inline-flex; align-items: center; justify-content: center; transition: all 0.25s ease;"
                                                   onmouseover="this.style.background='#FB8C00'; this.style.color='#fff';"
                                                   onmouseout="this.style.background='transparent'; this.style.color='#FB8C00';">
                                                    <i style="font-size: 10px;">ویرایش</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
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
        order: [[8, 'desc']],
        pageLength: 15,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-sm',
                style: 'background: linear-gradient(90deg, #4CAF50, #43A047); color: #fff; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 600; box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3); margin-bottom: 16px;',
                text: '<i class="fa fa-file-excel ml-1"></i> خروجی Excel'
            }
        ],
        drawCallback: function(settings) {
            $('.paginate_button').css({
                'border-radius': '8px',
                'margin': '0 3px',
                'border': '1px solid #FFE0B2',
                'background': '#fff'
            });
            $('.paginate_button.current').css({
                'background': 'linear-gradient(90deg, #FFB74D, #FF9800)',
                'border': 'none',
                'color': '#fff !important',
                'box-shadow': '0 2px 8px rgba(255,152,0,0.3)'
            });
        }
    });
});
</script>
@endsection
