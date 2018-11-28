<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Mail\ExpiredRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Request;
use App\Models\EmailHistory;
use App\Repositories\RequestRepository;
use App\Repositories\EmailHistoryRepository;
use Artisan;
use Carbon\Carbon;
use DB;

class ExpiredRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $app;

    protected $data;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public function setUp()
    {
        $this->app = $this->createApplication();
        parent::setUp();
        $this->data = $this->initData();
    }

    public function initData()
    {
        return factory(\App\Models\Request::class, 10)->states('expired')->create();
    }

    public function testGetExpiredRequest()
    {
        $requestRepository = new RequestRepository($this->app);
        $listExpiredRequests = $requestRepository->expiredRequests()->get();
        $this->assertCount(count($this->data->toArray()), $listExpiredRequests->toArray());
        $tmpExpiredRequestsId = $this->data->pluck('id');
        $tmpListExpiredRequestsId = $listExpiredRequests->pluck('id');
        $this->assertSame($tmpExpiredRequestsId->toArray(), $tmpListExpiredRequestsId->toArray());
        $this->assertTrue(true);
    }

    public function testEmailExpiredRequest()
    {
        Mail::fake();
        $requestRepository = new RequestRepository($this->app);
        $request           = $requestRepository->expiredRequests()->first();
        $user              = $request->user;
        $device            = $request->device;
        $project           = $request->project;
        Mail::to($user)->send(new ExpiredRequest($user, $request, $device, $project));
        Mail::assertQueued(ExpiredRequest::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        $this->assertTrue(true);
    }

    public function testEmailHistoryExpiredRequest()
    {
        $requestRepository      = new RequestRepository($this->app);
        $emailHistoryRepository = new EmailHistoryRepository($this->app);
        $expiredRequests        = $requestRepository->expiredRequests()->get();
        $emailHistories    = [];
        foreach ($expiredRequests as $request) {
            $user                       = $request->user;
            $device                     = $request->device;
            $project                    = $request->project;
            $emailHistory               = [];
            $emailHistory['user_id']    = $user->id;
            $emailHistory['user_email'] = $user->email;
            $emailHistory['type']       = EmailHistory::TYPE_EXPIRED_REQUEST;
            $emailHistory['status']     = EmailHistory::STATUS_SUCCESS;
            $emailHistories[]      = $emailHistory;
        }
        Artisan::call('email:expired-request');
        $actualEmailHistories =  $emailHistoryRepository->scopeQuery(function ($query) {
            return $query->select(['user_id', 'user_email', 'type', 'status']);
        })->get()->toArray();
        $this->assertCount(count($emailHistories), $actualEmailHistories);
        $this->assertSame($emailHistories, $actualEmailHistories);
        $this->assertTrue(true);
    }

    public function testCommandEmailExpiredRequest()
    {
        Artisan::call('email:expired-request');
        $resultAsText = rtrim(Artisan::output());
        $this->assertSame($resultAsText, EXPIRED_REQUEST_COMMAND_TEXT);
        $this->assertTrue(true);
    }
}
