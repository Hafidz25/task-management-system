<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brief extends Model implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;
    use HasPanelShield;

    protected $fillable = [
        'title', 
        'description',
        'file', 
        'user_id',
        'status', 
    ];

    protected $guard_name = 'web';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
