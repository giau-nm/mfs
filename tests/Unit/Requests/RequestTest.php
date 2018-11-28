<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;
use App\Repositories\RequestRepository;
use Illuminate\Http\Request;
use Artisan;

class RequestTest extends TestCase
{
    // protected $preserveGlobalState = FALSE;
    // protected $runTestInSeparateProcess = TRUE;
    protected $app;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

    }

    public function setUp()
    {
        parent::setUp();
        $this->app = $this->createApplication();
        $this->user = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_ADMIN
        ]);
        factory(\App\Models\Request::class, 30)->create();
    }

    /**
     * Test order by status
     *
     * @return void
     */
    public function testShowListRequestSortByStatus()
    {
         //Create data sample
         $requestRepository = new RequestRepository($this->app);
         $requests = $requestRepository->orderBy('status', 'desc')->paginate(PAGGING_NUMBER_DEFAULT);
         $requests = $requests->toArray();

         //Call unit function
         $request        = new Request();
         $request->sort  = 'requests.status';
         $request->order = 'desc';
         $request->user = $this->user;
         $listRequests   = $requestRepository->list($request);
         $listRequests   = $listRequests->toArray();

         //Check total item for a page
         $this->assertCount(count($requests['data']), $listRequests['data']);

         // Check sort by ID desc
         $tmpRequest = collect($requests['data']);
         $tmpListId = $tmpRequest->pluck('id');
         $collectListRequests = collect($listRequests['data']);
         $listId = $collectListRequests->pluck('id');
         $this->assertSame($listId->toArray(), $tmpListId->toArray());
         $this->assertTrue(true);
    }

    /**
     * Test order by device name
     *
     * @return void
     */
    public function testShowListRequestSortByDeviceName()
    {
         //Create data sample
         $requestRepository = new RequestRepository($this->app);
         $requests = \App\Models\Request::join('devices', 'requests.device_id', '=', 'devices.id')
                    ->orderBy('devices.name', 'desc')->paginate(PAGGING_NUMBER_DEFAULT);
         $requests = $requests->toArray();

         //Call unit function
         $request        = new Request();
         $request->sort  = 'devices.name';
         $request->order = 'desc';
         $request->user = $this->user;
         $listRequests   = $requestRepository->list($request);
         $listRequests   = $listRequests->toArray();

         //Check total item for a page
         $this->assertCount(count($requests['data']), $listRequests['data']);

         // Check sort by ID desc
         $tmpRequest = collect($requests['data']);
         $tmpListId = $tmpRequest->pluck('id');
         $collectListRequests = collect($listRequests['data']);
         $listId = $collectListRequests->pluck('id');
         $this->assertSame($listId->toArray(), $tmpListId->toArray());
         $this->assertTrue(true);
    }

    /**
     * Test order by project name
     *
     * @return void
     */
    public function testShowListRequestSortByProjectName()
    {
         //Create data sample
         $requestRepository = new RequestRepository($this->app);
         $requests = \App\Models\Request::join('projects', 'requests.project_id', '=', 'projects.id')
                    ->orderBy('projects.name', 'desc')->paginate(PAGGING_NUMBER_DEFAULT);
         $requests = $requests->toArray();

         //Call unit function
         $request        = new Request();
         $request->sort  = 'projects.name';
         $request->order = 'desc';
         $request->user = $this->user;
         $listRequests   = $requestRepository->list($request);
         $listRequests   = $listRequests->toArray();

         //Check total item for a page
         $this->assertCount(count($requests['data']), $listRequests['data']);

         // Check sort by ID desc
         $tmpRequest = collect($requests['data']);
         $tmpListId = $tmpRequest->pluck('id');
         $collectListRequests = collect($listRequests['data']);
         $listId = $collectListRequests->pluck('id');
         $this->assertSame($listId->toArray(), $tmpListId->toArray());
         $this->assertTrue(true);
    }

    /**
     * Test order by user name
     *
     * @return void
     */
    public function testShowListRequestSortByUserName()
    {
         //Create data sample
         $requestRepository = new RequestRepository($this->app);
         $requests = \App\Models\Request::select('requests.*')
                    ->join('users', 'requests.user_id', '=', 'users.id')
                    ->orderBy('users.name', 'desc')->paginate(PAGGING_NUMBER_DEFAULT)->toArray();


         //Call unit function
         $request        = new Request();
         $request->sort  = 'users.name';
         $request->order = 'desc';
         $request->user  = $this->user;
         $listRequests   = $requestRepository->list($request);
         $listRequests   = $listRequests->toArray();

         //Check total item for a page
         $this->assertCount(count($requests['data']), $listRequests['data']);

         // Check sort by UserName desc
         $tmpListId = collect($requests['data'])->pluck('id')->toArray();
         $listId = collect($listRequests['data'])->pluck('id')->toArray();
         $this->assertSame($listId, $tmpListId);

    }

    /**
     * Test order by start time
     *
     * @return void
     */
    public function testShowListRequestSortStartTime()
    {
         //Create data sample
         $requestRepository = new RequestRepository($this->app);
         $requests = $requestRepository->orderBy('start_time', 'desc')->paginate(PAGGING_NUMBER_DEFAULT);
         $requests = $requests->toArray();
         //Get all list id to Array

         //Call unit function
         $request        = new Request();
         $request->sort  = 'start_time';
         $request->order = 'desc';
         $request->user  = $this->user;
         $listRequests   = $requestRepository->list($request);
         $listRequests   = $listRequests->toArray();

         //Check total item for a page
         $this->assertCount(count($requests['data']), $listRequests['data']);

         // Check sort by ID desc
         $tmpRequest = collect($requests['data']);
         $tmpListId = $tmpRequest->pluck('id');
         $collectListRequests = collect($listRequests['data']);
         $listId = $collectListRequests->pluck('id');
         $this->assertSame($listId->toArray(), $tmpListId->toArray());
         $this->assertTrue(true);
    }

    /**
     * Test order by end time
     *
     * @return void
     */
    public function testShowListRequestSortEndTime()
    {
         //Create data sample
         $requestRepository = new RequestRepository($this->app);
         $requests = $requestRepository->orderBy('end_time', 'desc')->paginate(PAGGING_NUMBER_DEFAULT);
         $requests = $requests->toArray();

         //Call unit function
         $request        = new Request();
         $request->sort  = 'end_time';
         $request->order = 'desc';
         $request->user = $this->user;
         $listRequests   = $requestRepository->list($request);
         $listRequests   = $listRequests->toArray();

         //Check total item for a page
         $this->assertCount(count($requests['data']), $listRequests['data']);

         // Check sort by ID desc
         $tmpRequest = collect($requests['data']);
         $tmpListId = $tmpRequest->pluck('id');
         $collectListRequests = collect($listRequests['data']);
         $listId = $collectListRequests->pluck('id');
         $this->assertSame($listId->toArray(), $tmpListId->toArray());
         $this->assertTrue(true);
    }

    public function testListDevicesByUserId()
    {
        $userNormal = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_NORMAL
        ]);
        $requestsFake = factory(\App\Models\Request::class, 30)->create([
            'user_id' => $userNormal->id,
            'status' => \App\Models\Request::ACCEPT_REQUEST,
            'actual_end_time' => null,
        ]);

        $requestRepository = new RequestRepository($this->app);

        $requests = $requestRepository->listDevicesByUserId($userNormal->id);
        $this->assertSame(30, $requests->total());
        $this->assertSame(PAGGING_NUMBER_DEFAULT, $requests->count());
    }

    public function testListDevicesByExpiredUserId()
    {
        $userNormal = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_NORMAL
        ]);
        $requestsFake = factory(\App\Models\Request::class, 30)->create([
            'user_id' => $userNormal->id,
            'status' => \App\Models\Request::ACCEPT_REQUEST,
            'actual_end_time' => null,
            'is_long_time' => 0,
            'end_time' => \Carbon\Carbon::yesterday()->toDateTimeString(),
        ]);

        $requestRepository = new RequestRepository($this->app);

        $requests = $requestRepository->listDevicesByExpiredUserId($userNormal->id);
        $this->assertSame(30, $requests->total());
        $this->assertSame(PAGGING_NUMBER_DEFAULT, $requests->count());
    }

    public function testListRequestByUserId()
    {
        $userNormal = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_NORMAL
        ]);
        $requestsFake = factory(\App\Models\Request::class, 30)->create([
            'user_id' => $userNormal->id,
            'status' => \App\Models\Request::NEW_REQUEST,
            'is_long_time' => 0,
            'end_time' => \Carbon\Carbon::tomorrow()->toDateTimeString(),
            'actual_end_time' => null,
            'actual_start_time' => null,
        ]);

        $requestRepository = new RequestRepository($this->app);

        $requests = $requestRepository->listRequestByUserId($userNormal->id);
        $this->assertSame(30, $requests->total());
        $this->assertSame(PAGGING_NUMBER_DEFAULT, $requests->count());
    }
}
