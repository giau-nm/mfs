<?php

namespace App\Repositories;

use App\Models\Project;
use InfyOm\Generator\Common\BaseRepository;
use App\Http\Validators\ProjectValidator;
use App\Repositories\AppRepository;

/**
 * Class ProjectRepository
 * @package App\Repositories
 * @version August 9, 2018, 7:36 am UTC
 *
 * @method Project findWithoutFail($id, $columns = ['*'])
 * @method Project find($id, $columns = ['*'])
 * @method Project first($columns = ['*'])
*/
class ProjectRepository extends BaseRepository
{
    use AppRepository;
    
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'manager'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Project::class;
    }

    public function validateCreateProject($params)
    {
        $projectValidator = new ProjectValidator();
        $validator = $this->checkValidator($params, $projectValidator->validate());

        if ($validator->fails()) {
            return ['status' => STATUS_ERROR, 'errors' => $validator->errors()];
        }
        return ['status' => STATUS_SUCCESS];
    }
}
