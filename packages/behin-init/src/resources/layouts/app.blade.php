
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome 6 CDN (برای پشتیبانی از آیکون‌های جدید fa-solar-panel, fa-clipboard-check و ...) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Font Awesome 4 (قدیمی برای سازگاری) -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/plugins/font-awesome/css/font-awesome.min.css')  . '?' . config('app.version') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        /* سازگاری آیکون‌های قدیمی fa fa-* با Font Awesome 6 */
        .fa, .far, .fas, .fab, .fal, .fat {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .fa {
            font-family: "Font Awesome 6 Free", "FontAwesome";
            font-weight: 900;
        }
        /* آیکون‌های برند (Brand) در FA6 */
        .fa.fa-whatsapp,
        .fa.fa-facebook,
        .fa.fa-facebook-f,
        .fa.fa-twitter,
        .fa.fa-instagram,
        .fa.fa-telegram,
        .fa.fa-linkedin,
        .fa.fa-youtube,
        .fa.fa-google,
        .fa.fa-github {
            font-family: "Font Awesome 6 Brands";
            font-weight: 400;
        }
        /* اطمینان از نمایش ionicons */
        .ion {
            display: inline-block;
            font-family: "Ionicons";
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            text-rendering: auto;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
        }
    </style>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/dist/css/adminlte.min.css')  . '?' . config('app.version') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/plugins/datepicker/datepicker3.css')  . '?' . config('app.version') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/plugins/daterangepicker/daterangepicker-bs3.css')  . '?' . config('app.version') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')  . '?' . config('app.version') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/dist/css/bootstrap-rtl.min.css')  . '?' . config('app.version') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/dist/css/custom-style.css')  . '?' . config('app.version') }}">
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/dist/css/custom.css')  . '?' . config('app.version') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('behin/behin-dist/plugins/datatables/dataTables.bootstrap4.css')  . '?' . config('app.version') }}" />
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/dist/css/dropzone.min.css')  . '?' . config('app.version') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/dist/css/persian-datepicker-0.4.5.min.css')  . '?' . config('app.version') }}" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('behin/behin-dist/persian-date-picker/persian-datepicker.css') }}">
    @yield('style')

    <script src="{{ asset('behin/behin-dist/plugins/jquery/jquery.min.js') . '?' . config('app.version') }}"></script>
    <script src="{{ asset('behin/behin-dist/plugins/datatables/jquery.dataTables.js')  . '?' . config('app.version') }}"></script>
    <script src="{{ asset('behin/behin-dist/plugins/datatables/dataTables.bootstrap4.js')  . '?' . config('app.version') }}"></script>
    <script src="{{ asset('behin/behin-dist/persian-date-picker/persian-date.js')  . '?' . config('app.version') }}"></script>
    <script src="{{ asset('behin/behin-dist/persian-date-picker/persian-datepicker.js')  . '?' . config('app.version') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('behin/behin-js/ajax.js')  . '?' . config('app.version') }}"></script>
    <script src="{{ asset('behin/behin-js/dataTable.js')  . '?' . config('app.version') }}"></script>
    <script src="{{ asset('behin/behin-js/dropzone.js')  . '?' . config('app.version') }}"></script>
    @yield('script_in_head')
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    
        @include('behin-layouts.header')
    
        @include('behin-layouts.main-sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>



        <footer class="main-footer">
            {{-- <strong> &copy; 2018 <a href="http://github.com/hesammousavi/">حسام موسوی</a>.</strong> --}}
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

        <script src="{{ asset('behin/behin-dist/plugins/bootstrap/js/bootstrap.bundle.min.js')  . '?' . config('app.version') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{ asset('behin/behin-dist/plugins/knob/jquery.knob.js')  . '?' . config('app.version') }}"></script>
        <script src="{{ asset('behin/behin-dist/plugins/daterangepicker/daterangepicker.js')  . '?' . config('app.version') }}"></script>
        <script src="{{ asset('behin/behin-dist/plugins/datepicker/bootstrap-datepicker.js')  . '?' . config('app.version') }}"></script>
        <script src="{{ asset('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')  . '?' . config('app.version') }}"></script>
        <script src="{{ asset('behin/behin-dist/dist/js/adminlte.js')  . '?' . config('app.version') }}"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="{{ asset('behin/behin-dist/plugins/select2/select2.full.min.js')}}"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
        <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
        
        
        
        <script>

            function initial_view(){
                $('.select2').select2();
                $('.select2').css('width', '100%')
                $(".persian-date").persianDatepicker({
                    viewMode: 'day',
                    initialValue: false,
                    format: 'YYYY-MM-DD',
                    initialValueType: 'persian'
                });
            }

            
            
            

            
        </script>

        <script src="{{ asset('behin/behin-js/loader.js')  . '?' . config('app.version') }}"></script>
        <script src="{{ asset('behin/behin-js/scripts.js')  . '?' . config('app.version') }}"></script>

        @yield('script')
    </div>



</body>

</html>
