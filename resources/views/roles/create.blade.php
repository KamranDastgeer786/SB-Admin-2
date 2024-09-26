@extends('layouts.app')
@section('page-title', 'Role')
@if (isset($role))
    @section('sub-page-title', 'Update Role')
@else
  @section('sub-page-title', 'Add Role')
@endif
@section('content')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
        <div class="col-lg-7">
            <div class="p-5">
               
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"> {{ isset($role) ? 'Update Role' : 'Add Role' }} </h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <form class="user" id="roleForm" action="{{ isset($role) ? route('roles.update', ['role' => $role->id]) : route('roles.store') }}" method="POST">

                    @csrf

                    @if (isset($role))
                      @method('PUT')
                    @endif


                    <div class="form-group">
                        <label for="exampleInputEmail1">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" name="name" id="name" value="{{ $role->name ?? '' }}" required placeholder="Type Role Name...">
                    </div>

                    
                        <label for="permissions" class="form-label">Permissions <span class="text-danger">*</span></label>
                        <div class="table-responsive" >
                            <table class="table table-bordered" id="example" >
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th>Create</th>
                                        <th>Show </th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    @foreach($permissions as $index => $permissionGroup)
                                    <tr>
                                        <td class="text-center">{{ implode(' ', array_map('ucfirst', explode('_', $index))) }}</td>
                                        <td>
                                            {{-- @dd($permissionGroup) --}}

                                            @if (checkPermission($permissionGroup, 'create_' . $index))
                                                <div class="form-check text-center">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="create_{{ ($index) }}" {{ isset($role) && $role->hasPermissionTo('create_' . ($index)) ? 'checked' : '' }} style="margin-left: -20px;" >
                                                </div>
                                            @else
                                                <div class="form-check text-center">-</div>
                                            @endif

                                        </td>

                                        <td>

                                            @if (checkPermission($permissionGroup, 'show_' .($index)))
                                                <div class="form-check text-center">
                                                   <input class="form-check-input" type="checkbox" name="permissions[]" value="show_{{ ($index) }}" {{ isset($role) && $role->hasPermissionTo('show_' . ($index)) ? 'checked' : '' }} style="margin-left: -20px;"  >
                                                </div>
                                            @else
                                                <div class="form-check text-center">-</div>
                                            @endif

                                        </td>

                                        <td>

                                            @if (checkPermission($permissionGroup, 'edit_' .($index)))
                                                <div class="form-check text-center">
                                                   <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_{{ ($index) }}" {{ isset($role) && $role->hasPermissionTo('edit_' . ($index)) ? 'checked' : '' }} style="margin-left: -20px;"  >
                                                </div>
                                            @else
                                                <div class="form-check text-center">-</div>
                                            @endif
                                            
                                        </td>

                                        <td>

                                            @if (checkPermission($permissionGroup, 'delete_' .($index)))
                                                <div class="form-check text-center">
                                                   <input class="form-check-input" type="checkbox" name="permissions[]" value="delete_{{ ($index) }}" {{ isset($role) && $role->hasPermissionTo('delete_' . ($index)) ? 'checked' : '' }} style="margin-left: -20px;"  >
                                                </div>
                                            @else
                                                <div class="form-check text-center">-</div>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary" style="padding-left: 40px;padding-right: 40px;">{{ isset($role) ? 'Update' : 'Save' }}</button>
                    
                </form>
                
            </div>
        </div>
    </div>
    <!-- Content Row -->
</div>
<!-- /.container-fluid -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
                $('#roleForm').on('submit', function(event) {
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
                                        '{{ route('roles.index') }}';
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

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js')}}"></script>

    @endpush

    


@endsection


