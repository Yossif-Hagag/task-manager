@extends('adminlte::page')
@extends('layouts.app')


@section('title', 'Tasks Management')

@section('content_header')
    <h1><i class="fas fa-tasks"></i> Task Management</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list"></i> Task List</h3>
            <div class="card-tools">
                <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add New Task
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Assigned To</th>
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
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                @elseif($task->status == 'in_progress')
                                    <span class="badge badge-primary"><i class="fas fa-spinner"></i> In Progress</span>
                                @else
                                    <span class="badge badge-success"><i class="fas fa-check"></i> Completed</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info"><i class="fas fa-flag"></i> {{ $task->priority }}</span>
                            </td>
                            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'Not Set' }}
                            </td>
                            <td>{{ $task->assignedTo ? $task->assignedTo->name : 'Not Assigned' }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteModal{{ $task->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this task?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            </td>
                        </tr>

                        <!-- Comments Section -->
                        @if ($task->comments->count() > 0)
                            <tr>
                                <td colspan="8">
                                    <strong>Comments:</strong>
                                    <ul>
                                        @foreach ($task->comments as $comment)
                                            <li><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
