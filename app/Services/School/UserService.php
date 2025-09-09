<?php

namespace App\Services\School;

use App\Models\User;

class UserService
{
    public function __construct()
    {
        //
    }

    public function create($data)
    {
        $user = User::create($data);
        $user->addRole($data['role']);
        return $user;
    }

    public function update($data, $id)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->restore();
        return $user;
    }
}
