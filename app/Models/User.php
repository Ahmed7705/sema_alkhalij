<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'google_id',
        'apple_id',
        'verification_code',
        'code_expires_at',
        'email_verified_at',
        'password',
        'role',
        'company_id',
        'identification_type',
        'identification_number',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'code_expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole(string $roleSlug): bool
    {
        if ($this->role === $roleSlug || $this->role === 'admin') {
            return true;
        }
        return $this->roles->pluck('slug')->contains($roleSlug);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'admin' || $this->role === 'super_admin';
    }

    public function hasPermission(string $permissionSlug): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->permissions->pluck('slug')->contains($permissionSlug)) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer' || $this->role === null;
    }

    public function staffProfile()
    {
        return $this->hasOne(StaffProfile::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager', 'admin', 'super_admin']);
    }

    public function deviceTokens()
    {
        return $this->hasMany(UserDeviceToken::class);
    }

    public function notificationPreferences()
    {
        return $this->hasMany(NotificationPreference::class);
    }

    public function communicationLogs()
    {
        return $this->hasMany(CommunicationLog::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}

