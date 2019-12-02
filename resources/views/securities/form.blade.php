@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
    @endpush
@include('errors.list')
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('Security', 'Security Name') }}
						{{ Form::text('Security', null, ['class' => 'form-control', 'placeholder' => 'Enter Security Name']) }}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('Description') }}
                        {{ Form::text('Description', null, ['class' => 'form-control', 'placeholder' => 'Describe Security']) }}
                </div>
            </div>
        </div>

        </div>
{{-- /row --}}

        <div class="row">

        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('MaturityDate', 'Maturity Date') }}
                    <div class="input-group date dp">
                        {{ Form::text('MaturityDate', null, ['class' => 'form-control', 'placeholder' => 'Maturity Date']) }}
                        <span class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        <div class="form-group">
                <div class="controls">
                    {{ Form::label('IssueDate','Issue Date') }}
                    <div class="input-group date dp">
                        {{ Form::text('IssueDate', null, ['class' => 'form-control', 'placeholder' => 'Issue Date']) }}
                        <span class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </span>
                    </div>
                </div>
            </div>
           
        </div>
        </div>
        {{-- /row --}}

        <div class="row">
        
            <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('Product') }}
                    {{ Form::select('ProductID', $products->pluck('Product','ProductRef') ,null, ['class' => 'full-width form-control','data-init-plugin' => "select2", 'data-placeholder' => 'Choose Product']) }}
                </div>
            </div>
        </div>
        <div class="when-tbills-is-selected">
        <div class="col-sm-6">
             <div class="form-group">
                <div class="controls">
                    {{ Form::label('CouponRate','Coupon Rate (%)') }}
                    {{ Form::text('CouponRate', null, ['class' => 'form-control', 'placeholder' => 'Enter Coupon Rate' ]) }}
                </div>
            </div>
        </div>
        </div>
    </div>

    {{-- <div class="row"> --}}
        {{-- <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('TransFee') }}
                    {{ Form::text('TransFee', null, ['class' => 'form-control', 'placeholder' => 'Enter TransFee']) }}
                </div>
            </div>
        </div> --}}
    {{-- </div> --}}
<div class="when-tbills-is-selected">
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('Coupon Frequency') }}
                    {{ Form::select('Frequency', $frequencies->pluck('Frequency','FrequencyRef') ,null, ['class' => 'form-control full-width','data-init-plugin' => "select2", 'data-placeholder' => 'Choose Frequency']) }}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('DayBasisID','Day Basis') }}
                    {{ Form::select('DayBasisID', $day_basis->pluck('DayBasis','DayBasisRef') ,null, ['class' => 'form-control full-width','data-init-plugin' => "select2", 'data-placeholder' => 'Choose DayBasisID']) }}
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="when-tbills-is-selected">
            <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('Redemption') }}
                    {{ Form::text('Redemption', null, ['class' => 'form-control', 'placeholder' => 'Enter Redemption']) }}
                </div>
            </div>
        </div>
        </div>
        <div class="checkbox check-info col-sm-6 m-t-30">
                        {{ Form::hidden('BenchMarkFlag',0) }}
                      {{ Form::checkbox('BenchMarkFlag', true, null, ['id'=>'BenchMarkFlag']) }}
                      {{ Form::label('BenchMarkFlag', 'Benchmark',['class' => 'text-white']) }}
                    </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('SecuritiesIdentifier') }}
                    {{ Form::text('SecuritiesIdentifier', null, ['class' => 'form-control', 'placeholder' => 'Enter Identifier']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('Comment') }}
                    {{ Form::textarea('Comment' ,null, ['class' => 'form-control', 'rows' => 3]) }}
                </div>
            </div>
        </div>
    </div>
    <!-- action buttons -->
    <div class="row">
        <div class="pull-right">
                {{ Form::hidden('InputterID', auth()->user()->id) }}
                {{ Form::hidden('ModifierID', auth()->user()->id) }}
            {{ Form::submit( $buttonText, [ 'class' => 'btn btn-warning ' ]) }}
				{{-- {{ Form::reset('reset fields',[ 'class' => 'btn btn-transparent ' ]) }} --}}
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>
    <script>
        $(function(){
			$('.dp').datepicker({
         todayHighlight: true,
         autoclose: true,
         format: 'yyyy-mm-dd'
     });


            var ProductID = $("[name=ProductID]");
            ProductID.change(function(e) {
                e.preventDefault();
                // alert('changed');
                var _that = $(this).prop('value');
                if(_that == 2){
                    console.log('TBills was selected');
                    $('.when-tbills-is-selected').hide();
                } else {
                    $('.when-tbills-is-selected').show();
                }
            });
		})
    </script>
    @endpush

