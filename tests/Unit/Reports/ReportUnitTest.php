<?php

namespace Tests\Unit\Reports;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Repositories\ReportRepository;
use App\Models\Report;
use Carbon\Carbon;

class ReportUnitTest extends TestCase
{
    protected $app;
    protected $userLoginId = null;
    protected $reportRepository = null;
    protected $modelLefJoinData = null;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public function setUp()
    {
        parent::setUp();
        $this->app = $this->createApplication();
        $this->reportRepository = new ReportRepository($this->app);
    }

    public function initialData()
    {
        factory(\App\Models\Report::class, 10)->create();
        $this->user = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_NORMAL
        ]);
        $this->userLoginId =$this->user->id;
        $this->fakeLoginWithid($this->userLoginId);
        factory(\App\Models\Report::class, 30)->create([
            'user_id' => $this->userLoginId,
        ]);
    }

    private function modelLeftJoin()
    {
        if (!is_null($this->modelLefJoinData)) return $this->modelLefJoinData;
        $this->modelLefJoinData = Report::select('reports.*')
            ->where('user_id', $this->userLoginId)
            ->leftJoin('projects', 'reports.project_id', '=', 'projects.id')
            ->leftJoin('devices', 'reports.device_id', '=', 'devices.id');
        return $this->modelLefJoinData;
    }

    public function testItCanShowListReportNormal()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate();
        $this->assertSame(count($listReports), PAGGING_NUMBER_DEFAULT);

        //Check data
        $listReportsCompare = $this->modelLeftJoin() ->paginate(PAGGING_NUMBER_DEFAULT);
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSortByCreatedDesc()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate('created_at', 'desc');
        $this->assertCount(PAGGING_NUMBER_DEFAULT, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->orderBy('reports.created_at', 'desc')
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'sort' => 'created_at',
                'order'=> 'desc'
            ]);
        $this->assertSame($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSortByCreatedAsc()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate('created_at', 'asc');
        $this->assertCount(PAGGING_NUMBER_DEFAULT, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->orderBy('reports.created_at', 'asc')
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'sort' => 'created_at',
                'order'=> 'asc'
            ]);
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSortByProjectNameDesc()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate('projects.name', 'desc');
        $this->assertCount(PAGGING_NUMBER_DEFAULT, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->orderBy('projects.name', 'desc')
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'sort' => 'projects.name',
                'order'=> 'desc'
            ]);
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSortByProjectNameASC()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate('projects.name', 'asc');
        $this->assertCount(PAGGING_NUMBER_DEFAULT, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->orderBy('projects.name', 'asc')
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'sort' => 'projects.name',
                'order'=> 'asc'
            ]);
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSortByDeviceNameDesc()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate('devices.name', 'desc');
        $this->assertCount(PAGGING_NUMBER_DEFAULT, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->orderBy('devices.name', 'desc')
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'sort' => 'devices.name',
                'order'=> 'desc'
            ]);
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSortByDeviceNameAsc()
    {
        $this->initialData();
        $listReports = $this->callqueryAndPaginate('devices.name', 'asc');
        $this->assertCount(PAGGING_NUMBER_DEFAULT, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->orderBy('devices.name', 'asc')
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'sort' => 'devices.name',
                'order'=> 'asc'
            ]);
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testItCanShowListReportSearchContent()
    {
        $this->initialData();

        //equal
        $time = strtotime(Carbon::now()->format('Y-m-d H:i:s'));
        $content = 'This is Content test ' . $time;
        factory(\App\Models\Report::class)->create([
            'user_id' => $this->userLoginId,
            'content' => $content
        ]);

        $listReports = $this->callqueryAndPaginate(null, null, null, $content);
        $this->assertCount(1, $listReports);
        $this->assertEquals($listReports[0]->content, $content);

        //like
        $listReports = $this->callqueryAndPaginate(null, null, null, $time);
        $this->assertCount(1, $listReports);
        $this->assertContains((string)$time , $listReports[0]->content);
    }

    public function testItCanShowListReportSearchCreatedAt()
    {
        $this->initialData();

        //equal
        $createdAt = Carbon::create(2020, 10, 10, 10, 10, 10)->format('Y-m-d H:i:s');
        factory(\App\Models\Report::class)->create([
            'user_id' => $this->userLoginId,
            'created_at' => $createdAt
        ]);
        $listReports = $this->callqueryAndPaginate(null, null, null, $createdAt);

        $this->assertCount(1, $listReports);
        $this->assertEquals($listReports[0]->created_at->format('Y-m-d H:i:s'), $createdAt);

        //like
        $listReports = $this->callqueryAndPaginate(null, null, null, '2020-10');
        foreach ($listReports as $key => $report) {
            $this->assertContains('2020-10-10', $report->created_at->format('Y-m-d H:i:s'));
        }
    }

    public function testItCanShowListReportSearchProjectName()
    {
        //create data test
        $this->initialData();
        $time = strtotime(Carbon::now()->format('Y-m-d H:i:s'));
        $projectName = 'Project name ' . $time;
        $projectId = factory(\App\Models\Project::class)->create([
            'name' => $projectName,
        ])->id;
        factory(\App\Models\Report::class)->create([
            'user_id' => $this->userLoginId,
            'project_id' => $projectId
        ]);

        //equal
        $listReports = $this->callqueryAndPaginate(null, null, null, $projectName);
        $this->assertCount(1, $listReports);
        $this->assertSame($listReports[0]->projectName(), $projectName);

        //like
        $listReports = $this->callqueryAndPaginate(null, null, null, $time);
        $this->assertCount(1, $listReports);
        $this->assertContains((string)$time, $listReports[0]->projectName());
    }

    public function testItCanShowListReportSearchDeviceName()
    {
        //create data test
        $this->initialData();
        $time = (string)strtotime(Carbon::now()->format('Y-m-d H:i:s'));
        $deviceName = 'name ' . $time;
        factory(\App\Models\Report::class)->create([
            'user_id' => $this->userLoginId,
            'device_id' => factory(\App\Models\Device::class)->create(['name' => $deviceName])->id
        ]);

        //equal
        $listReports = $this->callqueryAndPaginate(null, null, null, $deviceName);
        $this->assertCount(1, $listReports);
        $this->assertSame($listReports[0]->deviceName(), $deviceName);

        //like
        $listReports = $this->callqueryAndPaginate(null, null, null, $time);
        $this->assertCount(1, $listReports);
        $this->assertContains((string)$time, $listReports[0]->deviceName());
    }

    public function testItCanShowListReportFilterStatus()
    {
        $this->user = factory(\App\Models\User::class)->create([
            'type' => \App\Models\User::TYPE_NORMAL
        ]);
        $this->userLoginId = $this->user->id;
        $this->fakeLoginWithid($this->userLoginId);
        factory(\App\Models\Report::class, 12)->create([
            'user_id' => $this->userLoginId,
            'status'  => 1

        ]);
        factory(\App\Models\Report::class, 20)->create([
            'user_id' => $this->userLoginId,
            'status'  => 0

        ]);
        factory(\App\Models\Report::class, 20)->create([
            'user_id' => $this->userLoginId,
            'status'  => 2

        ]);
        $listReports = $this->callqueryAndPaginate(null, null, 1);
        $this->assertCount(12, $listReports);

        //Check data
        $listReportsCompare = $this->modelLeftJoin()
            ->where('reports.status', 1)
            ->paginate(PAGGING_NUMBER_DEFAULT)
            ->appends([
                'status' => 1,
            ]);;
        $this->assertEquals($listReportsCompare->toArray(), $listReports->toArray());
    }

    public function testGenerateSortUrl()
    {
        $request = new Request();
        $sortData = $this->reportRepository->generateSortUrl($request);
        $sortDataCompare = [
            "created_at" => [
                "url" => "http://:/?sort=created_at&order=asc",
                "class" => "sort-by",
            ],
            "projects.name" => [
                "url" => "http://:/?sort=projects.name&order=asc",
                "class" => "sort-by",
            ],
            "devices.name" => [
                "url" => "http://:/?sort=devices.name&order=asc",
                "class" => "sort-by",
            ],
            "users.name" => [
                "url" => "http://:/?sort=users.name&order=asc",
                "class" => "sort-by",
            ],
        ];

        $this->assertEquals($sortData, $sortDataCompare);
    }

    private function callqueryAndPaginate($sort = null, $order = null, $status = null, $find = null)
    {
        $request = new Request();

        if (!is_null($sort)) {
            $request->sort = $sort;
            $request->order = $order;
        };

        if (!is_null($status)) {
            $request->status = $status;
        };

        if (!is_null($find)) {
            $request->find = $find;
        };
        if (isset($this->user)) {
            $request->user = $this->user;
        }

        return $this->reportRepository->queryAndPaginate($request);
    }

}
