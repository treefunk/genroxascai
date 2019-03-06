<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Validator;
use App\Role;
use App\Attendance;
use App\Section;
use App\Classification;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable; 
    use EntrustUserTrait;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'birthdate',
        'address',
        'contact',
        'username',
        'password',
        'section_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
        'classification'
    ];


    // =============================================================================
    // QUERIES
    // =============================================================================

    public static function getByRoleName($name)
    {
        $role = Role::getByName($name);
        return self::withRole($role->name)->get();
    }

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    public static function validateRequest($request)
    {
        $rules = [
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            'gender' => 'required|max:255',
            'birthdate' => 'required|date',
            'address' => 'required|max:255',
            'contact' => 'required|max:255',
            'username' => 'required|unique:users,username|max:255',
            'password' => 'required|confirmed|max:255',
        ];

        if ($request->method() === 'PATCH' || $request->get('id')) {
            $rules['password'] = 'sometimes|required|confirmed|max:255';
            $rules['id'] = 'exists:user,id';
            $rules['username'] = 'exists:user,username,' . $request->get('id');
        }

        $validation = Validator::make($request->all(), $rules);
        return $validation->getMessageBag()->all();
    }

    // =============================================================================
    // UTILITIES
    // =============================================================================

    public function saveSection($section)
    {
        $this->section_id = $section->id;
        return $this->save();
    }

    public static function createFromRequest($request, $roleName = Role::STUDENT)
    {
        $role = Role::getByName($roleName);
        $user = new self();
        $user->fill($request->all());
        $user->save();
        $user->attachRole($role);
        return $user;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getHighestUserTestByTest($test)
    {
        $userTests = $this->getUserTestsByTest($test);
        return $userTests->sortByDesc('score')->first();
    }

    public function getUserTestsByTest($test)
    {
        return $this->user_tests($test)
            ->where('test_id', $test->id)
            ->get();
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first()->name;
    }

    public function getIsAdminAttribute()
    {
        return $this->role === Role::ADMIN;
    }

    public function getIsTeacherAttribute()
    {
        return $this->role === Role::TEACHER;
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . ' '  . substr( $this->middlename, 0, 1) . '. ' . $this->lastname;
    }

    public function isPresentByDate($date)
    {
        $attendance = Attendance::where('user_id', $this->id)
            ->whereDate('created_at', $date)->first();
        return (bool) $attendance;
    }

    public function getSectionAttribute()
    {
        $section = Section::find($this->section_id);
        if ($section) {
            return $section->name;
        }
    }

    public function getClassificationAttribute()
    {
        return Classification::getClassificationByUser($this);
    }

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function user_tests()
    {
        return $this->hasMany('App\UserTest');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================


}
