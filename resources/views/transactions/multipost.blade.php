@extends('layouts.app')

@section('title')

@endsection

@section('content')

  <style>
    .dp input {
      border-radius: 0px !important;
    }
    .table tbody tr td{
      padding-right: 10px;
    }
  </style>

  <div class="panel panel-filled">
    <div class="panel-heading">
      <h3 class="panel-title" style="width:100%">
        Post Transactions
        <div class="pull-right">
          Debit = <span id="debit" class="m-r-10">0</span>
          Credit = <span id="credit">0</span>
        </div>
      </h3>
    </div>
    <div class="panel-body">
      <form class="" action="{{ route('transactions.multipost.store') }}" method="post">
        {{ csrf_field() }}
        <table class="table">
          <thead>
            <tr>
              <th width="10%">Type</th>
              <th width="10%">Amount</th>
              <th width="22%">Account</th>
              <th width="13%">Post Date</th>
              <th width="12%">Value Date</th>
              <th width="10%">Bank Slip No.</th>
              <th width="13%">Narration</th>
            </tr>
          </thead>

          <tbody id="tx_rows">
            <tr>
              {{-- TYPE --}}
              <td>
                <select id="txtype" class="form-control select2" data-init-plugin="select2" name="type[]" required onchange="calc()">
                  <option value="">Select one</option>
                  <option value="3">Debit</option>
                  <option value="4">Credit</option>
                </select>
              </td>
              {{-- AMOUNT --}}
              <td>
                <input type="text" name="amount[]" class="form-control input-sm amount" value="" required onkeyup="calc()">
              </td>
              {{-- ACCOUNT --}}
              <td>
                <select class="form-control select2" data-init-plugin="select2" name="account[]" required>
                  <option value="">Select one</option>
                  @foreach ($accounts as $account)
                    <option value="{{ $account->GLRef }}">{{ $account->Account }}</option>
                  @endforeach
                </select>
              </td>
              {{-- POST DATE --}}
              <td>
                <div class="input-group date dp">
                  <input type="text" name="post_date[]" class="form-control input-sm" value="" required>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
              </td>
              {{-- VALUE DATE --}}
              <td>
                <div class="input-group date dp">
                  <input type="text" name="value_date[]" class="form-control input-sm" value="" required>
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
              </td>
              {{-- STAFF --}}
              {{-- BANK SLIP NO --}}
              <td>
                <input type="text" name="slip_no[]" class="form-control" value="">
              </td>
              {{-- NARRATION --}}
              <td>
                <input type="text" name="narration[]" class="form-control" value="" required>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td id="balance_error" colspan="8" class="text-danger text-center"><i class="fa fa-times m-r-5"></i>Debit and Credit amounts must balance.</td>
              <td id="balance_ok" colspan="8" class="text-success text-center" style="display:none"><i class="fa fa-check m-r-5"></i>Debit and Credit amounts are balanced.</td>
            </tr>
          </tfoot>

        </table>
        <div class="pull-right">
          <div id="add_row" class="btn btn-info">+ Add Row</div>
          <input id="submit_btn" type="submit" class="btn btn-success btn-cons m-l-10" value="Submit" disabled>
        </div>
      </form>
    </div>
  </div> <br><br>

  <h4>Reversal Report</h4>
  <div class="panel panel-filled">
    <div class="panel-body">
      <table class="table datatable">
      <thead>
        <th>Post Date</th>
        <th>Value Date</th>
        <th>Username</th>
        <th>Amount</th>
        
        <th>Narration</th>
      </thead>

      <tbody>
        @foreach($revs as $rev)
        <tr>
          <td>{{ \Carbon\Carbon::parse($rev->PostDate)->toFormattedDateString() }}</td>
           <td>{{ \Carbon\Carbon::parse($rev->ValueDate)->toFormattedDateString() }}</td>
          <td>{{ $rev->Username }}</td>
          <td>{{ number_format($rev->Amount, 2) }}</td>
          <td>{{ $rev->Narration }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
  </div>
@endsection

@push('scripts')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js') }}"></script>

  <script>
  var amounts = $('.amount');
  // $(document).on('keyup', '.amount', function(){

  function calc(){
    var credit = 0;
    var debit = 0;
    $('.amount').each(function(){
      // console.log($(this).parent().siblings('td').children('#txtype').val());
      if($(this).parent().siblings('td').children('#txtype').val() == '3')
        debit += parseInt($(this).val());
      if($(this).parent().siblings('td').children('#txtype').val() == '4')
        credit += parseInt($(this).val());
      // console.log($(this).val());
    });
    $('#debit').text(debit);
    $('#credit').text(credit);
    // console.log(parseInt(credit - debit));
    if (parseInt(credit) != parseInt(debit)) {
      $('#submit_btn').attr('disabled', true);
      $('#balance_error').show();
      $('#balance_ok').hide();
    } else {
      $('#submit_btn').removeAttr('disabled');
      $('#balance_error').hide();
      $('#balance_ok').show();
    }
  };
  </script>

  <script>
  $(document).ready(function () {
    // DATE PICKER
    var options = {
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
    };
     $('.dp').datepicker(options);

    // Add Row
    $("#add_row").click(function (e) {
      // var clone = $('#tx_rows tr').last().clone();
      // clone.find('input').val('');
      $('#tx_rows')
      // .append(clone);

      .append(
        `
        <tr>
          {{-- TYPE --}}
          <td>
            <select id="txtype" class="new_select form-control select2" data-init-plugin="select2" name="type[]" required onchange="calc()">
              <option value="">Select one</option>
              <option value="3">Debit</option>
              <option value="4">Credit</option>
            </select>
          </td>
          {{-- AMOUNT --}}
          <td>
            <input type="text" name="amount[]" class="form-control input-sm amount" value="" required  onkeyup="calc()">
          </td>
          {{-- ACCOUNT --}}
          <td>
            <select class="new_select form-control select2" data-init-plugin="select2" name="account[]" required>
              <option value="">Select one</option>
              @foreach ($accounts as $account)
                <option value="{{ $account->GLRef }}">{{ $account->Account }}</option>
              @endforeach
            </select>
          </td>
          {{-- POST DATE --}}
          <td>
            <div class="new_date input-group date dp">
              <input type="text" name="post_date[]" class="form-control input-sm" value="" required>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </td>
          {{-- VALUE DATE --}}
          <td>
            <div class="new_date input-group date dp">
              <input type="text" name="value_date[]" class="form-control input-sm" value="" required>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </td>
          {{-- STAFF --}}
          {{-- BANK SLIP NO --}}
          <td>
            <input type="text" name="slip_no[]" class="form-control" value="">
          </td>
          {{-- NARRATION --}}
          <td>
            <input type="text" name="narration[]" class="form-control" value="" required>
          </td>
        </tr>
        `
      );

      $('.new_select').select2();
      $('.new_date').datepicker(options);

      $('.new_select').removeClass('new_select');
      $('.new_date').removeClass('new_date');

      // var fact_num = $("#facts div").length;
      // var fact_max = 9;
      // if (fact_num <= fact_max) {
      //   $("#facts").append('<div class="mb10 input-group"><input name="facts[]" type="text" class="form-control" placeholder="Fact or accomplishment"><span class="input-group-btn"><button class="delete btn btn-danger">Delete</button></span></div>');
      // } else if(fact_num == fact_max + 1) {
      //   $("#facts").append('<div class="mb10 text-danger">Limit '+ (fact_max+1) +' reached. You can add more from the edit page later.</div>');
      // }

    });
    // Delete
    $("body").on("click", ".delete", function (e) {
      $(this).closest("tr").remove();
    });

  });
</script>
@endpush
