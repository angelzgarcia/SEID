

//  S A L E S   S E C T I O N   C H A R T S   S C R I P T S
const options =  {
    scales: {
        y: {
            ticks: {
                font: {
                    size: 16,
                },
                color: '#fff'
            },
            grid: {
                color: "#919191",
                lineWidth: 1,
                borderDash: [5, 5]
            }
        },
        x: {
            beginAtZero: true,
            ticks: {
                color: "#fff"
            },
            grid: {
                color: "#919191",
                lineWidth: 1,
                borderDash: [5, 5]
            }
        }
    },
    plugins: {
        legend: {
            labels: {
                color: "#fff"
            }
        }
    }
};

// P R O D U C T O S   M A S   V E N D I D O S
// (barras)
const best_sellings_products_chart = document.getElementById('best_sellings_products_chart');
const best_selling_products_data = {
    labels: [['Camiseta', 'Legendary', 'WhiteTails'], 'Gabardina', 'Rompevientos', 'Jeans Mezclilla', ['Camisa de', 'franela']],
    datasets: [{
        axis: 'y',
        label: 'Productos más vendidos',
        data: [65, 59, 80, 81, 56, 55, 40].sort(),
        fill: false,
        // barThickness: 50,
        backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 205, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(201, 203, 207, 0.5)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 205, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(201, 203, 207, 1)'
        ],
        // borderColor: '#fff',
        borderWidth: 2
    }]
};
new Chart(best_sellings_products_chart, {
    type: 'bar',
    data: best_selling_products_data,
    options: {
        indexAxis: 'y',
        scales: {
            y: {
                ticks: {
                    font: {
                        size: 16,
                    },
                    color: '#fff'
                },
                grid: {
                    color: "transparent",
                    lineWidth: 1,
                    borderDash: [5, 5]
                }
            },
            x: {
                beginAtZero: true,
                ticks: {
                    color: "#fff"
                },
                grid: {
                    color: "#fff",
                    lineWidth: 1,
                    borderDash: [5, 5]
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: "#fff"
                }
            }
        }
    },
});



// V E N T A S   P O R   P E R I O D O S
// Ventas de la semana (barras)
const daily_sales_per_week_bar_chart = document.getElementById('daily_sales_per_week_bar_chart');
new Chart(daily_sales_per_week_bar_chart, {
    type: 'bar',
    data: {
        labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        datasets: [{
            label: 'Ventas de la semana($)',
            data: [120, 200, 180, 250, 300, 500, 450],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(201, 203, 207, 1)'
            ],
            borderWidth: 1
        }],

    },
    options: options,
});
// Ventas por mes (lineas)
const daily_sales_per_month_line_chart = document.getElementById('daily_sales_per_month_line_chart');
new Chart(daily_sales_per_month_line_chart, {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
        datasets: [{
            label: 'Ventas Mensuales ($)',
            data: [5000, 7000, 8000, 10000, 7500, 9500],
            fill: false,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(201, 203, 207, 1)'
            ],
            tension: 0.1
        }]
    },
    options: options,
});
// Ventas por año (lineas)
const daily_sales_per_year_chart = document.getElementById('daily_sales_per_year_chart');
new Chart(daily_sales_per_year_chart, {
    type: 'line',
    data: {
        labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
        datasets: [{
            label: 'Ventas Anuales ($)',
            data: [5000, 7000, 8000, 20000, 7500, 9500].sort(),
            fill: false,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(201, 203, 207, 1)'
            ],
            tension: 0.1
        }]
    },
    options: options,
});
// Ventas por periodo (pastel)
const daily_sales_per_period_chart = document.getElementById('daily_sales_per_period_chart');
new Chart(daily_sales_per_period_chart, {
    type: 'pie',
    data: {
        labels: ['Día', 'Semana', 'Mes', 'Año'],
        datasets: [{
            label: 'Ventas por pediodo',
            data: [500, 3500, 15000, 200000],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(201, 203, 207, 1)'
            ],
        }]
    },
    options: options,
});


// VENTAS POR TIPO DE PRODUCTO
// Ventas por tipo (doughnut)
const sales_per_type_chart = document.getElementById('sales_per_type_chart');
new Chart(sales_per_type_chart, {
    type: 'doughnut',
    data: {
        labels: ['Unidad', 'Granel', 'Paquete'],
        datasets: [{
            label: 'Ventas por tipo',
            data: [1700, 2500, 500],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(201, 203, 207, 1)'
            ],
        }]
    },
    options: options,
});

