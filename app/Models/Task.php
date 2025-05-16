<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RahulHaque\Filepond\Traits\HasFilepond;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasFilepond;

    protected $casts = [
        'due_date' => 'date',
    ];

    protected $fillable = ['title', 'description', 'status', 'priority', 'due_date', 'assigned_to', 'created_by'];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }



    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
