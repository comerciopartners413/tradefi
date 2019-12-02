@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" href="{{ asset('webapp/vendor/summernote/dist/summernote.css') }}"/>
 <style>
 	.note-editor.panel-default .note-editing-area .note-editable {
    background-color: transparent;
    color: #949ba2;
}
 </style>
@endpush
@section('content')

<div class="container-fluid">
	<div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-hourglass"></i>
                        </div>
                        <div class="header-title">
                            <h3>Audit Trail</h3>
                            <small>
                                Audit reports for TradeFI modules
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            
                            <form method="post" action="{{ route('audits.store') }}">
                                {{ csrf_field() }}
                                <div class="form-group col-sm-6">
                                    <label>Select Module</label>
                                    <select name="module" class="form-control select2_demo_1">
                                        <!-- value name id Module's table name-->
                                        <option value="Inventory">Inventory</option>
                                        <option value="Security">Security</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="">&nbsp;</label>
                                    <button style="display: block" class="btn btn-warning">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div> <br><br>

            <div class="panel panel-filled">

                <div class="panel-body">
                    <h3></h3> <hr>
                    <div>
                    @if(session('module'))
                    <table class="table datatable">
                        <thead>
                            <th></th>
                            <th>Full Name</th>
                            <th></th>
                            <th></th>
                            <th>Date Created</th>
                            <th>Date Approved</th>
                        </thead>

                        <tbody>
                            @foreach(session('module') as $module)
                                <tr>
                                    <td></td>
                                    <td>{{ $module->fullname }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $module->created_at }}</td>
                                    <td>{{ $module->approved_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    @endif
                    </div>
                    
                </div>
            </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('webapp/vendor/summernote/dist/summernote.min.js') }}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script language="javascript">
$(function(){
	 $('.summernote').summernote();
});
</script>
@endpush
