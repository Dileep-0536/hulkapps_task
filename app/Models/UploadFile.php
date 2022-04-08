<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    use HasFactory;

    protected $table = "upload_files";

    //fillable properties
    protected $fillable = ['document_name','user_id'];

    // tags relationship
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
