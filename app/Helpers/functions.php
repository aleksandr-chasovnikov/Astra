<?php

use App\Model\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('isAdmin')) {
    /**
     * @return bool
     */
    function isAdmin()
    {
        return User::ROLE_ADMIN === Auth::user()->role;
    }
}

if (!function_exists('isUser')) {
    /**
     * @return bool
     */
    function isUser()
    {
        return User::ROLE_USER === Auth::user()->role;
    }
}

if (!function_exists('isOwner')) {
    /**
     * @param $id
     *
     * @return bool
     */
    function isOwner($id)
    {
        return $id === Auth::id();
    }
}