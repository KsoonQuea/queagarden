<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPerson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contact_person';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'distributor_id'
    ];

    public $role = [
        0 => 'Boss',
        1 => 'Manager',
        2 => 'Staff'
    ];

    public function distributor() :BelongsTo {
        return $this->belongsTo(Distributor::class);
    }
}
