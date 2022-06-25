@php
$primary_color = \App\Facades\UtilityFacades::getsettings('color');
if (isset($primary_color)) {
    $color = $primary_color;
} else {
    $color = 'theme-1';
}
if ($color == 'theme-1') {
    $chatcolor = '#51459D';
} elseif ($color == 'theme-2') {
    $chatcolor = '#4EBBD3';
} elseif ($color == 'theme-3') {
    $chatcolor = '#6FD943';
} else {
    $chatcolor = '#685EE5';
}
@endphp
@extends('layouts.main')
@section('title', __('Dashboard'))

@section('content')
    <div class="row">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="m-b-10">{{ __('Dashboard') }}</h4>
                        </div>
                        <ul class="breadcrumb">
                            <li class="section-header-breadcrumb"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @can('manage-user')
                <div class="col-xl-4 col-md-12">
                    <a href="users">
                        <div class="card comp-card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-b-20 text-muted">{{ __('Total User') }}</h6>
                                        <h3 class="">{{ $user }}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-users bg-primary text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endcan
            @can('manage-form')
                <div class="col-xl-4 col-md-12">
                    <a href="forms">

                        <div class="card comp-card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-b-20 text-muted">{{ __('Total Form') }}</h6>
                                        <h3 class="">{{ $form }}</h3>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-file-text bg-success text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endcan
            @can('manage-submitted-form')
                <div class="col-xl-4 col-md-12">

                    <div class="card comp-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-b-20 text-muted">{{ __('Total Submited Form') }}</h6>
                                    <h3 class="">{{ $submitted_form }}</h3>
                                </div>
                                <div class="col-auto">
                                    <i class="ti ti-ad-2 bg-danger text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Submitted Form') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- <script src="{{ asset('assets/js/index-0.js') }}"></script> --}}

    <script>
        var statistics_chart = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(statistics_chart, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total Submitted Forms',
                    data: [],
                    borderWidth: 5,
                    borderColor: '{{ $chatcolor }}',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '{{ $chatcolor }}',
                    pointRadius: 4
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 5
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fbfbfb',
                            lineWidth: 2
                        }
                    }]
                },
            }
        });
        $(document).ready(function() {
            getChartData('myChart');
        })

        function getChartData(type) {

            $.ajax({
                url: "{{ route('get.chart.data') }}",
                type: 'POST',
                data: {
                    type: type,
                    "_token": "{{ csrf_token() }}",
                },

                success: function(result) {
                    myChart.data.labels = result.lable;
                    myChart.data.datasets[0].data = result.value;
                    myChart.update()
                },
                error: function(data) {
                    console.log(data.responseJSON);
                }

            });
        }
    </script>
@endpush
