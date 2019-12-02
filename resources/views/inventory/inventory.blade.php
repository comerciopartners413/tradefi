@extends('layouts.app')

@section('content')

@push('styles')
  <style>
    tr.today-bg {
      background: #23252a !important;
    }
  </style>
@endpush


<div class="view-header">
  <div class="header-icon">
      <i class="pe page-header-icon pe-7s-drawer"></i>
  </div>
  <div class="header-title">
      <h3>Inventory</h3>
      <small>
        Inventory Quantity Provided by UBA.
      </small>
  </div>
</div>

<section class="bg-white ">
	<div class="panel">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-today" aria-expanded="false">TODAY</a></li>
        <li class=""><a data-toggle="tab" href="#tab-history" aria-expanded="false">HISTORY</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-today" class="tab-pane active">
            <div class="panel-body" style="padding: 20px 15px">
                <div class="table-responsive">

                    <table  class="table datatable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Security</th>
                            <th>Buy Balance</th>
                            <th>Sell Balance</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory_list->where('Date', date('Y-m-d')) as $inv)
								            <tr>
                              <td>
                                  <button type="button" class="security-detail-btn btn btn-warning btn-sm" data-security-id="{{ $inv->SecurityID }}">View Trail</button>
                              </td>
		                        	<td>{{ $inv->Security }}</td>
		                        	<td class="c-accent">{{ ($inv->BuyQuantity)? number_format($inv->BuyQuantity, 2) : '0' }}</td>
		                        	<td class="c-accent">{{ ($inv->SellQuantity)? number_format($inv->SellQuantity, 2) : '0' }}</td>
		                        	<td>{{ \Carbon\Carbon::parse($inv->Date)->toFormattedDateString() }}</td>
		                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
              </div>
          </div>


          <div id="tab-history" class="tab-pane">
              <div class="panel-body" style="padding: 20px 15px">
                  <div class="table-responsive">

                    <table  class="table datatable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Security</th>
                            <th>Buy Balance</th>
                            <th>Sell Balance</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory_list->where('Date', '!=', date('Y-m-d')) as $inv)
								            <tr>
                              <td>
                                  <button type="button" class="security-detail-btn btn btn-warning btn-sm" data-security-id="{{ $inv->SecurityID }}">View Trail</button>
                              </td>
		                        	<td>{{ $inv->Security }}</td>
		                        	<td class="c-accent">{{ ($inv->BuyQuantity)? number_format($inv->BuyQuantity, 2) : '0' }}</td>
		                        	<td class="c-accent">{{ ($inv->SellQuantity)? number_format($inv->SellQuantity, 2) : '0' }}</td>
		                        	<td>{{ \Carbon\Carbon::parse($inv->Date)->toFormattedDateString() }}</td>
		                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
              </div>
            
          </div>

      </div>

  </div>

    <!-- modals -->
    <div class="modal fade" id="invModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title security-name"></h4>
                    <small>Showing details for security <span class="security-name"></span></small>
                </div>
                <div class="modal-body">
                    <table class="table dt">
                        <thead>
                            <th>Security</th>
                            <th>Volume</th>
                            <th>Transaction Type</th>
                            <th>Date </th>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-accent">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- end modals -->
	
</section>
@endsection


@push('scripts')
<script>
   $.ajaxSetup({
        headers: {
            'Access-Control-Allow-Headers': 'X-CSRF-Token',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }
    });
    
    $(function(){
        var inv_modal = $("#invModal");
        $('.security-detail-btn').click(function(e) {
            e.preventDefault();
            var table =  $('.dt').DataTable();
            var security_id = $(this).data('securityId');
            console.log(security_id);
            $.post('/admin/get-inventory', {SecurityID: security_id}, function(data, textStatus, xhr) {
                inv_modal.find('.modal-body').find('tbody').html(' ');
                $.each(data, function(index, val) {
                    inv_modal.find('.modal-body').find('tbody').append(`
                        <tr>
                            <td>${val.security.Description}</td>
                            <td>${accounting.formatNumber(val.Quantity)}</td>
                            <td>${val.transaction_type}</td>
                            <td>${val.deal_date}</td>
                        </tr>
                    `);
                });

                inv_modal.find('.security-name').html(data[0].security.Description);
                // inv_modal.
                table.reload();
                $('#spinner').hide();
            });

            inv_modal.modal('show');
        });
    });
</script>
@endpush
