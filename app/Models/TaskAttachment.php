<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class TaskAttachment extends Model
{
    use HasFactory; // Enables soft delete functionality

    protected $table = 'task_attachments'; // Explicitly defining table name (optional)

    protected $fillable = [
        'task_id',
        'file_path',
    ];

    /**
     * Get the task associated with this attachment.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    
    

    /**
     * Get the full URL of the stored file.
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }
}