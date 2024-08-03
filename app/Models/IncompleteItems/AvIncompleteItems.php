<?php

namespace App\Models\IncompleteItems;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branches\Branches;

class AvIncompleteItems extends Model
{
    use HasFactory;

    protected $table = 'avincompleteitems';
    protected $fillable = ['itemId', 'title', 'createDate', 
    'userKey', 'userId', 'userPhone', 'userName', 'userEmail', 
    'processed', 'processDate', 'contact', 'contactDate', 'complete', 
    'completeDate', 'discard', 'discardDate', 'location', 'transitLocation', 
    'transitDate', 'comments', 'notified', 'noticeDate'];

    protected $casts = [
        'createDate' => 'date:Y-m-d',
        'processDate' => 'date:Y-m-d',
        'contactDate' => 'date:Y-m-d',
        'completeDate' => 'date:Y-m-d',
        'discardDate' => 'date:Y-m-d',
        'transitDate' => 'date:Y-m-d',
        'noticeDate' => 'date:Y-m-d',
    ];
    public function branch()
    {
        return $this->belongsTo(Branches::class, 'location');
    }
}
