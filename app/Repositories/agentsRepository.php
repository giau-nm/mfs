<?php

namespace App\Repositories;

use App\Models\agents;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class agentsRepository
 * @package App\Repositories
 * @version November 26, 2018, 10:18 pm +07
 *
 * @method agents findWithoutFail($id, $columns = ['*'])
 * @method agents find($id, $columns = ['*'])
 * @method agents first($columns = ['*'])
*/
class agentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'doanh_so',
        'ho_ten',
        'email',
        'so_dien_thoai'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return agents::class;
    }
}
