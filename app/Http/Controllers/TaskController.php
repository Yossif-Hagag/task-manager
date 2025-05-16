<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::withoutTrashed()->with(['assignedTo', 'attachments', 'comments'])->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all();

        return view('tasks.create', compact('users'));
    }

    public function store(TaskStoreRequest $request)
    {
        $task = Task::create($request->validated());

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = $file->getClientOriginalName();
                $newPath = 'attachments/tasks/'.$task->id;
                $path = $file->storeAs($newPath, $fileName, 'public');

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $task->load('attachments');
        $users = User::all();

        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = $file->getClientOriginalName();
                $newPath = 'attachments/tasks/'.$task->id;
                $path = $file->storeAs($newPath, $fileName, 'public');

                TaskAttachment::create([
                    'task_id' => $task->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function deleteAttachment(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
        ]);

        $attachment = TaskAttachment::where('file_path', $request->file_name)->first();

        if ($attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            $attachment->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
    }

    public function destroy(Task $task)
    {
        $task->attachments()->delete();
        $task->comments()->delete();

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'تم حذف المهمة بنجاح.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function tasks_archive()
    {
        $tasks = Task::onlyTrashed()->get();

        return view('tasks.archive', compact('tasks'));
    }

    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('tasks.archive')->with('success', 'تم استعادة المهمة بنجاح.');
    }

    public function forceDelete($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->attachments()->forceDelete();
        $task->comments()->forceDelete();
        $task->forceDelete();

        return redirect()->route('tasks.archive')->with('success', 'تم حذف المهمة نهائيًا.');
    }
}