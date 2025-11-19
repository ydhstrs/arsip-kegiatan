@extends('layouts.app')

@section('title')

@section('content')

    <body>
        <h1>Dashboard</h1>
        <div class="flex flex-wrap gap-4">
            <!-- Chart 1 -->
            <div class="w-full md:w-1/2">
                <x-chartjs-component :chart="$chart" />
            </div>

            <!-- Chart 2 -->
            <div class="w-full md:w-fit">
                <x-chartjs-component :chart="$chartRoom" />
            </div>
        </div>

    </body>
@endsection
