@extends('admin.layouts.admin')
@section('content')

<div>
    <x-page-header :value="__('Dashboard Overview')"/>
    <div class="grid grid-cols-12">
        <div class="w-full col-span-12 p-6 lg:col-span-4" id="chart-container">
            <canvas id="pieChart"></canvas>
        </div>
        <div class="w-full col-span-12 p-6 lg:col-span-8" id="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>


    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Category ({{$categoryCount}})', 'BodyType ({{$bodyTypeCount}})', 'Brand ({{$brandCount}})', 'Model ({{$modelCount}})'],
                datasets: [{
                    label: '# of Votes',
                    data: [{{$categoryCount}}, {{$bodyTypeCount}}, {{$brandCount}}, {{$modelCount}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const pie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pie, {
            type: 'pie',
            data: {
                labels: ['Category ({{$categoryCount}})', 'BodyType ({{$bodyTypeCount}})', 'Brand ({{$brandCount}})', 'Model ({{$modelCount}})'],
                datasets: [{
                    label: '# of Votes',
                    data: [{{$categoryCount}}, {{$bodyTypeCount}}, {{$brandCount}}, {{$modelCount}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>

@endsection
