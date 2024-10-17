
<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">Data Doctors</h1>
                        <div class="card">
                            <div class="card-header">
                               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fe fe-user-plus"></i> Add Doctor
                                </button>

                            </div>
                            <div class="card-body">
                                <div class="mb-2 d-flex justify-content-end form-group">
                                    <input type="text" id="searchInput" class="form-control form-control-sm w-25" placeholder="Search...">
                                </div>

                            <table class="table responsive " id="doctorsTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>image</th>
                                    <th>Name</th>
                                    <th>specialization</th>
                                    <th>phone_number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse ($doctors as $index => $item)
                                    <tr>
                                        <td>{{ ($doctors->currentPage() - 1) * $doctors->perPage() + $index + 1 }} </td>
                                        <td><img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="max-width: 100px; max-height: 100px;"></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->specialization }}</td>
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
                                                Data Doctors belum Tersedia.
                                            </div>
                                        </td>
                                    </tr>

                                    @endforelse
                                </tbody>
                            </table>
                           {{ $doctors->links() }}
                            </div>
                        </div>
                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->
        </main> <!-- main -->
    </div> <!-- .wrapper -->



@include('doctors.modal.addDocter')
@include('doctors.modal.editDocter')
<x-footer>
     @push('scripts')
         <script>
            $(document).ready(function() {
                // Handle klik tombol hapus
                $('.delete-btn').on('click', function() {
                    var doctorId = $(this).data('id');
                    var doctorName = $(this).data('name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to delete " + doctorName + ". This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika dikonfirmasi, hapus data dengan AJAX atau form submission
                            $.ajax({
                                url: '/doctors/' + doctorId,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The doctor has been deleted.',
                                        'success'
                                    ).then(() => {
                                        // Redirect atau reload halaman setelah hapus
                                        location.reload();
                                    });
                                },
                                error: function(response) {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the doctor.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });


            // serching
document.getElementById("searchInput").addEventListener("keyup", function () {
    var value = this.value.toLowerCase(); // Ambil nilai input dan ubah menjadi huruf kecil
    var rows = document.querySelectorAll("#doctorsTable tbody tr");

    // Loop melalui setiap baris di dalam tbody tabel
    rows.forEach(function (row) {
        // Cek apakah teks dalam baris mencocokkan teks pencarian
        if (row.textContent.toLowerCase().indexOf(value) > -1) {
            row.style.display = ""; // Tampilkan baris
        } else {
            row.style.display = "none"; // Sembunyikan baris
        }
    });
});
        </script>
    @endpush
    </x-footer>
</body>
