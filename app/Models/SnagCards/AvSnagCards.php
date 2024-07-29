<?php

namespace App\Models\SnagCards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branches\Branches;

class AvSnagCards extends Model
{
    use HasFactory;
    
    protected $fillable = ['userKey', 'userId', 'branch'];

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch','name');
    }
}
