<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Brief extends Model implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;
    use HasPanelShield;

    protected $fillable = [
        'title', 
        'description',
        'file', 
        'status', 
    ];
}
