<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'firstname',
        'lastname',
        'email',
        'password',
        'role',
        'sector_id',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
