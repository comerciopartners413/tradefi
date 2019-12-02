@extends('layouts.app')

@section('title')
  Messages - Compose
@endsection

@section('page-title')
  Messages - Compose
@endsection

@section('content')

  <div class="row">
    @include('messages.menu', ['active' => 'compose'])
    <div class="col-sm-8 col-md-9 inbox-content">

      <form action="{{ route('send_message') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="panel panel-filled panel-body">
          <div class="row clearfix">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>TO:</label>
                <select name="to[]" data-init-plugin="select2" class="select2_demo_1 form-control" multiple required>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            {{-- <div class="col-md-6">
              <div class="form-group form-group-default">
              <label>CC:</label>
              <input type="text" class="form-control" name="cc" placeholder="Add Carbon Copy">
            </div>
          </div> --}}
          </div>
          <div class="form-group form-group-default">
            <label>Subject</label>
            <a class="pull-right toggle_icon" data-toggle="modal" data-target="#new_subject"> <i class="fa fa-plus-circle text-success" data-toggle="tooltip" title="Add new subject"></i> </a>
            @if (!empty($forward))
              <input type="text" class="form-control" name="Subject" required value="{{ 'FW: '.$forward->Subject }}">
            @else
              <select name="Subject" data-init-plugin="select2" class="form-control" required>
                <option value="">Select Subject</option>
                @foreach ($subjects as $subject)
                  <option value="{{ $subject->MessageSubject }}">{{ $subject->MessageSubject }}</option>
                @endforeach
              </select>
            @endif
          </div>
          <div class="form-group form-group-default">
            <label>Message</label>
            <textarea class="summernote" name="Body" placeholder="Enter your message here.">
              {{ old('Body') }}
              @if (!empty($forward))
                <br/>
                <br/>
                <div style="background-color:#eee;padding:7px;border-radius:5px">
                  ---------- Forwarded message ---------<br/>
                  <div class="small">
                    From: <b>{{ $forward->sender->FullName }}</b><br/>
                    Date: {{ $forward->created_at->format('jS M, Y') }} at {{ $forward->created_at->format('g:ia') }}<br/>
                    Subject: <b>{{ $forward->Subject }}</b><br/>
                    To: {{ implode(', ', $forward->recipients->pluck('FullName')->toArray()) }}<br/>
                  </div>
                  <br/>
                  <div class="f14">{{ $forward->Body }}</div>
                  @foreach ($forward->replies->sortBy('created_at') as $reply)
                    ---------------------------------------
                    <div class="small">
                      Reply: <b>{{ $reply->sender->FullName }}</b> on {{ $reply->created_at->format('jS M, Y') }} at {{ $reply->created_at->format('g:ia') }}<br/>
                    </div>
                    <br/>
                    <div class="f14">{{ $reply->Body }}</div>
                  @endforeach
                </div>
              @endif
            </textarea>
          </div>

            <div class="form-group form-group-default">

              {{-- Attached Files --}}
              <ul class="my-list" id="files">
              </ul>

              {{-- End Attached Files --}}

              <div class="clearfix m-t-30 m-b-20">
                <div class="pull-left btn btn-info m-t-10" id="add_file">
                  <i class="fa fa-plus m-r-5"></i> Attach File
                </div>
                <button type="submit" class="pull-right btn btn-lg btn-success"><i class="fa fa-paper-plane m-r-5"></i> Send</button>
              </div>

            </div>

        </div>

      </form>

    </div>
  </div>


  {{-- New Subject Modal --}}
  <div class="modal fade stick-up" id="new_subject" role="dialog" aria-hidden="false">
    <div class="modal-dialog" style="width:400px">
      <div class="modal-content-wrapper">
        <div class="modal-content">
          {{-- <div class="modal-header clearfix text-left">
            
          </div> --}}
          <div class="modal-body">
            <div class="pull-right"><a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded close-btn">×</a></div>
            <h5>Create New Subject</h5>
            <hr>

            <form action="{{ route('store_subject') }}" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Subject Title</label>
                    <input type="text" name="MessageSubject" class="form-control" placeholder="Enter the subject title" required>
                  </div>
                </div>
              </div>
              <input type="submit" class="btn btn-success btn-form" value="Save">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  

@endsection

@push('scripts')
  {{-- Append Files --}}
  <script>
    var files = $('#files');
    $('#add_file').on('click', function(){
      files.append(`
        <li class="row m-t-5 clearfix">
          <input type="file" class="form-control pull-left m-t-5" name="MessageFiles[]" value="" style="width:90%">
          <i class="fa fa-times-circle text-danger delete cursor_pointer" style="font-size:22px;float: right"></i>
        </li>
        `);
    });


    $("body").on("click", ".delete", function (e) {
      if (confirm('Remove this file?'))
        // $(this).closest(".row").fadeOut(300).remove();
        $(this).closest(".row").fadeOut(700, function(){
          $(this).remove();
        });
    });

    // Create New Subject
    $('#new_subject form').submit(function(e){
			e.preventDefault();
			e.stopPropagation();
			$('#new_subject .close-btn').click();
			$.post('{{ route('store_subject') }}', $('#new_subject form').serialize(), function(data, status){
				$('select[name=Subject]').append(`<option value="${data.MessageSubject}">${data.MessageSubject}</option>`);
        // showNotification('simple', 'The subject: '+data.MessageSubject+' was added successfully', 'top-right', 9000, 'success');
        toastr.success('The subject: '+data.MessageSubject+' was added successfully');
      })
      .fail(function(data){
        // showNotification('simple', 'The subject could not be created.', 'top-right', 9000, 'danger');
        toastr.error('The subject could not be created.');
      });
		});

    $(document).ready(function(){
      
      $('.summernote').summernote({
          height: '100px',
          placeholder: '',
          toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            // ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['misc', ['undo', 'redo']],
          ],
          dialogsInBody: true,
        });
    });


    $('[name=Subject]').on('change', function(){
      let subject = $(this).val();
      console.log(subject);
      
      if (subject.toLowerCase() == 'price upload') {
        $('[name=Body]').summernote('insertText', subject[0].toUpperCase() + subject.substr(1));
        subject = subject.toLowerCase();
        // $('.note-editor .note-editable').html( subject[0].toUpperCase() + subject.substr(1) ).trigger('change');
      }
    })
  </script>
@endpush
