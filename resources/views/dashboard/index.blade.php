@extends('layouts.app')

@section('content')
    @include('dashboard.small_box')
    @include('dashboard.grafik')

    @push('scripts')
        <script src="{{ asset('adminlte') }}/plugins/chart.js/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('humidityTemperatureChart').getContext('2d');
                var humidityTemperatureChart = new Chart(ctx, {
                    type: 'pie', // Changed to 'doughnut'
                    data: {
                        labels: ['Humidity', 'Temperature'],
                        datasets: [{
                            label: 'Sensor Data',
                            data: [0, 0], // Initial empty data
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1,
                            hoverOffset: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                color: '#000', // Warna teks yang akan ditampilkan
                                anchor: 'center',
                                align: 'center',
                                formatter: function(value, context) {
                                    return value.toFixed(0); // Format angka (misalnya, dua desimal)
                                }
                            }
                        },
                    },
                    plugins: [ChartDataLabels] // Aktifkan plugin datalabels
                });

                function updateTable(data) {
                    const sensorDataTable = document.getElementById('sensorDataTable');
                    sensorDataTable.innerHTML = '';

                    if (data.length === 0) {
                        sensorDataTable.innerHTML = '<tr><td colspan="4">Tidak ada data</td></tr>';
                    } else {
                        data.forEach((item, index) => {
                            sensorDataTable.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.temperature}</td>
                                    <td>${item.humidity}</td>
                                    <td>${item.created_at}</td>
                                </tr>`;
                        });
                    }
                }

                function updateDataAndBoxes() {
                    fetch('{{ route('sensordata.get_latest_data') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                var latestData = data.data;

                                if (latestData.humidity !== undefined && latestData.temperature !== undefined) {
                                    // Update chart
                                    humidityTemperatureChart.data.datasets[0].data = [latestData.humidity,
                                        latestData.temperature
                                    ];
                                    humidityTemperatureChart.update();

                                    // Update boxes
                                    var temperatureBox = document.getElementById('temperatureBox');
                                    var humidityBox = document.getElementById('humidityBox');

                                    if (temperatureBox && humidityBox) {
                                        temperatureBox.innerHTML =
                                            `<div class="inner"><h3>${latestData.temperature.toFixed(2)} °C</h3><p>Temperature</p></div>`;
                                        humidityBox.innerHTML =
                                            `<div class="inner"><h3>${latestData.humidity.toFixed(0)} %</h3><p>Humidity</p></div>`;

                                        // Update box color based on temperature
                                        updateBoxColors(temperatureBox, humidityBox, latestData.temperature);
                                    }
                                }
                            }
                        })
                        .catch(error => console.error('Error fetching data:', error));

                    fetch('{{ route('sensordata.getAll') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateTable(data.data);
                            }
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateBoxColors(temperatureBox, humidityBox, temperature) {
                    let bgClass = 'bg-success'; // Default to green for normal range

                    if (temperature > 30) {
                        bgClass = 'bg-danger'; // High temperature
                    } else if (temperature >= 15 && temperature <= 29) {
                        bgClass = 'bg-warning'; // Moderate temperature
                    }

                    temperatureBox.parentElement.className = `small-box text-center ${bgClass} p-2`;
                    humidityBox.parentElement.className = `small-box p-2 text-center ${bgClass}`;
                }

                // Update data every 5 seconds
                setInterval(updateDataAndBoxes, 5000);

                // Initial load
                updateDataAndBoxes();
            });
        </script>
    @endpush
@endsection
