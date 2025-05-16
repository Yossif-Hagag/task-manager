<?php

// app/Http/Requests/TaskUpdateRequest.php
namespace App\Http\Requests;

class TaskUpdateRequest extends TaskRequest
{
    public function rules(): array
    {
        $rules = parent::rules(); // جلب القواعد المشتركة من TaskRequest

        // إضافة تحقق خاص بـ update (استبعاد الـ title الحالي من الـ unique)
        $rules['title'] = 'required|string|max:255|unique:tasks,title,' . $this->route('task')->id;

        return $rules;
    }
}