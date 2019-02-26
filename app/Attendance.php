<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    

    public static function log($user)
    {
    	$attendance = self::where('user_id', $user->id)
    		->whereDate('created_at', Carbon::today())->first();
		if ($attendance) {
			return $attendance;
		}

		$attendance = new self();
		$attendance->user_id = $user->id;
		$attendance->save();
		return $attendance;
    }
}
