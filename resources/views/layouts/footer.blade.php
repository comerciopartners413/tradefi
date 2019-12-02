 </section>
        <!-- End main content-->
            @yield('feeds')

    </div>
    <!-- End wrapper-->

    <!-- Includable Modals -->

    <div class="modal right fade in" id="fundmodal" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content" style="">
                    <!--<div class="modal-header clearfix text-left">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
X</button>
</div>-->
                    <div class="modal-body ">

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close &nbsp;<i class="fa fa-times"></i>
</button>-->

                                <a href="#" data-dismiss="modal" aria-hidden="true">Close &nbsp;<i class="fa fa-times"></i>
</a>

                            </div>
                            <div class="text-right col-md-6 col-xs-12" style="">
                                <i class="pe-7s-server c-accent"></i>
                                <small class="stat-label">Available Cash Balance</small>
                                <h3 class="m-t-lg"> <span style="color:#ffdead">{{ $gl_balance }} </span> </h3>

                            </div>

                        </div>

                        <div class="tabs-container">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab-reconcile" aria-expanded="false">Deposit</a></li>
                                <li><a data-toggle="tab" href="#tab-withdraw" aria-expanded="false">Withdraw</a></li>

                                <!--  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
close X</button>-->

                            </ul>
                            <div class="tab-content">
                                <div id="tab-reconcile" class="tab-pane active">
                                    <div class="panel-body">
                                            {{ Form::open(['action' => 'DepositController@store']) }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Name</label>
                                                        {{ Form::select('BankID', $banks->pluck('name','id'), null,['class' => 'select2_demo_1  form_control', 'style'=>"width: 100%"]) }}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Transaction Type</label>
                                                       {{ Form::select('TransferTypeID', $transfer_types->pluck('TransferType','TransferTypeRef'), null,['class' => 'select2_demo_1  form_control', 'style'=>"width: 100%"]) }}
                                                       <input type="hidden" name="PostingTypeID" id="PostingTypeID" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Transaction Date</label>
                                                        <input 
                                                            type="date" 
                                                            name="TransactionDate" 
                                                            placeholder="Enter Here" 
                                                            class="form-control" 
                                                            required="" 
                                                            value="{{ \Carbon\Carbon::parse(TradefiUBA\Config::first()->TradeDate)->toDateString()  }}" aria-required="true"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Amount Deposited</label>
                                                        <input type="text" name="Amount"  placeholder="Enter Here" class="form-control smartinput" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit">Send Payment Information</button>

                                        {{-- </form> --}}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <!-- t13 -->

                                <div id="tab-withdraw" class="tab-pane">
                                    <div class="panel-body">
                                        @include('errors.list')
                                        <form id="form-withdrawal" method="post" class="p-t-15" role="form" action="{{ action('WithdrawalController@store') }}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Amount to Withdraw</label>
                                                        <input type="text" name="Amount" placeholder="Enter Amount" class="form-control smartinput" required="" aria-required="true">
                                                        {{-- Hidden fields for withdrawals --}}
                                                        <input type="hidden" name="GLIDDebit" value="{{ auth()->user()->gls->where('AccountTypeID', 1)->first()->GLRef }}">
                                                         <input type="hidden" name="GLIDCredit" value="1">
                                                         <input type="hidden" name="PostDate" value="{{ \DB::table('tblConfig')->first()->TradeDate}}" class="form-control" readonly="">
                                                         <input type="hidden" name="ValueDate" value="{{ \DB::table('tblConfig')->first()->TradeDate}}" class="form-control" readonly="">

                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Name</label>
                                                        {{ Form::select('BankID', $banks->pluck('name','id'), null,['class' => 'select2_demo_1  form_control', 'style'=>"width: 100%"]) }}
                                                    </div>
                                                </div>


                                            </div>

                                            <input type="hidden" name="InputterID" id="InputterID" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="CustomerID" id="CustomerID" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="PostingTypeID" id="PostingTypeID" value="2">

                                            <button class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit">Withdraw</button>

                                        </form>
                                    </div>
                                </div>
                                <!-- t13 -->

                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>

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
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- App scripts -->
    <script src="{{ asset('webapp/scripts/luna.js') }}"></script>
    
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/jquery.idle.js') }}"></script>
    <script src="{{ asset('js/jquery.rss.min.js') }}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.2.0/js/ion.rangeSlider.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
           <!-- Start of Async Drift Code -->

            !function() {
              var t;
              if (t = window.driftt = window.drift = window.driftt || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Drift snippet included twice.")) : (t.invoked = !0, 
              t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
              t.factory = function(e) {
                return function() {
                  var n;
                  return n = Array.prototype.slice.call(arguments), n.unshift(e), t.push(n), t;
                };
              }, t.methods.forEach(function(e) {
                t[e] = t.factory(e);
              }), t.load = function(t) {
                var e, n, o, i;
                e = 3e5, i = Math.ceil(new Date() / e) * e, o = document.createElement("script"), 
                o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + i + "/" + t + ".js", 
                n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
              });
            }();
            drift.SNIPPET_VERSION = '0.3.1';
            drift.load('2mb7mv8tuuzm');

            <!-- End of Async Drift Code -->
    </script>
    @stack('scripts')
    <script type="text/javascript">
        $(window).load(function() {
            $(".customloader").fadeOut("slow");
        })
        $('.smartinput').smartInput();
        
        $(document).idle({
          onIdle: function(){
              document.location.href = '/timedout';  
          },
          onActive: function(){},
          idle: {{ config('session.lifetime') * 60 * 1000 }}
        })
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

            $('.datatable').DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                }, {
                    extend: 'excel',
                    title: 'TradeFi Excel Export',
                    className: 'btn-sm'
                }, {
                    extend: 'pdf',
                    title: 'TradeFi Pdf Export',
                    className: 'btn-sm'
                }, {
                    extend: 'print',
                    className: 'btn-sm'
                }]
            });
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

            var options = {
         todayHighlight: true,
         autoclose: true,
         // endDate: today,
         format: 'yyyy-mm-dd'
     };
     $('.dp').datepicker(options);

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

            