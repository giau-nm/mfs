<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Manh GIAU
 * Date: 9/13/2018
 * Time: 2:00 PM
 */

namespace App\Http\Controllers;

use App\Repositories\ConfigRepository;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ConfigController extends AppBaseController
{
    public function __construct(ConfigRepository $configRepo, UserRepository $userRepo)
    {
        $this->configRepository = $configRepo;
        $this->userRepository = $userRepo;
    }

    public function index()
    {
        $pageTitle = trans('label.configs.lbl_config_heading');
        $config = $this->configRepository->getConfig();
        $listNormalUser = $this->userRepository->listNormalUser();
        $listAdminlUser = $this->userRepository->listAdminUser();

        return view('configs.index', compact('pageTitle', 'config', 'listNormalUser', 'listAdminlUser'));
    }

    public function update($_id, Request $request)
    {
        $this->configRepository->updateConfig($request->all());
        Flash::success(trans('label.configs.msg_update_success'));

        return redirect(route('configs.index'));
    }
}