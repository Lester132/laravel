<?php

namespace App\Actions\Fortify;

use Illuminate\Foundation\Auth\User as Authenticatable; // Import this if necessary
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    /**
     * Validate and reset the user's password.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  array<string, string>  $input
     */
    public function reset(Authenticatable $user, array $input): void
    {
        Validator::make($input, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validateWithBag('resetPassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
