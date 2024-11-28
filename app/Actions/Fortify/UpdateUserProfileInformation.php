<?php

namespace App\Actions\Fortify;

use App\Models\User; // Ensure this import is correct for your application
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Session; // Import this for session handling

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  array<string, mixed>  $input
     */
    public function update(Authenticatable $user, array $input): void
    {
        // Debugging input to check the received data
        if ($input === null) {
            echo "No input provided.";
            return;
        }

        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        // Handle photo update if present
        if (isset($input['photo'])) {
            if ($user) {
                $user->updateProfilePhoto($input['photo']);
            } else {
                echo "User object is null, unable to update photo.";
            }
        }

        // Check if the email has changed and the user must verify it
        if ($user && $input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } elseif ($user) {
            $updated = $user->update([
                'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
            ]);

            // Check if the user data was updated successfully
            if ($updated) {
                // Trigger a success message using session or another method
                Session::flash('success', 'Profile information updated successfully.');
            } else {
                Session::flash('error', 'No changes detected or update failed.');
            }
        } else {
            Session::flash('error', 'User object is null, unable to update profile.');
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  array<string, mixed>  $input
     */
    protected function updateVerifiedUser(Authenticatable $user, array $input): void
    {
        if ($user) {
            $fullName = trim($input['first_name'] . ' ' . ($input['middle_name'] ?? '') . ' ' . $input['last_name']);

            $updated = $user->update([
                'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'email_verified_at' => null, // Set to null for re-verification
            ]);

            // Check if the user data was updated successfully
            if ($updated) {
                // Trigger a success message using session or another method
                Session::flash('success', 'Profile information updated successfully.');
            } else {
                Session::flash('error', 'No changes detected or update failed.');
            }

            $user->sendEmailVerificationNotification();
        } else {
            Session::flash('error', 'User object is null, unable to update verified user.');
        }
    }
}
