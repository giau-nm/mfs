<?php

namespace App\Repositories;

use App\Models\Config;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Http\Validators\DeviceValidator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Repositories\AppRepository;
use Carbon\Carbon;

class ConfigRepository extends BaseRepository
{
    use AppRepository;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Config::class;
    }

    public static function getConfig()
    {
        $config = Config::first();
        if (is_null($config)) {
            Config::insert([
                'chatwork_room_id' => null,
                'chatwork_token' => null,
            ]);
        };
        return Config::first();
    }

    public function updateConfig($data)
    {
        $config = $this->getConfig();
        if (isset($data['chatwork_room_id'])) $config->chatwork_room_id = $data['chatwork_room_id'];
        if (isset($data['chatwork_token'])) $config->chatwork_token = $data['chatwork_token'];
        $config->save();
        return true;
    }
}
