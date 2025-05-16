<!-- filepath: /mnt/work/laravel/task-manager/resources/views/dashboard/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Total Users Card -->
        <div class="col-md-4">
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <h4><i class="fas fa-users"></i> Users Numbers</h4>
                    <h2>{{ $users }}</h2>
                </div>
            </div>
        </div>

        <!-- Recent Tasks Card -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h5><i class="fas fa-tasks"></i> Latest Tasks</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $task->title }}
                                <span class="badge bg-success">{{ $task->status }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
