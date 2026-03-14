<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'credit_limit',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function hasAvailableCredit(float $amount): bool
    {
        if ($this->credit_limit === null) {
            return true;
        }
        
        $usedCredit = $this->orders()
            ->where('status', 'pending')
            ->sum('total');
            
        return ($this->credit_limit - $usedCredit) >= $amount;
    }
}
