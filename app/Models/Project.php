<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * @package App\Models
 * @version August 9, 2018, 7:36 am UTC
 *
 * @property string name
 * @property integer manager
 */
class Project extends Model
{
    use SoftDeletes;

    public $table = 'projects';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'manager'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'manager' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'        => 'required|max:255|unique:projects,name',
        'manager'     => 'required|integer'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'manager', 'id');
    }

    public function projectManagerName() {
        $projectManager = $this->user;

        return (is_null($projectManager)) ? '' : $projectManager->name;
    }

    
}
