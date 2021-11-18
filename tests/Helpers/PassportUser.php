<?php

namespace Tests\Helpers;

use App\Models\User;
use Laravel\Passport\Passport;

class PassportUser
{
    /**
     * Gets passport logged in user.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     */

    public function __invoke(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
    {
        $user = User::factory()->make();
        Passport::actingAs($user);

        return $user;
    }
}
