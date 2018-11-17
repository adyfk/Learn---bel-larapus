@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{!! route('home') !!}">Dashboard</a></li>
                            </ol>
                        </nav>
            <div class="card">
               
                <div class="card-body">
                    Selamat datang di Menu Administrasi Larapus. Silahkan pilih menu administrasi yang diinginkan.
                    <hr>
                    <h4>Statistik Penulis</h4>
                    <canvas id="chartPenulis" width="400" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
        <script>
            var data = {
                labels: {!! json_encode($authors) !!},
                datasets: [{
                    label: 'Jumlah buku',
                    data: {!! json_encode($books) !!},
                    backgroundColor: "red",
                    borderColor: "rgba(151,187,205,0.8)",
                    hoverBackgroundColor :"yellow",
                }]
            };
            var options = {
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero:true,
                            stepSize: 1     //bnyak maksimal
                        }
                    }],
                    xAxes: [{
                            stacked: true
                    }]
                }
            };
            var ctx = document.getElementById("chartPenulis");
            var authorChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        </script>
@endpush