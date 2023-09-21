<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'parent_section_id',
    ];

    protected $appends = ['children'];

    public function getChildrenAttribute()
    {
        return Section::where('parent_section_id', $this->id)->get();
    }
}
