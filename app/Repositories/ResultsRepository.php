<?php

namespace App\Repositories;

use App\Models\Results;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ResultsRepository
 * @package App\Repositories
 * @version November 26, 2018, 9:49 pm +07
 *
 * @method Results findWithoutFail($id, $columns = ['*'])
 * @method Results find($id, $columns = ['*'])
 * @method Results first($columns = ['*'])
*/
class ResultsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ma',
        'ten',
        'mo_ta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Results::class;
    }
}
