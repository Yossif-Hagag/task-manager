<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskComment extends Model
{
    use HasFactory;

    protected $table = 'task_comments'; // Explicitly defining table name (optional)

    protected $fillable = [
        'task_id',
        'user_id',
        'comment'
    ];

    /**
     * Get the task that this comment belongs to.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who made the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}