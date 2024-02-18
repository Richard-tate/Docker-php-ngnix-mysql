<?php

namespace App\Models\Users;

use Framework\Model;
class Users extends Model
{
    protected static string $table = 'users';
    protected static array $fillable = ['name', 'email', 'password'];
    private string $primaryKey = 'id';
}