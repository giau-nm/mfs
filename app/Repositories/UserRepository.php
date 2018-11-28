<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version November 26, 2018, 10:22 pm +07
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'phone',
        'nhom_tai_khoan',
        'remember_token',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
