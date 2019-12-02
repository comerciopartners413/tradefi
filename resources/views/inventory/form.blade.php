@include('errors.list')
<div class="row">
			<div class="">
				<div class="form-group col-sm-6">
					<div class="controls">
						{{ Form::label('SecurityID', 'Security/Maturity') }}
						{{ Form::select('SecurityID', $securities->pluck('Description','SecurityRef') , null, ['class' => 'form-control select2_demo_1', 'placeholder' => 'Select Maturity']) }}
					</div>
				</div>
			</div>
			<div class="">
				<div class="form-group col-sm-6">
					<div class="controls">
						{{ Form::label('SecurityID', 'Buy/Sell') }}
						{{ Form::select('TransactionTypeID', $transaction_types->pluck('TransactionType','TransactionTypeRef') , null, ['class' => 'form-control select2_demo_1', 'placeholder' => 'Select Buy/Sell']) }}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="">
				<div class="form-group col-sm-6">
					<div class="controls">
						{{ Form::label('TransactionTypeID2', 'Deposit/Withdrawal') }}
						{{ Form::select('TransactionTypeID2', $transaction_types2->pluck('TransactionType','TransactionTypeRef')->toArray() + [ null => 'Choose a Type'] , null, ['class' => 'form-control select2_demo_1', 'placeholder' => 'Select Dep/With']) }}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="controls">
				{{ Form::label('Quantity', null) }}
				{{ Form::text('Quantity',null, ['class' => 'form-control',  'placeholder' => 'Enter Quantity']) }}
			</div>
		</div> <br>

		<div class="">
			<div class="pull-right">
				 {{ Form::hidden('InputterID', auth()->user()->id) }}
				{{ Form::submit( $buttonText, [ 'class' => 'btn btn-warning ' ]) }}
				{{-- {{ Form::reset('reset fields',[ 'class' => 'btn btn-transparent ' ]) }} --}}
			</div>
		</div>