<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-primary">
                Data Temperature & Humidity High
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Data Suhu</th>
                        <th>Data Humidity</th>
                        <th>Date</th>
                    </thead>
                    <tbody id="sensorDataTable">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <x-card>
            <x-slot name="header" class="bg-primary">
                <h3 class="card-title">Grafik Temperature & Humidity</h3>
            </x-slot>
            {{--  <div class="container">  --}}
            <div class="row">
                <div class="col-md-12">
                    <canvas id="humidityTemperatureChart" height="300px" width="400px"></canvas>
                </div>
            </div>
            {{--  </div>  --}}
        </x-card>
    </div>

</div>
