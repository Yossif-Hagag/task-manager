@extends('adminlte::page')
@extends('layouts.app')

@section('title', 'Edit Task')

@section('content_header')
    <h1><i class="fas fa-edit"></i> Edit Task</h1>
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
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tasks"></i> Update Task</h3>
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

                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label><i class="fas fa-heading"></i> Task Title</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $task->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-align-left"></i> Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-tasks"></i> Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-flag"></i> Priority</label>
                            <input type="number" name="priority" class="form-control" min="1" max="5"
                                value="{{ old('priority', $task->priority) }}" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Due Date</label>
                            <input type="date" name="due_date" class="form-control"
                                value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Assign to</label>
                            <select name="assigned_to" class="form-control select2">
                                <option value="">Not Assigned</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Attachments</label>
                            <input type="file" name="attachments[]" multiple>

                            @if ($task->attachments->count())
                                <ul>
                                    @foreach ($task->attachments as $attachment)
                                        <li class="mb-2 d-flex justify-content-between bg-light rounded">
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                                {{ basename($attachment->file_path) }}
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteAttachment('{{ $attachment->file_path }}')"><i
                                                    class="fas fa-trash"></i></button>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>


                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-save"></i> Update Task
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

            function deleteAttachment(filePath) {
                if (confirm("Are you sure you want to delete this attachment?")) {
                    $.ajax({
                        url: '{{ route('tasks.deleteAttachment') }}',
                        method: 'post',
                        data: {
                            file_name: filePath,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Attachment deleted successfully');
                                // إزالة العنصر من الصفحة بعد الحذف بدون إعادة تحميل الصفحة
                                $(`button[onclick="deleteAttachment('${filePath}')"]`).closest('li').remove();
                            } else {
                                alert(response.message || 'An error occurred');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', status, error);
                            alert('An error occurred');
                        }
                    });
                }
            }
        </script>
    @endpush

@endsection
