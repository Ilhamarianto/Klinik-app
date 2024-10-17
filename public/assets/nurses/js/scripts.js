document.addEventListener("DOMContentLoaded", function () {
    // Event listener untuk tombol simpan
    document
        .getElementById("saveChanges")
        .addEventListener("click", function () {
            // Ambil data dari input
            const name = document.getElementById("name").value;
            const phoneNumber = document.getElementById("phone_number").value;
            const email = document.getElementById("email").value;
            const image = document.getElementById("image").files[0];

            // Validasi input
            if (!name || !phoneNumber || !email) {
                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    text: "Semua kolom harus diisi!",
                    position: "top-end",
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            // Buat FormData untuk mengirim file
            let formData = new FormData();
            formData.append("name", name);
            formData.append("phone_number", phoneNumber);
            formData.append("email", email);
            if (image) {
                formData.append("image", image);
            }

            // Kirim data menggunakan AJAX
            fetch("/nurses/store", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                credentials: "same-origin",
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            `Network response was not ok: ${response.status} ${response.statusText}`
                        );
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Menampilkan SweetAlert jika data berhasil disimpan
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Data berhasil disimpan",
                            position: "top-end",
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000,
                        }).then(() => {
                            location.reload(); // Untuk me-refresh halaman dan menampilkan data baru
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text:
                                data.message ||
                                "Terjadi kesalahan saat menyimpan data.",
                            position: "top-end",
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: "error",
                        title: "Network Error",
                        text: "Terjadi kesalahan: " + error.message,
                        position: "top-end",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    console.error("Error:", error);
                });
        });

    // Event listener untuk pencarian dalam tabel
    document
        .getElementById("searchInput")
        .addEventListener("keyup", function () {
            var value = this.value.toLowerCase(); // Ambil nilai input dan ubah menjadi huruf kecil
            var rows = document.querySelectorAll("#NursesTable tbody tr");

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
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".saveChangesBtn").forEach(function (button) {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id"); // ID dari nurse

            const name = document.getElementById("name-" + id).value;
            const phoneNumber = document.getElementById(
                "phone_number-" + id
            ).value;
            const email = document.getElementById("email-" + id).value;
            const image = document.getElementById("image-" + id).files[0];

            // Validasi input
            if (!name || !phoneNumber || !email) {
                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    text: "Semua kolom harus diisi!",
                    position: "top-end",
                    toast: true,
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            // Buat FormData untuk mengirim file
            let formData = new FormData();
            formData.append("name", name);
            formData.append("phone_number", phoneNumber);
            formData.append("email", email);
            if (image) {
                formData.append("image", image);
            }
            formData.append("_method", "PUT"); // Laravel membutuhkan PUT untuk update

            // Kirim data menggunakan AJAX
            fetch(`/nurses/${id}`, {
                method: "POST", // Laravel menerima POST dengan _method=PUT untuk update
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                credentials: "same-origin",
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            `Network response was not ok: ${response.status} ${response.statusText}`
                        );
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Menampilkan SweetAlert jika data berhasil diperbarui
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Data berhasil diperbarui",
                            position: "top-end",
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000,
                        }).then(() => {
                            // Menutup modal setelah berhasil
                            const modal = document.getElementById(
                                `#editModal-${id}`
                            );
                            const bootstrapModal =
                                bootstrap.Modal.getInstance(modal);
                            bootstrapModal.hide();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text:
                                data.message ||
                                "Terjadi kesalahan saat memperbarui data.",
                            position: "top-end",
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: "error",
                        title: "Network Error",
                        text: "Terjadi kesalahan: " + error.message,
                        position: "top-end",
                        toast: true,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    console.error("Error:", error);
                });
        });
    });
});
