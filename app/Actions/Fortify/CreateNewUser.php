<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\model_has_role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'district' => ['required'],
            'taluka' => ['required'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'district_id' => $input['district'],
            'taluka_id' => $input['taluka'],
            'role_id' =>$input['role_id'],
        ]);   
        
        //$user_id = $user->id;
        
        Auth::login($user);

        $user_id = DB::table('users')->where('id', Auth::User()->id)->pluck('id')->first();

        $model_has_role = Model_has_role::create([
            'role_id' => $input['role_id'],
            'model_id' => $user_id,
        ]);
    }
}