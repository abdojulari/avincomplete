<?php

namespace App\Models\DiscardCards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branches\Branches;

class AvDiscardCards extends Model
{
    use HasFactory;

    protected $fillable = ['userKey', 'userId', 'branch'];

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch','name');
    }
}
