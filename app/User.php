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
        'classification',
        'sectionName',
        'is_teacher',
        'is_admin'
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
            $rules['password'] = 'sometimes|confirmed|max:255';
            $rules['id'] = 'exists:user,id';
            // $rules['username'] = 'exists:users,username,' . $request->get('id');
            $rules['username'] = 'sometimes|required|unique:users,id' . $request->get('id');
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

    public function updateFromRequest($request)
    {
        $rawPassword = $request->get('password');
        $this->fill($request->all());
        if ($rawPassword) {
            $this->password = bcrypt($rawPassword);
        }

        $this->save();
        if ($this->is_teacher) {
            $sectionIds = (array) $request->get('section_ids');
            $this->teacher_sections()->sync($sectionIds);
        }
        return $this;
    }

    public static function createFromRequest($request, $roleName = Role::STUDENT)
    {
        $rawPassword = $request->get('password');
        $role = Role::getByName($roleName);
        $user = new self();
        $user->fill($request->all());
        if ($rawPassword) {
            $user->password = bcrypt($rawPassword);
        }
        $user->save();
        $user->attachRole($role);

        if ($user->is_teacher) {
            $sectionIds = (array) $request->get('section_ids');
            $user->teacher_sections()->sync($sectionIds);
        }

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
        $userTests = $this->user_tests();
            if ($userTests) {
                return $userTests ->where('test_id', $test->id)
                ->get();
            }
        return null;
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
            ->where('type', Attendance::TYPE_LOGIN)
            ->whereDate('created_at', $date)->first();
        return (bool) $attendance;
    }

    public function getLoginByDate($date)
    {
        $attendance = Attendance::where('user_id', $this->id)
            ->where('type', Attendance::TYPE_LOGIN)
            ->whereDate('created_at', $date)->first();
        return $attendance;
    }

    public function getLogoutByDate($date)
    {
        $attendance = Attendance::where('user_id', $this->id)
            ->where('type', Attendance::TYPE_LOGOUT)
            ->whereDate('created_at', $date)->first();
        return $attendance;
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

    public function getSectionNameAttribute()
    {
        $section = Section::find($this->section_id);
        if ($section) {
            return $section->name;
        }
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

    public function teacher_sections()
    {
        return $this->belongsToMany('App\Section', 'teacher_sections', 'teacher_id', 'section_id');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================


}
