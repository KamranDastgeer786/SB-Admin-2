@extends('layouts.app')
@section('page-title', 'Show Roles')
@section('content')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary breadcrumb float-sm-right" style="background-color: ghostwhite;">Show All Role</h6>
            <a href="{{ route('roles.create') }}" class="btn btn-primary"> ✙ Add Role </a>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="contactList">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                
                    <tbody id="categoryTableBody">
                        @forelse ($roles as $role)
                        <tr>
                                <td>
                                    <a href="" class="btn-link">{{ $role->id }}</a>
                                </td>

                                <td>
                                    <a href="" class="btn-link">{{ $role->name }}</a>
                                </td>

                                <td>

                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm" style="width: 74px; margin-left: 95px;">
                                        <i class="fa fa-code"></i>
                                        Edit
                                    </a>
                                
                                </td>

                                <td>

                                    <a onclick="deleteRole('{{ route('roles.destroy', $role->id) }}')" class="btn btn-danger btn-sm" style="width: 77px; margin-left: 95px;"> 
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                               <td colspan="9">No Role Found.</td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function deleteRole(slug) {
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


