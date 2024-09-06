@extends('layouts.app')

@section('title', 'History Monitoring')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">History Monitoring</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="deleteDataAll(`{{ route('sensordata.delete_all') }}`)"
                        class="btn float-right btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus Data History</button>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>Suhu ℃</th>
                            <th>Kelembaban (%)</th>
                            <th>Kapasitas Air</th>
                            <th>Kapasitas Aktivitator</th>
                            <th>Status Pompa Air</th>
                            <th>Status Pompa Aktivator</th>
                            <th>Waktu</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
        <!-- Grafik Line -->
        <div class="col-lg-12">
            <x-card title="Grafik Monitoring Sensor">
                <canvas id="lineChart"></canvas>
            </x-card>
        </div>
    </div>
    @include('devices.form')
@endsection
@include('includes.datatable')

@push('scripts')
    <script>
        $(document).ready(function() {
            if (window.location.href.includes("/sensordata")) {
                $('body').addClass('sidebar-closed sidebar-collapse');
            }
        });
    </script>
    <script>
        let table;
        let modal = "#modal-form";
        let button = '#submitBtn';

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('.table').DataTable({
            processing: false,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('sensordata.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'temperature',
                },
                {
                    data: 'humidity',
                },
                {
                    data: 'kapasitas1',
                },
                {
                    data: 'kapasitas2',
                },
                {
                    data: 'status',
                },
                {
                    data: 'status2',
                },
                {
                    data: 'waktu',
                },
            ]
        });

        // hapus data
        function deleteDataAll(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apa kamu yakin?',
                text: 'data yang sudah di hapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: 'Iya, hapus!',
                cancelButtonText: 'Membatalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    table.ajax.reload();
                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            }).then(() => {
                                table.ajax.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush

@push('scripts')
    <script src="{{ asset('adminlte') }}/plugins/chart.js/Chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // Jika berada di halaman sensor data, collapse sidebar
            if (window.location.href.includes("/sensordata")) {
                $('body').addClass('sidebar-closed sidebar-collapse');
            }

            // Data dari backend untuk chart
            const sensorData = {
                labels: [], // Waktu
                datasets: [{
                        label: 'Suhu (℃)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        data: [] // Suhu data
                    },
                    {
                        label: 'Kelembaban (%)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        data: [] // Kelembaban data
                    }
                ]
            };

            const ctx = document.getElementById('lineChart').getContext('2d');
            const lineChart = new Chart(ctx, {
                type: 'line',
                data: sensorData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'minute' // Ubah sesuai kebutuhan
                            },
                            title: {
                                display: true,
                                text: 'Waktu'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nilai Sensor'
                            }
                        }
                    }
                }
            });

            // Ambil data dari server untuk update chart
            function updateChart() {
                $.ajax({
                    url: '{{ route('sensordata.chart') }}',
                    type: 'GET',
                    success: function(data) {
                        console.log('Data => ', data);
                        // Kosongkan data lama
                        sensorData.labels.length = 0;
                        sensorData.datasets[0].data.length = 0;
                        sensorData.datasets[1].data.length = 0;

                        // Update data baru
                        data.forEach(sensor => {
                            sensorData.labels.push(sensor.waktu);
                            sensorData.datasets[0].data.push(sensor.temperature);
                            sensorData.datasets[1].data.push(sensor.humidity);
                        });

                        lineChart.update();
                    }
                });
            }

            // Panggil updateChart setiap interval waktu
            setInterval(updateChart, 1000); // Update tiap 5 detik
        });
    </script>
@endpush
