@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
    @endpush
@include('errors.list')
    <div class="row">
        <div class="col-sm-6">
                <div class="form-group">
                    <div class="controls">
                    {{ Form::label('TradeDate', 'Trade Date') }}
                    <div class="input-group date dp">
                     {{ Form::text('TradeDate', null, ['class' => 'form-control', 'placeholder' => 'Trade Date']) }}
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
                    {{ Form::hidden('ModifierID',auth()->user()->id) }}
                </div>
            </div>
        </div>
    </div>

    <!-- action buttons -->
    <div class="">
        <div class="pull-left">
                {{ Form::hidden('InputterID',auth()->user()->id) }}
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
                autoclose: true,
                format: 'yyyy-mm-dd'
            };
			$('.dp').datepicker(options);
		})
    </script>
    @endpush
</link>