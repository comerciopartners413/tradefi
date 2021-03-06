@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
<style>
    textarea {
        max-height: 50px;
        resize: none;
    }
</style>
@endpush
@include('errors.list')
<div class="row">

    {{-- varies on live --}}
     {{ Form::hidden('GLIDCredit',1166) }} 

    <div class="col-sm-6">
        <div class="form-group">
            {{ Form::label('GLIDDebit', 'Debit') }}
            <div class="controls">
                
                {{ Form::select('GLIDDebit', [ '' =>  'Select Customer Account'] + $customer_details->pluck('CUST_ACCT', 'GLRef')->toArray(),null, ['class'=> "full-width select2 select2_demo_1 form-control", 'data-init-plugin' => "select2"]) }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <div class="controls">
                {{ Form::label('Amount', 'Amount' ) }}
                {{ Form::text('Amount', null, ['class' => 'form-control', 'placeholder' => 'Enter Amount']) }}
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <div class="controls">
                {{ Form::label('ValueDate', 'Value Date') }}
                <div class="input-group date dp">
                    {{ Form::text('ValueDate', null, ['class' => 'form-control', 'placeholder' => 'Value Date']) }}
                    <span class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="controls">
                <label for="">Post Date</label>
                <input type="text" name="PostDate" value="{{ $configs->TradeDate }}" class="form-control" readonly="">
            </div>
        </div>
    </div>
</div>



<div class="row">

    <div class="col-sm-8">
        <div class="form-group">
            <div class="controls">
                {{ Form::label('Narration', 'Narration' ) }}
                {{ Form::textarea('Narration', null, ['class' => 'form-control', 'placeholder' => 'Enter Narration']) }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{ Form::hidden('PostingTypeID', 15, ['class' => 'form-control', 'placeholder' => 'Account Type']) }}

</div>

<div class="">
    <div class="pull-left">
        {{ Form::hidden('InputterID',auth()->user()->id) }}
        {{ Form::hidden('ModifierID',auth()->user()->id) }}
        {{ Form::submit( $buttonText, [ 'class' => 'btn btn-warning ' ]) }}
        {{-- {{ Form::reset('reset fields',[ 'class' => 'btn btn-transparent ' ]) }} --}}
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script>
    $(function(){
        var options = {
            todayHighlight: true,
            autoclose:true,
            format: 'yyyy-mm-dd'
        };
         $('.dp').datepicker({autoclose:true});

        var GLIDDebit = $("#GLIDDebit");
    GLIDDebit.change(function(event) {
        event.preventDefault();
        var GLID = $(this).prop('value');
        $.ajax({
            url: '/fetchAccountsForGL',
            type: 'POST',
            data: {GLID: GLID},
        })
        .done(function(data) {
            console.log(data);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    });
    })
</script>
@endpush
