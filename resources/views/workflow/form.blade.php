@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
    @endpush
@include('errors.list')
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('RequesterID', 'Initiator') }}
                    {{ Form::select('RequesterID', $roles->pluck('display_name','id')->except([1]) ,null, ['class' => 'full-width form-control select2_demo_1','data-init-plugin' => "select2", 'data-placeholder' => 'Select Staff']) }}
                </div>
            </div>
        </div> 

<div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('ModuleID', 'Module') }}
                    {{ Form::select('ModuleID', 
                        [
                                0   => 'Select Module',
                                '36' => 'Deposits',
                                '37' => 'Withdrawal',
                                '38' => 'Bond Custody Fees',
                                '2' => 'Securities',
                                '3' => 'Role Management',
                                '4' => 'Inventory Management',
                                '5' => 'Direct Deposit',
                        ], 
                    null, ['data-init-plugin' => 'select2', 'class' => 'full-width form-control select2_demo_1', 'required']) }}
                </div>
            </div>
        </div>

        
    </div>
<hr>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('ApproverID1', 'Approver 1') }}
                    {{ Form::select('ApproverID1', [0 => 'Select Approver'] + $roles->pluck('display_name','id')->toArray() ,null, ['class' => 'full-width form-control select2_demo_1','data-init-plugin' => "select2", 'data-placeholder' => 'Select Approver']) }}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('ApproverID2', 'Approver 2') }}
                    {{ Form::select('ApproverID2', [0 => 'Select Approver'] + $roles->pluck('display_name','id')->toArray() ,null, ['class' => 'full-width form-control select2_demo_1','data-init-plugin' => "select2", 'data-placeholder' => 'Select Approver']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('ApproverID3', 'Approver 3') }}
                    {{ Form::select('ApproverID3', [0 => 'Select Approver'] + $roles->pluck('display_name','id')->toArray() ,null, ['class' => 'full-width form-control select2_demo_1','data-init-plugin' => "select2", 'data-placeholder' => 'Select Approver']) }}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <div class="controls">
                    {{ Form::label('ApproverID4', 'Approver 4') }}
                    {{ Form::select('ApproverID4', [0 => 'Select Approver'] + $roles->pluck('display_name','id')->toArray() ,null, ['class' => 'full-width form-control select2_demo_1','data-init-plugin' => "select2", 'data-placeholder' => 'Select Approver']) }}
                </div>
            </div>
        </div>
    </div>

    <!-- action buttons -->
    <div class="row">
        <div class="pull-right">
            {{ Form::submit( $buttonText, [ 'class' => 'btn btn-warning ' ]) }}
				{{-- {{ Form::reset('reset fields',[ 'class' => 'btn btn-transparent ' ]) }} --}}
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>
    <script>
        $(function(){
			$('.dp').datepicker();
		})        
    </script>
    @endpush
</link>