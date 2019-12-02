@include('errors.list')
<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="controls">
						{{ Form::label('name', 'Name') }}
						{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name of Permission']) }}
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<div class="controls">
						{{ Form::label('display_name', 'Display Name') }}
						{{ Form::text('display_name', null, ['class' => 'form-control', 'placeholder' => 'Display Name']) }}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="controls">
				{{ Form::label('description', null) }}
				{{ Form::textarea('description',null, ['class' => 'form-control no-resize', 'rows' => '3',  'placeholder' => 'Enter description']) }}
			</div>
		</div> <br>

		<div class="row">
			<div class="pull-right">
				{{ Form::submit( $buttonText, [ 'class' => 'btn btn-warning ' ]) }}
				{{-- {{ Form::reset('reset fields',[ 'class' => 'btn btn-transparent ' ]) }} --}}
			</div>
		</div>