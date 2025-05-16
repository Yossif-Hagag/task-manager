@extends('adminlte::page')
@extends('layouts.app')

@section('title', 'Add New Task')

@section('content_header')
    <h1><i class="fas fa-plus-circle"></i> Add New Task</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
            style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tasks"></i> Task Details</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label><i class="fas fa-heading"></i> Task Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-align-left"></i> Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-tasks"></i> Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" selected>Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-flag"></i> Priority</label>
                            <input type="number" name="priority" class="form-control" min="1" max="5"
                                value="1" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Due Date</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Assign to</label>
                            <select name="assigned_to" class="form-control select2">
                                <option value="">Not Assigned</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Attachments</label>
                            <input type="file" name="attachments[]" id="" multiple>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-save"></i> Add Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Select an employee",
                    allowClear: true
                });
            });
        </script>
    @endpush



@endsection
