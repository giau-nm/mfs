<?php

namespace App\Repositories;

use App\Models\EmailHistory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EmailHistoryRepository
 * @package App\Repositories
 *
*/
class EmailHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'user_email',
        'type',
        'status',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EmailHistory::class;
    }
}
