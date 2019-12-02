@extends('layouts.app')
@section('content')

<div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-drawer"></i>
                            </div>
                            <div class="header-title">
                                <h3>Manage Inventory</h3>
                                <small>
                               Register Quantity Provided by Stanbic.
                            </small>
                            </div>
                        </div>
                    </div>
                </div>
<div class="panel panel-filled">
	<div class="panel-heading">
		<div class="panel-title">
			Update Quantity 
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'Admin\InventoryController@store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		@include('inventory.form', ['buttonText' => 'Update Inventory and Send'])
		{{ Form::close() }}
	</div>
</div>

<section class="bg-white ">
	<div class="panel">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-buy" aria-expanded="false">Buy</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-sell" aria-expanded="false">Sell</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-rejected" aria-expanded="false">Unsent/Rejected</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-buy" class="tab-pane active">
                                    <div class="panel-body" style="padding: 20px 15px">
                                        <div class="table-responsive">

                    <table  class="table datatable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Security</th>
                            <th>Balance</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buy_inventory as $inventory)
								 <tr>
                                    <td>
                                        <button type="button" class="security-detail-btn btn btn-warning btn-sm" data-security-id="{{ $inventory->SecurityID }}">View Trail</button>
                                    </td>
		                        	<td>{{ $inventory->Security }}</td>
		                        	<td class="c-accent">{{ number_format($inventory->Quantity, 2) }}</td>
		                        	<td>{{ \Carbon\Carbon::parse($inventory->Date)->toFormattedDateString() }}</td>
		                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                                    </div>
                                </div>
                                <div id="tab-sell" class="tab-pane">
                                    <div class="panel-body" style="padding: 20px 15px">
                                        <div class="table-responsive">

                    <table  class="table datatable">
                    <thead>
                        <tr>
                            <th>Security</th>
                            <th>Balance</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sell_inventory as $inventory)
								 <tr>
		                        	<td>{{ $inventory->Security }}</td>
		                        	<td class="c-accent">{{ number_format($inventory->Quantity, 2) }}</td>
		                        	<td>{{ \Carbon\Carbon::parse($inventory->Date)->toFormattedDateString() }}</td>
		                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                                    </div>
                                 
                                </div>


                                <!-- Rejected -->

                                <div id="tab-rejected" class="tab-pane">
                                    <div class="panel-body" style="padding: 20px 15px">
                                        <div class="table-responsive">

                    <table  class="table datatable">
                    <thead>
                        <tr>
                            <th>Security</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unsent_inventory as $inventory)
                                 <tr>
                                    <td>{{ $inventory->Security->Description }}</td>
                                    <td class="c-accent">{{ number_format($inventory->Quantity, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inventory->Date)->toFormattedDateString() }}</td>
                                    <td>
                                        <form method="POST" action="/admin/inventory/send/{{ $inventory->InventoryRef }}">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button class="btn btn-sm btn-warning">Send</button>
                                        </form>
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
            });

            inv_modal.modal('show');
        });
    });
</script>
@endpush
