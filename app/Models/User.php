<?php

namespace app\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'users';

    use Notifiable;

    public const TYPE_ADMIN = 1;
    public const TYPE_NORMAL = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
        if ($this->type == self::TYPE_ADMIN) return true;
        return false;
    }

    public static function createIfNotExist($userData) {
        $email = $userData->email;
        $userRecord = User::where('email', $email)->first();

        if (is_null($userRecord)) {
            //create user
            $type = ($email == EMAIL_ADMIN_DEFAULT) ? self::TYPE_ADMIN : self::TYPE_NORMAL;
            $time = $carbon = Carbon::now()->format('Y-m-d H:i:s');
            $insertData = [
                'name' => $userData->name,
                'email' => $email,
                'type'  => $type,
                'password' => 'empty',
                'created_at' => $time,
                'updated_at' => $time,
            ];

            $id = self::insertGetId($insertData);
            $userRecord = self::find($id);
        }

        return $userRecord;
    }
}
