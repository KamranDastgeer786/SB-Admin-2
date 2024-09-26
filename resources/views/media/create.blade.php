@extends('layouts.app')
@section('page-title', 'Media Upload')

@if (isset($media_upload))
    @section('sub-page-title', 'Update Media File ')
@else
  @section('sub-page-title', 'Upload New Media File')
@endif

@section('content')

{{-- @dd($media_upload) --}}

<div class="container-fluid">

    <div class="card w-70">
        <div class="card-header">
            <h5>{{ isset($media_upload) ? 'Update Media File' : 'Upload New Media File' }} </h5>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form id="mediaForm"  action="{{ isset($media_upload) ? route('media_uploads.update',['media_upload' => $media_upload->id]) : route('media_uploads.store') }}"  method="POST" enctype="multipart/form-data">
                
                @csrf
                @if(isset($media_upload))
                  @method('PUT')
                @endif
        
                <div class="form-group col-md-6">
                  <label for="file_name">File Name<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="file_name" id="file_name" value="{{ old('file_name', $media_upload->file_name ?? '') }}" placeholder="File Name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="file">Select File<span class="text-danger">*</span></label>
                  <input type="file" class="form-control" name="file" id="file"   placeholder="Select File" required>
                </div>
               
                <button type="submit" class="btn btn-primary" style="margin-left: 13px;">{{ isset($media_upload) ? 'Update Media' : 'Upload Media' }}</button>
            </form>
        </div>
    </div>  

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#mediaForm').on('submit', function(event) {
            // console.log('submit')
            event.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('media_uploads.index') }}';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessage += `${errors[field].join('\n')}\n`;
                        }
                    }

                    Swal.fire(
                        'Error!',
                        errorMessage,
                        'error'
                    );
                }
            });
        });
    });
</script>

@endsection