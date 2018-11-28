<?php

namespace App\Repositories;

use App\Models\Mistakes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MistakesRepository
 * @package App\Repositories
 * @version November 26, 2018, 9:51 pm +07
 *
 * @method Mistakes findWithoutFail($id, $columns = ['*'])
 * @method Mistakes find($id, $columns = ['*'])
 * @method Mistakes first($columns = ['*'])
*/
class MistakesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ten',
        'mo_ta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Mistakes::class;
    }
}
