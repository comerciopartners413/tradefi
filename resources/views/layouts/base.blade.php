<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <link rel="icon" href="{{ asset('assets/favicon.ico" type="image/x-icon') }}" />
    <!-- Page title -->
    <title>{{ config('app.name', 'Comercio\'s TradeFI') }}</title>

    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('webapp/vendor/jquery/custom/li-scroller.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/styles/custom1.css') }}">
    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('webapp/vendor/fontawesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/animate.css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap.css') }}" />

    <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap-notifications.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/sweetalert2/sweetalert2.min.css') }}">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/pe-icon-7-stroke.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/helper.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/stroke-icons/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('webapp/styles/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     @stack('styles')

</head>

<body>
	@yield('content')
 </section>
        <!-- End main content-->
            @yield('feeds')

    </div>
    <!-- End wrapper-->

    <!-- Includable Modals -->


    <!-- End of Includable Modals -->
</div>
    <!-- Vendor scripts -->
    <script src="{{ asset('webapp/vendor/pacejs/pace.min.js') }}"></script>
    <script src="{{ asset('webapp/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('webapp/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('webapp/vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('webapp/vendor/select2/dist/js/select2.js') }}"></script>
    <script src="{{ asset('webapp/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('webapp/vendor/flot/jquery.flot.min.js') }}"></script>
    <script src="{{ asset('webapp/vendor/flot/jquery.flot.resize.min.js') }}"></script>
    <script src="{{ asset('webapp/vendor/flot/jquery.flot.spline.js') }}"></script>

    <script src="{{ asset('webapp/vendor/amcharts/amcharts.js') }}"></script>
    <script src="{{ asset('webapp/vendor/amcharts/pie.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('webapp/vendor/amcharts/export.css') }}" type="text/css" media="all" />
    <script src="{{ asset('webapp/vendor/amcharts/chalk.js') }}"></script>
    <script src="{{ asset('webapp/vendor/amcharts/dark.js') }}"></script>

    <script src="{{ asset('webapp/vendor/chart.js/dist/Chart.min.js') }}"></script>

    <script src="{{ asset('webapp/vendor/jquery/custom/jquery.li-scroller.1.0.js') }}"></script>
    <script src="{{ asset('webapp/vendor/jquery/custom/jquery.bootstrap.newsbox.min.js') }}" type="text/javascript"></script>

    <!-- App scripts -->
    <script src="{{ asset('webapp/scripts/luna.js') }}"></script>
    
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        $(window).load(function() {
            $(".customloader").fadeOut("slow");
        })
        $('.smartinput').smartInput();
    </script>
    <!-- Styles -->
    <style>
        #chartdiv,
        #bonds-chart, #tbills-chart {
            width: 95%;
            height: 250px;
        }
        #general-chart {
            width: 95%;
            height: 300px;
        }

    </style>

    <script>
        $(function() {
            $("ul#ticker01").liScroll();
        });
    </script>

    <script type="text/javascript">
        $(function() {


            $('#table1').DataTable({});
            $('#table2').DataTable({});
            $(".select2_demo_1").select2({
                placeholder: "Select One",
                allowClear: true
            });
            $(".select2_demo_2").select2({
                placeholder: "Select a state",
                allowClear: true
            });

            $("#demo3").bootstrapNews({
                newsPerPage: 3,
                autoplay: true,
                pauseOnHover: true,
                navigation: false,
                direction: 'up',
                newsTickerInterval: 2500,

                onToDo: function() {
                    //console.log(this);
                }
            });
        });
    </script>

    <script>
        var globalOptions = {
            responsive: true,
            legend: {
                labels: {
                    fontColor: "#90969D"
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "#90969D"
                    },
                    gridLines: {
                        color: "#37393F"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#90969D"
                    },
                    gridLines: {
                        color: "#37393F"
                    }
                }]
            }
        };

    </script>

    <!-- Chart code -->
    <script>
        var chart = AmCharts.makeChart("chartdiv0", {
            "type": "pie",
            "theme": "dark",

            "dataProvider": [{
                "bill": "FGN MAR 2020",
                "value": 260
            }, {
                "bill": "FGN MAR 2040",
                "value": 190
            }, {
                "bill": "FGN MAR 2037",
                "value": 110
            }],
            "fontFamily": "Montserrat, sans-serif",
            "fontSize": 12,
            "valueField": "value",
            "titleField": "bill",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:11px'><b>₦[[value]]</b> ([[percents]]%)</span>",
            "angle": 15,
            "export": {
                "enabled": true
            }
        });

        
    </script>

    <!-- Chart code -->
   

    <script type="text/javascript">
        $(window).load(function() {
            $(".pace").fadeOut("slow");

        });

        $(function() {
            Pace.stop();
            Pace.options = {
                ajax: false, // disabled
                document: false, // disabled
                eventLag: false, // disabled
                elements: {
                    selectors: ['body'],
                },
                restartOnRequestAfter: false,
                restartOnPushState: false
            };
        });
    </script>

    {{-- session timeout script --}}
    <script>
            // var timer = function(){
            //     $.get("{{ route('auth.check') }}", function (data) {

            //         if(data.status == false){
            //             alert('You are logged out due to inactivity on TradeFI');
            //             return window.location.href = "{{ route('login') }}"
            //         } else {
            //             return false;
            //         }
            //     });
            // };

            // window.setInterval(function(){
            //     timer();
            // },10000);
        
    </script>

    {{-- notifications --}}
    @if(session('success'))
<script> 
    // alert('success')
    toastr.success('{{ session('success') }} ');
</script>
@elseif(session('error'))
<script> 
      toastr.warning('{{ session('error') }}');
</script>
@elseif(session('info'))
<script> 
      toastr.warning('{{ session('info') }}');
</script>
@elseif(session('warning'))
<script> 
      toastr.warning('{{ session('warning') }}');
</script>
@endif

</body>

</html>

            