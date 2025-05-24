<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var string[]
     */
    protected $with = ['user'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'message',
        'response'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
