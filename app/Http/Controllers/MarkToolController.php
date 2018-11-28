<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkgroupsRequest;
use App\Http\Requests\UpdateWorkgroupsRequest;
use App\Repositories\WorkgroupsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MarkToolController extends AppBaseController
{
    /** @var  WorkgroupsRepository */
    private $workgroupsRepository;

    public function __construct(WorkgroupsRepository $workgroupsRepo)
    {
        $this->workgroupsRepository = $workgroupsRepo;
    }

    /**
     * Display a listing of the Workgroups.
     *
     * @param Request $request
     * @return Response
     */
    public function avg(Request $request)
    {

        return view('marktool.avg');
    }

    /**
     * Show the form for creating a new Workgroups.
     *
     * @return Response
     */
    public function mfs()
    {
        return view('marktool.mfs');
    }

    public function index()
    {
        return view('marktool.checktool');
    }

    public function markLog()
    {
        return view('marktool.markLog');
    }

    public function markLogMfs()
    {
        return view('marktool.markLogMfs');
    }

    public function reportAvg()
    {
        return view('marktool.reportAvg');
    }
    
    public function reportMfs()
    {
        return view('marktool.reportMfs');
    }
}
