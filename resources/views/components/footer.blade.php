 <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ asset('assets/js/tinycolor-min.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/apps.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
     {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">

    <script src="{{ asset('assets/js/gauge.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js')}}"></script>
    <script src="{{ asset('assets/js/apexcharts.custom.js')}}"></script>
    <script src="{{ asset('assets/js/apps.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase().trim();
    document.querySelectorAll('#doctorsTable tbody tr').forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const specialization = row.cells[3].textContent.toLowerCase();
        const phoneNumber = row.cells[4].textContent.toLowerCase();
        const rowText = `${name} ${specialization} ${phoneNumber}`;

        row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dapatkan URL saat ini
        const currentUrl = window.location.href;

        // Dapatkan semua elemen <a> dalam sidebar
        const navLinks = document.querySelectorAll('aside.sidebar-left a.nav-link');

        navLinks.forEach(link => {
            if (link.href === currentUrl) {
                // Tambahkan kelas active ke elemen <a> dan <li> induknya
                link.classList.add('active');
                const parentLi = link.closest('li');
                if (parentLi) {
                    parentLi.classList.add('active');
                }

                // Jika item tersebut berada dalam dropdown, buka dropdown-nya
                const parentDropdown = link.closest('ul.collapse');
                if (parentDropdown) {
                    parentDropdown.classList.add('show');
                }
            }
        });
    });
</script>

    <script>
    $(document).ready(function() {
        $('#dataDoctors').DataTable({
            autoWidth: true,
            "pageLength": 5, // Menampilkan 5 item per halaman
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
            "searching": true,  // Aktifkan pencarian
            "paging": true,     // Aktifkan paging
            "info": true        // Menampilkan info halaman
        });
      });
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>

@if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    position: 'top-end',  // Posisi di bagian atas sebelah kanan
                    toast: true,          // Menampilkan dalam format toast
                    showConfirmButton: false,
                    timer: 3000           // Durasi tampilan pesan (3 detik)
                });
            });
        </script>
    @endif



@stack('scripts')
</body>

</html>
