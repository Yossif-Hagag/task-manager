<?php
// app/Http/Requests/TaskStoreRequest.php
namespace App\Http\Requests;

class TaskStoreRequest extends TaskRequest
{
    public function rules(): array
    {
        $rules = parent::rules(); // جلب القواعد المشتركة من TaskRequest

        // إضافة تحقق خاص بـ store (unique)
        $rules['title'] = 'required|string|max:255|unique:tasks,title';

        return $rules;
    }
}