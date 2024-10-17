document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("saveChanges")
        .addEventListener("click", function () {
            const name = document.getElementById("name").value;
            const dateOfBirth = document.getElementById("date_of_birth").value;
            const gender = document.getElementById("gender").value;
            const phoneNumber = document.getElementById("phone_number").value;
            const email = document.getElementById("email").value;
            const address = document.getElementById("address").value;

            if (
                !name ||
                !dateOfBirth ||
                !gender ||
                !phoneNumber ||
                !email ||
                !address
            ) {
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

            let formData = new FormData();
            formData.append("name", name);
            formData.append("date_of_birth", dateOfBirth);
            formData.append("gender", gender);
            formData.append("phone_number", phoneNumber);
            formData.append("email", email);
            formData.append("address", address);

            fetch("/patient/store", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    // No need to add 'Content-Type' header, browser will handle this automatically for FormData
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
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Data berhasil disimpan",
                            position: "top-end",
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000,
                        }).then(() => {
                            $("#exampleModal").modal("hide");
                            location.reload();
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
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".saveChangesBtn").forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const form = document.getElementById(`editForm-${id}`);
            const formData = new FormData(form);

            // Kirim data menggunakan AJAX
            fetch(`/patients/${id}`, {
                method: "POST", // Laravel akan menggunakan POST dengan _method=PUT untuk update
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
                            // Tutup modal dan reload halaman
                            $("#editModal-" + id).modal("hide");
                            location.reload();
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

// serching
document.getElementById("searchInput").addEventListener("keyup", function () {
    var value = this.value.toLowerCase(); // Ambil nilai input dan ubah menjadi huruf kecil
    var rows = document.querySelectorAll("#PatientsTable tbody tr");

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
