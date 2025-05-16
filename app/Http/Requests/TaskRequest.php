<?php

// app/Http/Requests/TaskRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|integer|min:1|max:5',
            'due_date' => 'nullable|date|date_format:Y-m-d',
            'assigned_to' => 'nullable|exists:users,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ];
    }
}