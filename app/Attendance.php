<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    const TYPE_LOGIN = "login";
    const TYPE_LOGOUT= "logout";

    public static function log($user, $type = self::TYPE_LOGIN)
    {
    	$attendance = self::where('user_id', $user->id)
    		->where('type',  $type)
    		->whereDate('created_at', Carbon::today())->first();

		if ($attendance) {
            $attendance->touch();
			return $attendance;
		}

		$attendance = new self();
		$attendance->user_id = $user->id;
		$attendance->type = $type;
		$attendance->save();
		return $attendance;
    }


    public function getLoginAttribute()
    {
    	return Carbon::parse($this->created_at)->format('Y-m-d h:m:s a');
    }

    public function getLogoutAttribute()
    {
    	return Carbon::parse($this->updated_at)->format('Y-m-d h:m:s a');
    }
}
