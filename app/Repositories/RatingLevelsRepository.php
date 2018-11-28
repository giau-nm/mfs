<?php

namespace App\Repositories;

use App\Models\RatingLevels;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RatingLevelsRepository
 * @package App\Repositories
 * @version November 26, 2018, 9:47 pm +07
 *
 * @method RatingLevels findWithoutFail($id, $columns = ['*'])
 * @method RatingLevels find($id, $columns = ['*'])
 * @method RatingLevels first($columns = ['*'])
*/
class RatingLevelsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ma',
        'ten',
        'diem_tu',
        'diem_den',
        'mo_ta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RatingLevels::class;
    }
}
