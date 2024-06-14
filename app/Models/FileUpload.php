<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $fillable = [
        'user_id', 'file_name', 'table_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
