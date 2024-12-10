<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Total Mutasi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 60%; margin: auto;">
        <h2 style="text-align: center;">Total Transaksi CR dan DB</h2>
        <canvas id="totalMutasiChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('totalMutasiChart').getContext('2d');
        const totalMutasiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['CR (Credit)', 'DB (Debit)'],
                datasets: [{
                    label: 'Total Transaksi',
                    data: [{{ $totalCR }}, {{ $totalDB }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
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