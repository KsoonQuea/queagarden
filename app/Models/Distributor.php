<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distributor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'distributors';

    protected $fillable = [
        'company_name',
        'company_email',
        'address',
        'company_phone'
    ];

    public function contact_person(): HasMany {
        return $this->hasMany(ContactPerson::class);
    }
}
