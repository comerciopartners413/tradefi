@extends('layouts.app')
@push('styles')
<style>
    .panel-toggle {
        margin-left: 15px !important;
    }

    .details{
   margin-right: 10px;
}
@media screen and (max-width: 600px) {
    .panel-heading {
min-height: 80px;
    }
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }
  table thead {
    display: none;
  }
  table tr {
    border-bottom: 2px solid #ddd;
    display: block;
    margin-bottom: 10px;
  }
  table td {
    border-bottom: 1px dotted #ccc;
    display: block;
    font-size: 13px;
    text-align: right;
  }
  table td:last-child {
    border-bottom: 0;
  }
  table td:before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: capitalize;
  }

  .nav-tabs > li > a {
    margin-right: 0;
    border-radius: 0;
    border: 0;
    padding: 10px;
  }

  .nav-tabs {
    border: none;
    display: flex;
    justify-content: space-between;
}

.details{
    display: block;
}

.details + .pull-left {
    float: none !important;
}

.details + .pull-right {
    float: none !important;
}
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- START PANEL -->

    <h3>Account Statement</h3>
    <p>View cash, Bonds and Treasury Bills statements from all your transactions</p> <br> <br>


    <div class="panel panel-filled panel-c-warning panel-collapse">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                    {{-- <a class="panel-close"><i class="fa fa-times"></i></a> --}}
                </div>
                <b>Cash Deposits</b> 
                {{-- <div class="pull-right">
                    <b class="text-success">{{ number_format(auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance, 2) }}</b>
                </div> --}}
            </div>
            <div class="panel-body">
                {{-- <input type="text" class="form-control" id="filter"> --}}
                <div class="table-responsive">
                    <table class="table transactions">
                <thead>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Message</th>
                    <th>Query</th>
                    
                </thead>
                <tbody>
                @if(isset($cash_deposits))
                    @foreach($cash_deposits as $c_dep)
                    <tr>
                        <td data-label="Transaction ID">{{$c_dep->transaction_id}}</td>
                        <td data-label="Amount">₦{{number_format($c_dep->Amount, 2)}}</td>
                        <td data-label="Status">{{$c_dep->Status}}</td>
                        <td data-label="Date">{{\Carbon\Carbon::parse($c_dep->TransactionDate,2)->toFormattedDateString() }}</td>
                        <td data-label="Reference">{{$c_dep->cpay_ref }}</td>
                        <td data-label="Message">{{ $c_dep->Description }}</td>
                        <td data-label="Query>@if($c_dep->Status != '000')<button data-cpay="{{ $c_dep->cpay_ref }}" data-trans="{{ $c_dep->transaction_id }}" data-cpay="{{ $c_dep->CashEntryRef }}" class="btn btn-warning requery-btn">Re-Query</button>@endif</td>
                        
                    </tr>
                    @endforeach
                @endif
                </tbody>
                {{-- <tfoot style="font-weight: bold; color: #f6a821;">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ isset($cash_debit_total) ? number_format($cash_debit_total, 2) : null }}</td>
                        <td>{{ isset($cash_credit_total) ? number_format($cash_credit_total, 2) : null }}</td>
                        <td></td>
                    </tr>
                </tfoot> --}}
            </table>
                </div>
            </div>
        </div>

    <div class="panel panel-filled panel-c-success panel-collapse">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                    {{-- <a class="panel-close"><i class="fa fa-times"></i></a> --}}
                </div>
                <span class="details">
                    <b>Cash Account</b>
                </span> 
                <div class="pull-right">
                    <span class="details">
                        <strong>Book Balance: &nbsp;<b class="text-success">{{ number_format(auth()->user()->gls->where('AccountTypeID', 1)->first()->BookBalance, 2) }}</b></strong>
                    </span>

                    <span class="details">
                        <strong>Available Balance: &nbsp; 
                        <b class="text-success"><gl-component main_balance="{{ $gl_balance }}" :user_id="{{ auth()->user()->id }}">
                                {{ $gl_balance }}
                            </gl-component></b>
                    </strong>
                    </span>
                </div>
            </div>
            <div class="panel-body">
                {{-- <input type="text" class="form-control" id="filter"> --}}
                <div class="table-responsive">
                    <table class="table transactions" >
                <thead>
                    <th>Transaction Date</th>
                    <th>Value Date</th>
                    <th>Narration</th>
                    <th>Debits</th>
                    <th>Credits</th>
                    <th>Balance</th>
                    
                </thead>
                <tbody>
                @if(isset($statements_cash))
                    @foreach($statements_cash as $statement)
                    <tr>
                        <td data-label="Transaction Date">{{$statement->PostDate > $statement->ValueDate ? \Carbon\Carbon::parse($statement->ValueDate)->toFormattedDateString() : \Carbon\Carbon::parse($statement->ValueDate)->toFormattedDateString() }}</td>
                        <td data-label="Value Date">{{$statement->PostDate > $statement->ValueDate ? \Carbon\Carbon::parse($statement->PostDate)->toFormattedDateString() : \Carbon\Carbon::parse($statement->ValueDate)->toFormattedDateString() }}</td>
                        <td data-label="Narration">{{$statement->Narration}}</td>
                        <td data-label="Debits">{{number_format($statement->Debit,2) }}</td>
                        <td data-label="Credits">{{number_format($statement->Credit,2) }}</td>
                        <td data-label="Balance">{{number_format($statement->Balance,2) }}</td>
                        
                    </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot style="font-weight: bold; color: #f6a821;">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ isset($cash_debit_total) ? number_format($cash_debit_total, 2) : null }}</td>
                        <td>{{ isset($cash_credit_total) ? number_format($cash_credit_total, 2) : null }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
                </div>
            </div>
        </div>
        <div class="panel panel-filled panel-c-info panel-collapse">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                    {{-- <a class="panel-close"><i class="fa fa-times"></i></a> --}}
                </div>
                <span class="details">
                    <b>Bonds</b>
                </span>    
                <div class="pull-right">
                     <span class="details">
                        <strong>Book Balance: &nbsp;<b class="text-success">{{ number_format(auth()->user()->gls->where('AccountTypeID', 2)->sum('BookBalance'), 2) }}</b></strong>
                     </span>

                    <span class="details">
                        <strong>Available Balance: &nbsp; 
                        <b class="text-success">{{ number_format(auth()->user()->gls->where('AccountTypeID', 2)->sum('ClearedBalance'), 2) }}</b>
                        </strong>
                    </span>    
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table datatable">
                <thead>
                    <th>Transaction Date</th>
                    <th>Value Date</th>
                    <th>Narration</th>
                    <th>Debits</th>
                    <th>Credits</th>
                    {{-- <th>Balance</th> --}}
                    
                </thead>
                <tbody>
                @if(isset($statements_bonds))
                    @foreach($statements_bonds as $statement)
                    <tr>
                        <td data-label="Transaction Date">{{\Carbon\Carbon::parse($statement->PostDate)->toFormattedDateString()}}</td>
                        <td data-label="Value Date">{{\Carbon\Carbon::parse($statement->ValueDate)->toFormattedDateString()}}</td>
                        <td data-label="Narration">{{$statement->Narration}}</td>
                        <td data-label="Debits">{{number_format($statement->Debit,2) }}</td>
                        <td data-label="Credits">{{number_format($statement->Credit,2) }}</td>
                        {{-- <td>{{number_format($statement->Balance,2) }}</td> --}}
                        
                    </tr>
                    @endforeach
                @endif
                </tbody>
               <tfoot style="font-weight: bold; color: #f6a821;">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($bonds_debit_total, 2) }}</td>
                        <td>{{ number_format($bonds_credit_total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
                </div>
            </div>
        </div>


        <div class="panel panel-filled panel-c-info panel-collapse">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                    {{-- <a class="panel-close"><i class="fa fa-times"></i></a> --}}
                </div>
                <span class="details">
                    <b>Treasury Bills</b>
                </span>
                <div class="pull-right">
                    <span class="details">
                        <strong>Book Balance: &nbsp;<b class="text-success">{{ number_format(auth()->user()->gls->where('AccountTypeID', 3)->sum('BookBalance'), 2) }}</b></strong>
                    </span>    

                    <span class="details">
                        <strong>Available Balance: &nbsp; 
                        <b class="text-success">{{ number_format(auth()->user()->gls->where('AccountTypeID', 3)->sum('ClearedBalance'), 2) }}</b>
                        </strong>
                    </span>
                </div>
            </div>
            <div class="panel-body">
                <table class="table datatable">
                <thead>
                    <th>Transaction Date</th>
                    <th>Value Date</th>
                    <th>Naration</th>
                    <th>Debits</th>
                    <th>Credits</th>
                    {{-- <th>Balance</th> --}}
                    
                </thead>
                <tbody>
                @if(isset($statements_tbills))
                    @foreach($statements_tbills as $statement)
                    <tr>
                        <td data-label="Transaction Date">{{\Carbon\Carbon::parse($statement->PostDate)->toFormattedDateString()}}</td>
                        <td data-label="Value Date">{{\Carbon\Carbon::parse($statement->ValueDate)->toFormattedDateString()}}</td>
                        <td data-label="Narration">{{$statement->Narration}}</td>
                        <td data-label="Debits">{{number_format($statement->Debit,2) }}</td>
                        <td data-label="Credits">{{number_format($statement->Credit,2) }}</td>
                        {{-- <td>{{number_format($statement->Balance,2) }}</td> --}}
                        
                    </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot style="font-weight: bold; color: #f6a821;">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($tbills_debit_total, 2) }}</td>
                        <td>{{ number_format($tbills_credit_total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>


</div>      
@endsection



    @push('scripts')
{{-- <script src="{{ asset('js/jquery.tabledit.js') }}"></script> --}}
<script>
    $('#cash_dep_table').DataTable();
</script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    // requery
    $('.requery-btn').click(function(e) {
        e.preventDefault();
        // alert('clicked')
        var _that = $(this);
        var button_text = $(this).text();
            $.ajax({
                url: '{{ url('/deposits/payment/query') }}',
                type: 'POST',
                data: {
                    id: $(this).data('id'),
                    cpay_ref: $(this).data('cpay'),
                    transaction_id: $(this).data('trans'),
                },
                beforeSend: function(){
                    _that.text('Processing...');
                }
            })
            .done(function(data) {
                console.log(data);
                toastr.info(data.ResponseDesc);
                _that.text(button_text);
            })
            .fail(function(error) {
                console.log(error);
                toastr.info('Your request can\'t be processed this time. Please try again later');
                _that.text(button_text);
            })
            .always(function() {
                console.log("complete");
                _that.text(button_text);
            });
    });
    
    $('.data').DataTable();
  
var table = $('.transactions').DataTable({
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
 

 $('.back-btn').click(function(e){
window.history.back();
 });

//  $.fn.DataTable.ext.search.push(
//     function( settings, data, dataIndex ) {
//         var filter = parseInt( $('#filter').val(),  );
//         var narration = parseFloat( data[2] ) || 0; // use data for the age column
 

//         if (narration != '') {
//             return true;
//         }
//         return false;
//     }
// );

 var tablex = $(".datatablew").DataTable();
 $("#filter").keyup(function(e) {
     e.preventDefault();
     tablex.draw();
 });

  // });
</script>
@endpush
