@if (auth()->user()->access('ثبت درخواست احداث نیروگاه'))
    <div class="col-sm-3 ">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ trans('احداث نیروگاه') }}</h3>

                <p>{{ trans('ثبت درخواست احداث نیروگاه') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('simpleWorkflow.process.start', [
                'taskId' => 'cf8147ed-042e-49a9-a9cf-04b7591a4eca',
                'force' => 1,
                'redirect' => 1,
                'inDraft' => 0
            ]) }}" class="small-box-footer">{{ trans('ثبت') }}
                <i class="fa fa-arrow-circle-left"></i></a>
        </div>
    </div>
@endif
