<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'title',
        'description',
        'is_done',
    ];

    protected $casts = [
        'is_done'    => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    /** 関係（Task は User に属する） */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
