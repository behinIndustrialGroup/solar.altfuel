@php
    $content = json_decode($form->content);
    $formMode = in_array($inbox->status, ['done', 'doneByOther']) ? 'readonly' : null;
@endphp


@extends('behin-layouts.app')

@section('title', $form->name)

@section('content')
    <div class="d-none">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $task->name }} - {{ $inbox->case_name }}</h6>
        </div>
        <div class="card-body">
            <p class="mb-0">
                {{ trans('fields.Case Number') }}:
                <span class="badge badge-secondary">{{ $case->number }}</span> <br>

                {{ trans('fields.Creator') }}:
                <span class="badge badge-light">{{ getUserInfo($case->creator)->name }}</span> <br>

                {{ trans('fields.Created At') }}:
                <span class="badge badge-light" dir="ltr">{{ toJalali($case->created_at)->format('Y-m-d H:i') }}</span>
                <br>

                <span class="badge badge-light" style="color: dark">{{ $case->id }}</span>
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $form->name }}</h6>
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" method="POST" id="form" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                <input type="hidden" name="inboxId" id="inboxId" value="{{ $inbox->id }}">
                <input type="hidden" name="caseId" id="caseId" value="{{ $case->id }}">
                <input type="hidden" name="taskId" id="taskId" value="{{ $task->id }}">
                <input type="hidden" name="processId" id="processId" value="{{ $process->id }}">
                @if (View::exists('SimpleWorkflowView::Custom.Form.' . $form->id))
                    @include('SimpleWorkflowView::Custom.Form.' . $form->id, [
                        'form' => $form,
                        'task' => $task,
                        'case' => $case,
                        'inbox' => $inbox,
                        'variables' => $variables,
                        'process' => $process,
                        'mode' => $formMode,
                    ])
                @else
                    @include('SimpleWorkflowView::Core.Form.preview', [
                        'form' => $form,
                        'task' => $task,
                        'case' => $case,
                        'inbox' => $inbox,
                        'variables' => $variables,
                        'process' => $process,
                        'mode' => $formMode,
                    ])
                @endif
            </form>
        </div>
    </div>

    @if (in_array($inbox->status, ['done', 'doneByOther']))
        <div class="card shadow-sm mb-2">
            <div class="card-body">
                <p class="m-0">
                    <i class="fa fa-check-circle text-success mr-2"></i>
                    {{ trans('fields.Done At') }}:
                    <span class="badge badge-light" dir="ltr">
                        {{ toJalali($inbox->updated_at)->format('Y-m-d H:i') }}
                    </span>
                    <br>
                    {{ trans('fields.Done By') }}:
                    <span class="badge badge-light">
                        {{ getUserInfo($inbox->actor)->name }}
                    </span>
                </p>
            </div>
        </div>
    @else
        <div class="action-buttons bg-white p-2 shadow-md flex justify-between items-center gap-2">
            @if ($inbox->status == 'draft')
                <button class="md-btn md-btn-info" onclick="createCaseNumberAndSave()">
                    <i class="fa fa-file-alt mr-1"></i>
                    {{ trans('fields.Create Case Number and Save') }}
                </button>
            @else
                <button class="md-btn md-btn-warning" onclick="showJumpModal()">
                    <i class="fa fa-arrow-right mr-1"></i>
                    {{ trans('fields.Send Manully') }}
                </button>

                <button class="md-btn md-btn-danger" onclick="saveAndNextForm()">
                    <i class="fa fa-save mr-1"></i>
                    <i class="fa fa-arrow-left mr-1"></i>
                    {{ trans('fields.Save and next') }}
                </button>
            @endif
        </div>

        <style>
            .md-btn {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                font-size: 14px;
                font-weight: 500;
                border: none;
                border-radius: 9999px;
                /* pill shape */
                padding: 10px 20px;
                color: #fff;
                cursor: pointer;
                transition: box-shadow 0.2s ease, transform 0.1s ease;
                overflow: hidden;
            }

            .md-btn:active {
                transform: scale(0.97);
            }

            .md-btn::after {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: width 0.4s ease, height 0.4s ease;
            }

            .md-btn:active::after {
                width: 220%;
                height: 220%;
            }

            .md-btn-info {
                background-color: #2196F3;
            }

            .md-btn-warning {
                background-color: #FFC107;
                color: #212121;
            }

            .md-btn-danger {
                background-color: #F44336;
            }

            .action-buttons {
                    position: relative;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 10px;
                    display: flex;
                    justify-content: space-around;
                    background: #fff;
                    border-top: 1px solid #ddd;
                    z-index: 1000;
                    border-radius: 10px;
                }

            /* موبایل: ثابت پایین صفحه */
            @media (max-width: 768px) {
                .action-buttons {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 10px;
                    display: flex;
                    justify-content: space-around;
                    background: #fff;
                    border-top: 1px solid #ddd;
                    z-index: 1000;
                }
            }
        </style>

    @endif
@endsection

@section('script')
    <script>
        initial_view()
        $('#mobile-navigation').fadeOut(1000)

        function createCaseNumberAndSave() {
            var form = $('#form')[0];
            var fd = new FormData(form);
            send_ajax_formdata_request(
                '{{ route('simpleWorkflow.routing.createCaseNumberAndSave') }}',
                fd,
                function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        show_message(response.msg)
                        window.location.reload();
                    } else {
                        show_error(response.msg);
                    }
                }
            )
        }

        function saveForm() {
            if ($('.view-model-update-btn').length > 0) {
                $('.view-model-update-btn').click()
            }
            var form = $('#form')[0];
            var fd = new FormData(form);
            send_ajax_formdata_request(
                '{{ route('simpleWorkflow.routing.save') }}',
                fd,
                function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        show_message(response.msg)
                        window.location.reload();
                    } else {
                        show_error(response.msg);
                    }
                }
            )
        }

        function saveAndNextForm() {
            if ($('.view-model-update-btn').length > 0) {
                $('.view-model-update-btn').click()
            }
            var form = $('#form')[0];
            var fd = new FormData(form);
            send_ajax_formdata_request(
                '{{ route('simpleWorkflow.routing.saveAndNext') }}',
                fd,
                function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        if (response.url) {
                            if(response.msg){
                                window.location.href = response.url + '?msg=' + response.msg;
                            }else{
                                window.location.href = response.url;
                            }
                        } else {
                            show_message(response.msg)
                            window.location.href = '{{ route('simpleWorkflow.inbox.index') }}';
                        }
                    } else {
                        show_error(response.msg);
                    }
                }
            )
        }

        function showJumpModal(task_id) {
            send_ajax_get_request(
                '{{ route('simpleWorkflow.task-jump.show', [$task->id, $inbox->id, $case->id, $process->id]) }}',
                function(response) {
                    open_admin_modal_with_data(response, '')
                }
            )
        }

        @if (in_array($inbox->status, ['done', 'doneByOther']))
            $(document).ready(function() {
                var form = $('#form');
                form.find('input, select, textarea, button').prop('disabled', true);
                form.find('a').removeAttr('href').css('pointer-events', 'none');
            });
        @endif
    </script>
@endsection
