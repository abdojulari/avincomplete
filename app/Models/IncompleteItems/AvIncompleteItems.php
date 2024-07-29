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

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'location');
    }
}
