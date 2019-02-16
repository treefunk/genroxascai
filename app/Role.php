<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    const ADMIN = 'admin';
    const TEACHER = 'teacher';
    const STUDENT = 'student';

    protected $fillable = [
        'name',
        'display_name'
    ];

    public static function getByName($name)
    {
    	return self::where('name', $name)->first();
    }
}