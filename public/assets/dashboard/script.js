document.addEventListener("DOMContentLoaded", function () {
    // Ambil data dari elemen HTML
    const chartData = JSON.parse(
        document.getElementById("chart-data").textContent
    );

    var options = {
        series: [
            {
                name: "Jumlah Pasien",
                data: chartData.data, // Data dari controller
            },
        ],
        chart: {
            type: "bar",
            height: 350,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: "rounded",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {
            categories: chartData.labels, // Label bulan
        },
        yaxis: {
            title: {
                text: "Jumlah Pasien",
            },
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " pasien";
                },
            },
        },
    };

    var chart = new ApexCharts(
        document.querySelector("#patientChart"),
        options
    );
    chart.render();
});

// keuangan:
document.addEventListener("DOMContentLoaded", function () {
    // Ambil data dari elemen HTML
    const chartData = JSON.parse(
        document.getElementById("chart-keuangan").textContent
    );

    // Opsi untuk grafik keuangan bulanan
    var options = {
        series: [
            {
                name: "Total Pembayaran",
                data: chartData.payments, // Data pembayaran dari controller
            },
        ],
        chart: {
            type: "line", // Menggunakan grafik tipe line
            height: 350,
        },
        stroke: {
            curve: "smooth",
            width: 2,
        },
        xaxis: {
            categories: chartData.labels, // Label bulan
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return "Rp " + val.toLocaleString(); // Format rupiah
                },
            },
            title: {
                text: "Total Pembayaran (Rp)",
            },
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "Rp " + val.toLocaleString(); // Format tooltip rupiah
                },
            },
        },
        title: {
            text: "Grafik Keuangan Per Bulan",
            align: "center",
        },
        dataLabels: {
            enabled: false,
        },
        fill: {
            opacity: 1,
        },
    };

    // Render chart keuangan
    var chart = new ApexCharts(
        document.querySelector("#keuanganChart"),
        options
    );
    chart.render();
});
