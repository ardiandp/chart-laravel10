<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Harian Per Bulan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 80%; margin: auto;">
        <h2 style="text-align: center;">Mutasi Harian CR dan DB</h2>

        <!-- Form Pilihan Periode -->
        <form action="{{ url('/bank-mutasi-harian') }}" method="GET" style="margin-bottom: 30px;">
            <label for="periode">Pilih Periode (YYYY-MM):</label>
            <input type="month" id="periode" name="periode" value="{{ $periode }}" required>
            <button type="submit">Tampilkan</button>
        </form>

        <!-- Chart -->
        <canvas id="mutasiHarianChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('mutasiHarianChart').getContext('2d');
        const mutasiHarianChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels->map(fn($date) => date('d M', strtotime($date)))) !!},
                datasets: [
                    {
                        label: 'CR (Credit)',
                        data: {!! json_encode($crData) !!},
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        tension: 0.4
                    },
                    {
                        label: 'DB (Debit)',
                        data: {!! json_encode($dbData) !!},
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
</body>
</html>
