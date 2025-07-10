<h1 class="title-module fw-bold mb-3">Dashboard</h1>
<div class="d-flex flex-column gap-3 h-100">
    <section style=" height: 300px;" class="content-ventas flex-grow-1 d-flex align-items-center justify-content-center rounded-3">
        <span class="opacity-25 fw-light w-50 text-center">Contenedor para información de venta de medicamentos</span>
    </section>

    <section class="d-flex gap-3">
        <div class="content-users d-flex w-50 justify-content-around align-items-center">
            <canvas id="estDonut" style="max-height: 300px;"></canvas>
        </div>

        <div class="content-nose d-flex w-50 justify-content-around align-items-center">
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = <?= json_encode($labels) ?>;
        const valores = <?= json_encode($valores) ?>;

        const data = {
            labels: labels,
            datasets: [{
                data: valores,
                backgroundColor: ['#41a663',
                    'rgba(0, 247, 255, 0.6)',
                    'rgb(0, 195, 255)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ],
                borderWidth: 0,
            }]
        };
        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Usuarios registrados por rol'
                    },
                    legend: {
                        display: false
                    },
                    datalabels: {
                        color: '#ffffff',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            const label = context.chart.data.labels[context.dataIndex];
                            return `${value}`;
                        }
                    }
                },
                elements: {
                    arc: {
                        spacing: 4
                    }
                }
            },
            plugins: [ChartDataLabels]
        };


        new Chart(document.getElementById('estDonut'), config);
    });
</script>