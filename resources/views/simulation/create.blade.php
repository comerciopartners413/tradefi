@extends('layouts.app')

@push('styles')
<!--flot -->

    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="webapp/flot/excanvas.min.js'"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.flot.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.flot.time.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.flot.selection.js') }}"></script>

    <!-- -->

    <!-- bin/jquery.slider.min.css -->
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.blue.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.plastic.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.round.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.round.plastic.css') }}" type="text/css">
    <!-- end -->

    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery-1.7.1.js') }}"></script>

    <!-- bin/jquery.slider.min.js') }} -->
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jshashtable-2.1_src.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery.numberformatter-1.2.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/tmpl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery.dependClass-0.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/draggable-0.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery.slider.js') }}"></script>
    <!-- end -->

    <style>
    	#contentdiv {
    		/*margin-right:300px;*/
    	}
    </style>
@endpush
@section('content')

 <div class="container-fluid" id="normalmodediv" style="/*position:fixed;margin-right:inherit */">
    <h4 class="header">Set Prices for Securities</h4>
    <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-tbills" aria-expanded="false">Treasury Bills</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-bonds" aria-expanded="false">FGN Bonds</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-tbills" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                    <table id="securities-table-tbills" class="table datatable ">
                    <thead>
                        <tr>
                            <th>Security</th>
                            
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($securities_tbills as $security)
                        <tr>
                            <td>{{ $security->Description }}</td>
                            
                            {{-- <td class="v-align-middle"><input type="number" class="form-control buy-quantity" value="0"></td> --}}

                            <td class="v-align-middle">
                                <input type="number" class="form-control buy-price" value="0">
                            </td>
                            {{-- <td class="v-align-middle"><input type="number" class="form-control sell-quantity" value="0"></td> --}}
                            <td class="v-align-middle">
                                <input type="number" class="form-control sell-price" value="0">
                            </td>

                            <td class="v-align-middle">
                                <button type="submit" class="btn btn-sm btn-success post-btn" data-security-ref="{{ $security->SecurityRef }}">Post</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                                    </div>

                
                                </div>
                                <div id="tab-bonds" class="tab-pane">
                                    <div class="panel-body">
                                           <div class="table-responsive">
                    <table id="securities-table" class="table datatable ">
                    <thead>
                        <tr>
                            <th>Security</th>
                            
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($securities_bonds as $security)
                        <tr>
                            <td>{{ $security->Description }}</td>
                            
                            {{-- <td class="v-align-middle"><input type="number" class="form-control buy-quantity" value="0"></td> --}}

                            <td class="v-align-middle">
                                <input type="number" class="form-control buy-price" value="{{ $security->Price }}">
                            </td>
                            {{-- <td class="v-align-middle"><input type="number" class="form-control sell-quantity" value="0"></td> --}}
                            <td class="v-align-middle">
                                <input type="number" class="form-control sell-price" value="0">
                            </td>

                            <td class="v-align-middle">
                                <button type="submit" class="btn btn-sm btn-success post-btn" data-security-ref="{{ $security->SecurityRef }}">Post</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                                    </div>
                                 
                                </div>
                            </div>

                        </div>


<br>


</div>
@endsection





@push('scripts')
 <!-- Resources -->
        <script src="{{ asset('webapp/scripts/traderoom.js') }}"></script>
        <script src="{{ asset('js/jquery.tabledit.js') }}"></script>
        <script>
            $(function(){
                // $('.datatable').dataTable({});
            });
        </script>
        <script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

     $('.post-btn').click(function(e) {
        var that = $(this);
     e.preventDefault();
     $.ajax({
         url: '/trade-room/post-trade',
         type: 'POST',
         data: {
            SecurityRef : $(this).data('security-ref'),
            BuyPrice: $(this).parent().parent().find('.buy-price').val(),
            SellPrice: $(this).parent().parent().find('.sell-price').val(),
             BuyQuantity: $(this).parent().parent().find('.buy-quantity').val(),
            SellQuantity: $(this).parent().parent().find('.sell-quantity').val()
         },
         beforeSend: function(){
            that.text('Posting..');
         }
     })
     .done(function(data) {
         that.text('Post');
         console.log(data);
          // that.parent().parent().find('.buy-price').val(0);
        // that.parent().parent().find('.sell-price').val(0);
          toastr.success(data);
     })
     .fail(function() {
         console.log("error");
     })
     .always(function() {
         console.log("complete");
     });
     
 });
    
    // $('#securities-table').editableTableWidget();
  // $(document).ready(function(){
     var settings = {
    "sDom": "<'exportOptions'T><'table-responsive't><'row'<p i>>",
    "sPaginationType": "bootstrap",
    "destroy": true,
    "scrollCollapse": true,
    "oLanguage": {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
    },
     // "columnDefs": [
     //        {
     //            "targets": [ 3 ],
     //            "visible": false
     //        }
     //    ],
    "iDisplayLength": 10,
    "oTableTools": {
        "sSwfPath": "../assets/plugins/jquery-datatable/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        "aButtons": [{
            "sExtends": "csv",
            "sButtonText": "<i class='pg-grid'></i>",
        }, {
            "sExtends": "xls",
            "sButtonText": "<i class='fa fa-file-excel-o'></i>",
        }, {
            "sExtends": "pdf",
            "sButtonText": "<i class='fa fa-file-pdf-o'></i>",
        }, {
            "sExtends": "copy",
            "sButtonText": "<i class='fa fa-copy'></i>",
        }]
    },
    fnDrawCallback: function(oSettings) {
        $('.export-options-container').append($('.exportOptions'));
    }
};
      

var table = $('.datatable').dataTable();
 $('#securities-table tfoot th').each(function(key, val) {
            var title = $(this).text();
            // console.log($('#securities-table tfoot th').length);
             if (key === $('#securities-table tfoot th').length - 2) {
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" /><button class="toggleMaturity">Matured</button>');
            }
            if (key === $('#securities-table tfoot th').length - 1) {
                return false;
            } else {
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            }

           

        });   
 table.columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });


// listen for pusher even

    

 
  // });
</script>
@endpush