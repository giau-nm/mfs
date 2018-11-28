<?php

namespace App\Repositories;

use App\Models\Workgroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class WorkgroupsRepository
 * @package App\Repositories
 * @version November 26, 2018, 10:16 pm +07
 *
 * @method Workgroups findWithoutFail($id, $columns = ['*'])
 * @method Workgroups find($id, $columns = ['*'])
 * @method Workgroups first($columns = ['*'])
*/
class WorkgroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ten',
        'tieu_de',
        'mo_ta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Workgroups::class;
    }
}
