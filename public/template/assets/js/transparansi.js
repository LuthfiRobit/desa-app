document.addEventListener('DOMContentLoaded', function() {
    // Data untuk Chart Pendapatan (Pie)
    const ctxPieElement = document.getElementById('pendapatanPieChart');
    if (ctxPieElement) {
        const ctxPie = ctxPieElement.getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Dana Desa (DD)', 'Alokasi Dana Desa (ADD)', 'Pendapatan Asli Desa', 'Bantuan Keuangan'],
                datasets: [{
                    data: [62, 27.5, 8.5, 2],
                    backgroundColor: [
                        '#2d8659',
                        '#52b788',
                        '#74c69d',
                        '#d8f3dc'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, font: { family: 'Poppins' } } }
                },
                cutout: '65%'
            }
        });
    }

    // Data untuk Chart Belanja (Bar)
    const ctxBarElement = document.getElementById('belanjaBarChart');
    if (ctxBarElement) {
        const ctxBar = ctxBarElement.getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Pemerintahan', 'Pembangunan', 'Kemasyarakatan', 'Pemberdayaan'],
                datasets: [{
                    label: 'Realisasi (Juta Rupiah)',
                    data: [380, 450, 120, 175],
                    backgroundColor: '#e63946',
                    borderRadius: 5,
                },
                {
                    label: 'Anggaran (Juta Rupiah)',
                    data: [400, 700, 150, 200],
                    backgroundColor: '#f1faee',
                    borderColor: '#e63946',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4], color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { position: 'top', labels: { font: { family: 'Poppins' } } }
                }
            }
        });
    }
});
