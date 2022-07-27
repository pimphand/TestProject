<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['group'];

    public function group(): BelongsTo
    {
        return $this->BelongsTo(Group::class);
    }
}
