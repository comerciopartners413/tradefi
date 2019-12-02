@extends('layouts.app')

@section('title')
  Approve Price Upload
@endsection

@section('content')
  <style>
    .actionBtn {
      margin: 20px 0;
    }
    .actionBtn button {
      margin-right: 10px
    }
  </style>

  <div class="view-header">
    <div class="header-icon">
        <i class="pe page-header-icon pe-7s-check"></i>
    </div>
    <div class="header-title">
      <h3>Approve Price Upload</h3>
      <small>
        Approve uploaded data.
      </small>
    </div>
  </div>

  <div class="panel panel-filled">
    <div class="panel-heading">
      <h3 class="panel-title">Approve Price Upload</h3>
    </div>
    <div class="panel-body">

      @if (count($staging) > 0)
        <div class="pull-right">
          {{-- <a href="{{ url()->current() }}" class="btn btn-danger btn-lg">Cancel</a> --}}
          
        </div>

        <div class="actionBtn">
          <div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 20px;text-align: center;">
            <input type="checkbox" id="select-all">
            <label for="select-all" class="text-white">Select all </label>
          </div>
          <button class="approve-btn btn btn-sm btn-success">Approve selected</button>
          {{-- <button class="reject-btn btn btn-sm btn-danger">Reject</button> --}}

          {{-- <button class="btn btn-success btn-sm" style="margin-left: 15px" onclick="confirm2('Are you sure you want to approve this data?', '', 'approve_upload')">Approve All</button>
          <form class="hidden" id="approve_upload" action="{{ route('price_upload.post_first_approval') }}" method="post" onsubmit="$('#spinner').show()">
            {{ csrf_field() }}
          </form> --}}
        </div>
      @endif
      <div class="clearfix"></div>
      <table class="table table-bordered">
        <thead>
          <th></th>
          <th width="5%">Ref</th>
          {{-- <th width="15%">Maturity Date</th> --}}
          <th width="15%">Identifier</th>
          <th width="15%">Tenor To Maturity</th>
          <th width="15%">Amount Available</th>
          <th>Buy Yield</th>
          <th>Sell Yield</th>
          <th>Initiator</th>
          <th>Upload Date</th>
        </thead>

        <tbody>
          @foreach ($staging as $stage)
            <tr>
              <td>
                <div class="checkbox check-info">
                  <input type="checkbox" id="select-all-child-{{ $stage->PriceUploadRef }}" class="select-all-child" value="{{ $stage->PriceUploadRef }}">
                  <label for="select-all-child-{{ $stage->PriceUploadRef }}" class="text-white"></label>
                </div>
              </td>
              <td>{{ $stage->PriceUploadRef }}</td>
              {{-- <td>{{ $stage->MaturityDate }}</td> --}}
              <td>{{ $stage->SecurityIdentifier }}</td>
              <td>{{ $stage->TenorToMaturity }}</td>
              <td>{{ number_format($stage->AmountAvailable, 2) }}</td>
              <td>{{ number_format($stage->BuyRate, 2) }}</td>
              <td>{{ number_format($stage->SellRate, 2) }}</td>
              <td>{{ $stage->initiator->username ?? '--' }}</td>
              <td>{{ $stage->created_at->format('jS M Y - g:iA') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>


    </div>
  </div>

@endsection

@push('scripts')
<script>
  $(function(){

    // add multiple select / deselect functionality
    $("#select-all").click(function () {
          $('.select-all-child').prop('checked', this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".select-all-child").click(function(){

        if($(".select-all-child").length == $(".select-all-child:checked").length) {
            $("#select-all").prop("checked", "checked");
        } else {
            $("#select-all").removeAttr("checked");
        }
    });

  });

// Approval button script
$('.approve-btn').click(function(e) {
 e.preventDefault();
 var checked_trades = $('.select-all-child:checked');
 var checked_trades_array = [];
 $.each(checked_trades, function(index, val) {
      checked_trades_array.push(parseInt($(val).prop('value')));
 });
 console.log(checked_trades_array)
 
 if(checked_trades_array.length > 0) {
   var confirm = window.confirm('Are You sure you want to approve the selected prices?');
   if(confirm){
      // var Comment = prompt("Enter Approval Comment");
      $.ajax({
          url: '/price_upload/first_approval_selected',
          type: 'POST',
          data: {
              _token: '{{ csrf_token() }}',
              selected_ids: checked_trades_array,
              // ModuleID: 36,
              // Comment: Comment
          },
      })
      .done(function(res, status, xhr) {
          // Navigate to the list after succesful posting to the server
          if(xhr.status == 200) {
              toastr.success('The selected prices were approved successfully')
              setTimeout(function(){
                  window.location.href  = "{{ route('price_upload.history') }}";
              }, 1000)
              
          } else {
              toastr.error('approval failed');
              return false
          }
          
      })
      .fail(function() {
          console.log("error");
      });
    }
  }
  else if(checked_trades_array.length == 0){
    toastr.info('Nothing selected');
  }
 
 
});
</script>
@endpush