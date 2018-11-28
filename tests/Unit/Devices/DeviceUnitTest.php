<?php

namespace Tests\Unit\Devices;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;

class DeviceUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $app;
    protected $tmpDevices;
    protected $userLogin;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public function setUp()
    {
        $this->app = $this->createApplication();
        parent::setUp();
    }

    public function initialData()
    {
        $this->userLogin = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_ADMIN
        ]);
        $this->be($this->userLogin);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItCanShowListDeviceSortByIdDesc()
    {
        $this->initialData();
        $this->tmpDevices = factory(\App\Models\Device::class, 30)->create();
        //Create data sample
        $deviceRepository = new DeviceRepository($this->app);

        $devices = collect($this->tmpDevices);
        $devices = $devices->sortByDesc('id');
        $devices = $devices->forPage(0, PAGGING_NUMBER_DEFAULT);
        $dataDevices = collect($devices->toArray());
        $dataDevices = $dataDevices->pluck('id')->toArray();
        //Call unit function
        $request = new Request();
        $request->sort = 'id';
        $request->order = 'desc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();
        $listDevices = collect($listDevices['data']);
        $listDevices = $listDevices->pluck('id')->toArray();

        //Check total item for a page
        $this->assertCount(count($dataDevices), $listDevices);

        // Check sort by ID desc
        $this->assertSame($dataDevices, $listDevices);
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByNameDesc()
    {
        $this->initialData();
        //Create data sample
        $listName = ['Camila Hermann', 'Danielle Smith Jr.', 'Dr. Mohammad Schiller Sr.', 'Logan Erdman', 'Odell Sporer'];
        $listData = [];
        foreach($listName as $name) {
            $listData[] = factory(\App\Models\Device::class)->create(['name' => $name]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'name';
        $request->order = 'desc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID desc
        $listNameSortDesc = collect($listData);
        $listNameSortDesc = $listNameSortDesc->sortByDesc('name');
        $listNameSortDesc = $listNameSortDesc->pluck('name', 'id');

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('name', 'id');
        $this->assertSame($listId->toArray(), $listNameSortDesc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByNameAsc()
    {
        $this->initialData();
        //Create data sample
        $listName = ['Camila Hermann', 'Danielle Smith Jr.', 'Dr. Mohammad Schiller Sr.', 'Logan Erdman', 'Odell Sporer'];
        $listData = [];
        foreach($listName as $name) {
            $listData[] = factory(\App\Models\Device::class)->create(['name' => $name]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'name';
        $request->order = 'asc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID asc
        $listNameSortAsc = collect($listData);
        $listNameSortAsc = $listNameSortAsc->sortBy('name');
        $listNameSortAsc = $listNameSortAsc->pluck('name', 'id');

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('name', 'id');
        $this->assertSame($listId->toArray(), $listNameSortAsc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByCheckedAtDesc()
    {
        $this->initialData();
        //Create data sample
        $listCheckedAt = ['2018-08-12 00:00:00', '2018-08-11 00:00:00', '2018-08-14 00:00:00', '2018-08-13 00:00:00', '2018-08-16 00:00:00', '2018-08-15 00:00:00', '2018-08-18 00:00:00', '2018-08-19 00:00:00', '2018-08-17 00:00:00'];
        $listData = [];
        foreach($listCheckedAt as $checkedAt) {
            $listData[] = factory(\App\Models\Device::class)->create(['checked_at' => $checkedAt]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'checked_at';
        $request->order = 'desc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID asc
        $listCheckedAtDesc = collect($listData);
        $listCheckedAtDesc = $listCheckedAtDesc->sortByDesc('checked_at');
        $listCheckedAtDesc = $listCheckedAtDesc->pluck('checked_at', 'id');

        $collectListDevices = collect($listDevices['data']);

        foreach ($listCheckedAtDesc as $id => $date) {
            $listCheckedAtDesc[$id] = $date->toDateTimeString();
        }

        $listId = $collectListDevices->pluck('checked_at', 'id');
        $this->assertSame($listId->toArray(), $listCheckedAtDesc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByCheckedAtAsc()
    {
        $this->initialData();
        //Create data sample
        $listCheckedAt = ['2018-08-12 00:00:00', '2018-08-11 00:00:00', '2018-08-14 00:00:00', '2018-08-13 00:00:00', '2018-08-16 00:00:00', '2018-08-15 00:00:00', '2018-08-18 00:00:00', '2018-08-19 00:00:00', '2018-08-17 00:00:00'];
        $listData = [];
        foreach($listCheckedAt as $checkedAt) {
            $listData[] = factory(\App\Models\Device::class)->create(['checked_at' => $checkedAt]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'checked_at';
        $request->order = 'asc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID asc
        $listCheckedAtDesc = collect($listData);
        $listCheckedAtDesc = $listCheckedAtDesc->sortBy('checked_at');
        $listCheckedAtDesc = $listCheckedAtDesc->pluck('checked_at', 'id');

        foreach ($listCheckedAtDesc as $id => $date) {
            $listCheckedAtDesc[$id] = $date->toDateTimeString();
        }

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('checked_at', 'id');
        $this->assertSame($listId->toArray(), $listCheckedAtDesc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByCreatedAtDesc()
    {
        $this->initialData();
        //Create data sample
        $listcreatedAt = ['2018-08-12 00:00:00', '2018-08-11 00:00:00', '2018-08-14 00:00:00', '2018-08-13 00:00:00', '2018-08-16 00:00:00', '2018-08-15 00:00:00', '2018-08-18 00:00:00', '2018-08-19 00:00:00', '2018-08-17 00:00:00'];
        $listData = [];
        foreach($listcreatedAt as $createdAt) {
            $listData[] = factory(\App\Models\Device::class)->create(['created_at' => $createdAt]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'created_at';
        $request->order = 'desc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID desc
        $listCreatedAtDesc = collect($listData);
        $listCreatedAtDesc = $listCreatedAtDesc->sortByDesc('created_at');
        $listCreatedAtDesc = $listCreatedAtDesc->pluck('created_at', 'id');
        $listCreatedAtDesc = $listCreatedAtDesc->map(function($value) {
            return $value->toDateTimeString();
        });

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('created_at', 'id');
        $this->assertSame($listId->toArray(), $listCreatedAtDesc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByCreatedAtAsc()
    {
        $this->initialData();
        //Create data sample
        $listcreatedAt = ['2018-08-12 00:00:00', '2018-08-11 00:00:00', '2018-08-14 00:00:00', '2018-08-13 00:00:00', '2018-08-16 00:00:00', '2018-08-15 00:00:00', '2018-08-18 00:00:00', '2018-08-19 00:00:00', '2018-08-17 00:00:00'];
        $listData = [];
        foreach($listcreatedAt as $createdAt) {
            $listData[] = factory(\App\Models\Device::class)->create(['created_at' => $createdAt]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'created_at';
        $request->order = 'asc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID asc
        $listCreatedAtDesc = collect($listData);
        $listCreatedAtDesc = $listCreatedAtDesc->sortBy('created_at');
        $listCreatedAtDesc = $listCreatedAtDesc->pluck('created_at', 'id');
        $listCreatedAtDesc = $listCreatedAtDesc->map(function($value) {
            return $value->toDateTimeString();
        });

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('created_at', 'id');
        $this->assertSame($listId->toArray(), $listCreatedAtDesc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByStatusDesc()
    {
        $this->initialData();
        //Create data sample
        $listStatus = [0, 2, 1, 1, 2, 0, 0, 1, 2];
        $listData = [];
        foreach($listStatus as $status) {
            $listData[] = factory(\App\Models\Device::class)->create(['status' => $status]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'status';
        $request->order = 'desc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID desc
        $listStatusDesc = collect($listData);
        $listStatusDesc = $listStatusDesc->sortByDesc('status');
        $listStatusDesc = $listStatusDesc->pluck('status', 'id');

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('status', 'id');
        $this->assertSame($listId->toArray(), $listStatusDesc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanShowListDeviceSortByStatusAsc()
    {
        $this->initialData();
        //Create data sample
        $listStatus = [0, 2, 1, 1, 2, 0, 0, 1, 2];
        $listData = [];
        foreach($listStatus as $status) {
            $listData[] = factory(\App\Models\Device::class)->create(['status' => $status]);
        }

        //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->sort = 'status';
        $request->order = 'asc';
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        //Check total item for a page
        $this->assertCount(count($listData), $listDevices['data']);

        // Check sort by ID asc
        $listStatusAsc = collect($listData);
        $listStatusAsc = $listStatusAsc->sortBy('status');
        $listStatusAsc = $listStatusAsc->pluck('status', 'id');

        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('status', 'id');
        $this->assertSame($listId->toArray(), $listStatusAsc->toArray());
        $this->assertTrue(true);
    }

    public function testItCanSearchDeviceByName()
    {
        $this->initialData();
        //Create data sample
        $nameSearch = 'le';
        $listName = ['Camila Hermann', 'Danielle Smith Jr.', 'Dr. Mohammad Schiller Sr.', 'Logan Erdman', 'Odell Sporer'];
        $listData = [];
        foreach($listName as $name) {
            $listData[] = factory(\App\Models\Device::class)->create(['name' => $name]);
        }
        $devices = collect($listData);
        $devices = $devices->filter(function ($item) use($nameSearch) {
            return (strstr($item->name, $nameSearch)) ? $item : false;
        });

        // //Call unit function
        $deviceRepository = new DeviceRepository($this->app);
        $request = new Request();
        $request->q = $nameSearch;
        $request->user = $this->userLogin;
        $listDevices = $deviceRepository->listDevices($request);
        $listDevices = $listDevices->toArray();

        // //Check total item for a page
        $this->assertCount($devices->count(), $listDevices['data']);

        $devices = $devices->sortByDesc('id')->pluck('name', 'id');

        // // Check sort by ID desc
        $collectListDevices = collect($listDevices['data']);
        $listId = $collectListDevices->pluck('name', 'id');
        $this->assertSame($listId->toArray(), $devices->toArray());
        $this->assertTrue(true);
    }

}
