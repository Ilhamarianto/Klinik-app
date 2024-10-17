
<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical  light  ">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">Data Nurses</h1>
                        <div class="card">
                            <div class="card-header">
                               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fe fe-user-plus"></i> Add Nurses
                                </button>

                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end mb-2 form-group">
                                    <input type="text" id="searchInput" class="form-control form-control-sm w-25" placeholder="Search...">
                                </div>

                            <table class="table responsive " id="NursesTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone_number</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nurses as $index => $item)
                                    <tr>
                                        <td>{{ ($nurses->currentPage() - 1) * $nurses->perPage() + $index + 1 }} </td>
                                        <td><img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="max-width: 100px; max-height: 100px;"></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-{{$item->id}}">
                                                    <i class="fe fe-edit-2"> </i>
                                                    Edit
                                                </button>
                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                    <i class="fe fe-trash-2"> </i>
                                                    Delete
                                                </button>
                                            </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-danger">
                                                Data Nurses belum Tersedia.
                                            </div>
                                        </td>
                                    </tr>

                                    @endforelse
                                </tbody>
                            </table>
                           {{ $nurses->links() }}
                            </div>
                        </div>
                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->
        </main> <!-- main -->
    </div> <!-- .wrapper -->



@include('Nurses.modal.add')
@include('Nurses.modal.edit')
{{-- @include('Nurses.modal.editDocter') --}}
<script src="{{ asset('assets/nurses/js/scripts.js') }}"></script>
<x-footer>
    @push('scripts')
    <script>
    $(document).ready(function() {
        // Handle klik tombol hapus
        $('.delete-btn').on('click', function() {
            var nurseId = $(this).data('id');
            var nurseName = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete " + nurseName + ". This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, hapus data dengan AJAX
                    $.ajax({
                        url: '/nurses/' + nurseId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The nurse has been deleted.',
                                'success'
                            ).then(() => {
                                // Redirect atau reload halaman setelah hapus
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the nurse.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>

    @endpush
</x-footer>
