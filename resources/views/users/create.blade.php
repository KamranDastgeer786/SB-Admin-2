@extends('layouts.app')
@section('page-title', 'Users')
@if (isset($user))
    @section('sub-page-title', 'Update User')
@else
  @section('sub-page-title', 'Add New User')
@endif
@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card w-70">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header">
            <h5 style="font-size: 22px; color: #5a5c81;">{{ isset($user) ? 'Update User' : 'Add New User' }}</h5>
            {{-- Add New User --}}
        </div>
        <div class="card-body">
            <form class="user" id="userForm" action="{{ isset($user) ? route('users.update', ['user' => $user->id]) : route('users.store') }}" method="POST"  style="padding-bottom: 40px">

                @csrf
                @if (isset($user))
                   @method('PUT')
                @endif

        
                <div class="form-group col-md-6">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ $user->name ?? '' }}" placeholder="type username ...">
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control"  name="email" id="email" value="{{ $user->email ?? '' }}" placeholder="type useremail ...">
                </div>

                <div class="form-group col-md-6">

                    <label for="Assign_Role">Assign Role</label>
                    <select class="form-control form-multi-select" id="ms1" name="roles[]" multiple data-coreui-search="true" style="width: 100%; height: 150px;">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ isset($user) && $user->hasRole($role) ? 'selected' : ''}} >
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- <input type="hidden" name="role_id" id="role_id" value=""> --}}
                </div>

                <div class="card card-body my-4 col-md-6" style="margin-left: 10px; width: 48%; border-color: #d6d8e5;">
                    <h4 class="font-16 mb-2">Status</h4>
                    <div class="form-group row my-1">
                        <label for="active" class="col-sm-4 font-14 bold black">Active
                            Status</label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                {{-- <input type="hidden" id="active" name="active" value="off"> --}}
                                <input class="form-check-input code-switcher" type="checkbox" name="active" {{ isset($user) && $user->active == true ? 'checked' : '' }} id="tables-small-showcode" {{ !isset($user) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="type password...">
                </div>

                <div class="form-group col-md-6">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="type Confirm Password...">
                </div>
                
                <button type="submit" class="btn btn-primary" style="margin-left: 13px;">{{ isset($user) ? 'Update User' : 'Add New User' }}</button>
            </form>
        </div>
    </div> 
</div>
<!-- /.container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for roles selection with search
        $('#ms1').select2({
            placeholder: "Select Roles",
            width: '100%',
            height: '150px',
            allowClear: true
        });

        // Handle the form submission with AJAX
        $('#userForm').on('submit', function(event) {
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
                            window.location.href =
                            '{{ route('users.index') }}';
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
                        errorMessage + '\n',
                        'error'
                    );
                }
            });
        });
    });
</script>

@push('scripts')
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endpush

   

@endsection


