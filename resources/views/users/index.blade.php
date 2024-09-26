@extends('layouts.app')
@section('page-title', 'Users sign Role')
@section('content')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary breadcrumb float-sm-right" style="background-color: ghostwhite;">Show All Sign Roles user</h6>
            <a href="{{ route('users.create') }}" class="btn btn-primary"> ✙ Add User </a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="contactList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                
                    <tbody id="categoryTableBody">
                        @forelse ($users as $user)
                            <tr>

                                <td>
                                    <a href="" class="btn-link">{{ $user->id }}</a>
                                </td>

                                <td>
                                    <a href="" class="btn-link">{{ $user->name }}</a>
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>

                                <td>
                                    @forelse ($user->roles as $role)
                                        @if ($loop->last)
                                            {{ $role->name }}
                                        @else
                                            {{ $role->name }} ,
                                        @endif
        
                                        @empty                                
                                    @endforelse
                                </td> 

                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox"
                                            {{ $user->active ? 'checked' : '' }} data-user-id="{{ $user->id }}" style="margin-left: 5px;">
                                    </div>
                                </td>
                            
                                {{-- <td>
                                    <div class=" form-group form-check form-switch">
                                        <input class="form-check-input" type="checkbox" {{ $user->active ? 'checked' : '' }} data-user-id="{{ $user->id }}"  style="margin-left: 10px;" >
                                    </div>
                                </td> --}}

                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm" style="width: 74px; margin-left: 40px;">
                                        <i class="fa fa-code"></i>
                                        Edit
                                    </a>
                                </td>

                            <td>


                                <a onclick="deleteUser('{{ route('users.destroy', $user->id) }}')" class="btn btn-danger btn-sm" style="width: 77px; margin-left: 40px;"> 
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No User Found.</td>
                        </tr>    
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var checkedIds = [];

    function updateCheckedIds() {
        checkedIds = [];
        $('.mass-action-checkbox:checked').each(function() {
        checkedIds.push($(this).val());
      });
    }

    $('.status-toggle').change(function() {
        var userId = $(this).data('user-id');
            
        var newActiveStatus = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('users.update-active-status') }}',
            method: 'POST',
            data: {
                id: userId,
                activeStatus: newActiveStatus
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Updated!',
                        response.message,
                        'success'
                    );
                },
                error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'Failed To Update Active Status.',
                    'error'
                    ).then(() => {
                    location.reload();
                });
            }
        });

    });


    function deleteUser(slug) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover deleted items!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: slug,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        }
</script>

@push('scripts')
   <!-- Page level plugins -->
   <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
   <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

   <!-- Page level custom scripts -->
   <script src="{{ asset('js/demo/datatables-demo.js')}}"></script>
@endpush
@endsection


