@include('errors.list')
<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="controls">
						{{ Form::label('name', 'Name') }}
						{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name of Role']) }}
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

		<div class="row">

          {{-- @if (auth()->user()->company_id == '1')
            <div class="col-sm-6 form-group">
                <label for="">Company</label>
                <select name="company_id"  class="form-control">
                  <option value="">Select company</option>
                  @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @if(isset($role)) {{ ($role->company_id == $company->id)? "selected" : null }} @endif>{{ strtoupper($company->name) }}</option>
                  @endforeach
                </select>
            </div>
          @endif --}}


          <div class="col-sm-6 form-group">
              <label for="">Menus</label>
              <select name="menus[]"  class="form-control select2_demo_1" multiple id="menus">
                  @foreach($menus as $menu)
                      <option value="{{ $menu->id }}" @if(isset($role_menus)){{in_array($menu->id, $role_menus->pluck('id')->toArray()) ? "selected" : null}}@endif>{{ $menu->name }}</option>
                  @endforeach
              </select>
          </div>


          @if (auth()->user()->company_id == '1')
            <div class="col-sm-6 form-group">
                <label for="">Permissions</label>
                <select name="permission[]"  class="form-control select2_demo_1" multiple id="permission">
                    @foreach($permissions as $perm)
                        <option value="{{ $perm->id }}" @if(isset($permission)){{in_array($perm->id, $permission->pluck('id')->toArray()) ? "selected" : null}}@endif>{{ $perm->display_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="col-sm-6 form-group">
                <label for="">Company</label>
                <select name="company_id"  class="form-control">
                  <option value="">Select company</option>
                  @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @if(isset($role)) {{ ($role->company_id == $company->id)? "selected" : null }} @endif>{{ strtoupper($company->name) }}</option>
                  @endforeach
                </select>
            </div> --}}
          @endif

                            

                            <div class="clearfix"></div>
                        </div>

                        <hr>

		<div class="form-group">
			<div class="controls">
				{{ Form::label('description', null) }}
				{{ Form::textarea('description',null, ['class' => 'form-control no-resize', 'rows' => '3',  'placeholder' => 'Enter description']) }}
			</div>
		</div> <br>

		<div class="row">
			<div class="pull-right">
				{{ Form::submit( $buttonText, [ 'class' => 'btn btn-warning ' ]) }}
			</div>
		</div>