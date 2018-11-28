<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Configs
 * @package App\Models
 * @version August 9, 2018, 9:13 am UTC
 *
 * @property integer id
 * @property varchar(50) chatwork_room_id
 * @property varchar(50) token_chatwork

 */
class Config extends Model
{
    use SoftDeletes;

    public $table = 'configs';
}
