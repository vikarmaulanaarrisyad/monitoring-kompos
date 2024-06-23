@extends('layouts.app')

@section('title', 'History Alat')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">History Alat</li>
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
                            <th>Nama Device</th>
                            <th>Suhu ℃</th>
                            <th>Kelembaban (%)</th>
                            <th>Kapasitas Air</th>
                            <th>Status Pompa Air</th>
                            <th>Waktu</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('devices.form')
@endsection
@include('includes.datatable')

@push('scripts')
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
                    data: 'device_id',
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
                    data: 'status',
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
