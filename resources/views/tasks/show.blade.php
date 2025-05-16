@extends('adminlte::page')
@extends('layouts.app')

@section('title', 'Task Details')

@section('content_header')
    <h1><i class="fas fa-tasks"></i> Task Details</h1>
@endsection


@section('content')
    <div class="container pb-5">
        <div class="task-card">
            <div class="task-header">
                <h2>{{ $task->title }}</h2>
                <span class="status label label-success">{{ ucfirst($task->status) }}</span>
            </div>
            <div class="task-body">
                <h4>Description:</h4>
                <p>{{ $task->description ?? 'No description available.' }}</p>

                <div class="task-details">
                    <p><strong>Priority:</strong> {{ $task->priority }}</p>
                    <p><strong>Due Date:</strong>
                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'Not set' }}</p>
                    <p><strong>Assigned To:</strong> {{ $task->assignedTo ? $task->assignedTo->name : 'Not assigned' }}</p>
                </div>

                <h4>Attachments:</h4>
                @if ($task->attachments->count() > 0)
                    <div class="attachments-list">
                        @foreach ($task->attachments as $attachment)
                            <div class="attachment-item">
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                    @if (in_array(pathinfo($attachment->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                            alt="{{ basename($attachment->file_path) }}" class="attachment-image">
                                    @else
                                        <i class="fa fa-file"></i> {{ basename($attachment->file_path) }}
                                    @endif
                                </a>
                                <!-- إضافة زر الحذف -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteAttachment('{{ $attachment->file_path }}')"><i
                                        class="fas fa-trash"></i> Delete</button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No attachments available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .task-card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .task-header h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .status {
            font-size: 16px;
            padding: 5px 15px;
            border-radius: 25px;
            background-color: #4CAF50;
            color: white;
        }

        .task-body h4 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .task-details p {
            font-size: 16px;
            color: #666;
        }

        /* تصميم المرفقات */
        .attachments-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .attachment-item {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .attachment-item a {
            text-decoration: none;
            color: #333;
            display: block;
            margin-bottom: 10px;
        }

        .attachment-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .attachment-item i {
            font-size: 15px;
            color: #aaa;
        }

        .delete-form {
            display: inline;
        }

        .btn-danger {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: #e63946;
        }
    </style>
@endpush


@push('js')
    <script>
        function deleteAttachment(filePath) {
            if (confirm("Are you sure you want to delete this attachment?")) {
                $.ajax({
                    url: '{{ route('tasks.deleteAttachment') }}',
                    method: 'POST', // تغيير method إلى POST
                    data: {
                        file_name: filePath,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`button[onclick="deleteAttachment('${filePath}')"]`).closest('.attachment-item').remove();
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
