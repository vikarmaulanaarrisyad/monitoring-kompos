@extends('layouts.app')

@section('content')
    @include('dashboard.small_box')
    @include('dashboard.grafik')

    @push('scripts')
        <script src="{{ asset('adminlte') }}/plugins/chart.js/Chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('humidityTemperatureChart').getContext('2d');
                var humidityTemperatureChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                                label: 'Humidity (%)',
                                data: [],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                fill: false
                            },
                            {
                                label: 'Temperature (°C)',
                                data: [],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'second',
                                    tooltipFormat: 'YYYY-MM-DD HH:mm:ss',
                                    displayFormats: {
                                        second: 'YYYY-MM-DD HH:mm:ss',
                                    }
                                },
                            },
                            yAxes: [{
                                ticks: {
                                    suggestedMin: 0,
                                    suggestedMax: 100
                                }
                            }]
                        }
                    }
                });

                function updateTable(data) {
                    const sensorDataTable = document.getElementById('sensorDataTable');
                    sensorDataTable.innerHTML = '';
                    data.forEach((item, index) => {
                        sensorDataTable.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.temperature}</td>
                        <td>${item.humidity}</td>
                        <td>${item.created_at}</td>
                    </tr>
                `;
                    });
                }

                function updateDataAndBoxes() {
                    fetch('{{ route('sensordata.get_latest_data') }}') // Ganti route dengan yang sesuai
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                var latestData = data.data;

                                if (latestData.humidity !== undefined && latestData.temperature !== undefined) {
                                    var currentTime = new Date().toLocaleString('id-ID', {
                                        timeZone: 'Asia/Jakarta'
                                    });

                                    humidityTemperatureChart.data.labels.push(currentTime);
                                    humidityTemperatureChart.data.datasets[0].data.push(latestData.humidity);
                                    humidityTemperatureChart.data.datasets[1].data.push(latestData.temperature);

                                    if (humidityTemperatureChart.data.labels.length > 3) {
                                        humidityTemperatureChart.data.labels.shift();
                                        humidityTemperatureChart.data.datasets[0].data.shift();
                                        humidityTemperatureChart.data.datasets[1].data.shift();
                                    }

                                    humidityTemperatureChart.update();

                                    var temperatureBox = document.getElementById('temperatureBox');
                                    var humidityBox = document.getElementById('humidityBox');

                                    if (temperatureBox && humidityBox) {
                                        temperatureBox.innerHTML =
                                            `<div class="inner"><h3>${latestData.temperature.toFixed(2)} °C</h3><p>DS18820 Temperatur</p></div>`;
                                        humidityBox.innerHTML =
                                            `<div class="inner"><h3>${latestData.humidity.toFixed(2)} %</h3><p>DS18820 Humidity</p></div>`;
                                    } else {
                                        console.error('Temperature or humidity box not found.');
                                    }
                                } else {
                                    console.error('Invalid data received:', latestData);
                                }
                            } else {
                                console.error('No data received or data format is invalid.');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });

                    fetch('{{ route('sensordata.getAll') }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateTable(data.data);
                            } else {
                                console.error('No data received or data format is invalid.');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                }

                // Update the chart and boxes every 5 seconds
                setInterval(updateDataAndBoxes, 5000); // Ubah interval menjadi 5000

                // Initial data load
                updateDataAndBoxes();
            });
        </script>
    @endpush
@endsection
