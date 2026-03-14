<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Available roles for comprehensive business management
     * - admin: Business owner with full access
     * - manager: Store manager with most permissions (includes inventory management)
     * - cashier: POS and sales only
     * - customer: Browse products, place orders, track orders
     * - delivery_staff: Delivery assignments and status updates
     * - supplier: View purchase orders, update delivery status, confirm stock
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_CASHIER = 'cashier';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_DELIVERY_STAFF = 'delivery_staff';
    const ROLE_SUPPLIER = 'supplier';

    /**
     * Available languages
     */
    const LANGUAGE_ENGLISH = 'en';
    const LANGUAGE_AMHARIC = 'am';
    const LANGUAGE_OROMO = 'or';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
        'language',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is admin (business owner)
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is manager
     */
    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    /**
     * Check if user is cashier
     */
    public function isCashier(): bool
    {
        return $this->role === self::ROLE_CASHIER;
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    /**
     * Check if user is delivery staff
     */
    public function isDeliveryStaff(): bool
    {
        return $this->role === self::ROLE_DELIVERY_STAFF;
    }

    /**
     * Check if user is supplier
     */
    public function isSupplier(): bool
    {
        return $this->role === self::ROLE_SUPPLIER;
    }

    /**
     * Check if user can access POS
     */
    public function canAccessPOS(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_CASHIER]);
    }

    /**
     * Check if user can manage inventory
     */
    public function canManageInventory(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER]);
    }

    /**
     * Check if user can view reports
     */
    public function canViewReports(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER]);
    }

    /**
     * Check if user can manage suppliers
     */
    public function canManageSuppliers(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER]);
    }

    /**
     * Check if user can manage orders
     */
    public function canManageOrders(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER]);
    }

    /**
     * Check if user can manage deliveries
     */
    public function canManageDeliveries(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_DELIVERY_STAFF]);
    }

    /**
     * Check if user can view purchase orders
     */
    public function canViewPurchaseOrders(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_SUPPLIER]);
    }

    /**
     * Check if user can manage users
     */
    public function canManageUsers(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user can access customer data
     */
    public function canAccessCustomerData(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_CUSTOMER]);
    }

    /**
     * Check if user can view own data only (customer restriction)
     */
    public function canViewOwnDataOnly(): bool
    {
        return in_array($this->role, [self::ROLE_CUSTOMER, self::ROLE_SUPPLIER, self::ROLE_DELIVERY_STAFF]);
    }

    /**
     * Get all available roles
     */
    public static function getAllRoles(): array
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_MANAGER => 'Manager',
            self::ROLE_CASHIER => 'Cashier',
            self::ROLE_CUSTOMER => 'Customer',
            self::ROLE_DELIVERY_STAFF => 'Delivery Staff',
            self::ROLE_SUPPLIER => 'Supplier',
        ];
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName(): string
    {
        return self::getAllRoles()[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Get sales made by this user
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get supplier profile if user is a supplier
     */
    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    /**
     * Get available languages
     */
    public static function getAvailableLanguages(): array
    {
        return [
            self::LANGUAGE_ENGLISH => 'English',
            self::LANGUAGE_AMHARIC => 'አማርኛ (Amharic)',
            self::LANGUAGE_OROMO => 'Afaan Oromoo (Oromo)',
        ];
    }

    /**
     * Check if language is valid
     */
    public static function isValidLanguage(string $language): bool
    {
        return in_array($language, [self::LANGUAGE_ENGLISH, self::LANGUAGE_AMHARIC, self::LANGUAGE_OROMO]);
    }
}
