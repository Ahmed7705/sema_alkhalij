<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Determine whether the user can view the company data.
     */
    public function view(User $user, Company $company): bool
    {
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return true;
        }

        return $user->company_id === $company->id;
    }

    /**
     * Determine whether the user can manage company operations.
     */
    public function update(User $user, Company $company): bool
    {
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return true;
        }

        return $user->company_id === $company->id && in_array($user->role, ['company_admin', 'company_operator']);
    }
}
