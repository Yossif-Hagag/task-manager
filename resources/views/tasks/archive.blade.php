@extends('adminlte::page')
@extends('layouts.app')

@section('title', 'Tasks Archive')

@section('content_header')
    <h1><i class="fas fa-archive"></i> Tasks Archive</h1>
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('tasks.index') }}" class="btn btn-primary mb-3">
            <i class="fas fa-tasks"></i> Back to Tasks
        </a>

        <table class="table table-bordered table-hover">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Assigned Employee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ Str::limit($task->description, 20) }}</td>
                        <td>
                            @if ($task->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($task->status == 'in_progress')
                                <span class="badge bg-primary">In Progress</span>
                            @else
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $task->priority }}</span>
                        </td>
                        <td>{{ $task->due_date ?? 'Not Specified' }}</td>
                        <td>{{ $task->assignedTo ? $task->assignedTo->name : 'Not Assigned' }}</td>
                        <td>
                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#restoreModal{{ $task->id }}">
                                <i class="fas fa-undo"></i> Restore
                            </button>

                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal{{ $task->id }}">
                                <i class="fas fa-trash-alt"></i> Permanently Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Restore Confirmation Modal -->
                    <div class="modal fade" id="restoreModal{{ $task->id }}" tabindex="-1"
                        aria-labelledby="restoreModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="restoreModalLabel">Confirm Restore</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to restore this task?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <!-- Restore Form -->
                                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Yes, Restore</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permanent Deletion Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Permanent Deletion</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to permanently delete this task? This action cannot be undone.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
