<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

class RequestFeatureTest extends TestCase
{
    // use RefreshDatabase;

    protected $preserveGlobalState      = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    /**
     * Test index without login.
     *
     */
    public function testIndexWithoutLogin()
    {
        // When user has not login
        $response = $this->get('/requests');
        // Redirect to login page with mail
        $response->assertStatus(302)->assertLocation('/login');
    }

    // /**
    //  * Test index with normal user.
    //  *
    //  */
    public function testIndexWithNormalUser()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 0
        ]);
        $this->be($user);
        $response = $this->get('/requests');
        $response->assertStatus(200);
    }

    // /**
    //  * Test index with admin user.
    //  *
    //  */
    public function testIndexWithAdminUser()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $response = $this->get('/requests');
        $response->assertStatus(200);
    }

    public function testUpdateRequest()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $startTime = \Carbon\Carbon::now()->subDays(6)->toDateString();
        $endTime = \Carbon\Carbon::now()->subDays(5)->toDateString();
        $actualStartTime = \Carbon\Carbon::now()->subDays(4)->toDateString();
        $actualEndTime   = \Carbon\Carbon::now()->subDays(3)->toDateString();
        $request         = factory(\App\Models\Request::class)->create([
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'actual_start_time' => null,
            'actual_end_time' => null,
            'status' => STATUS_REQUEST_NEW,
            'device_id' => function () {
                return factory(\App\Models\Device::class)->create(['status' => STATUS_DEVICES_AVAIABLE])->id;
            },
        ]);
        $dataUpdate = [
            '_token'            => csrf_token(),
            'status'            => STATUS_REQUEST_ACCEPT,
            'is_long_time'      => 1,
            'start_time'        => $startTime,
            'actual_start_time' => $actualStartTime,
            'actual_end_time'   => $actualEndTime,
            'note'              => null
        ];
        $response = $this->json('PUT', route('requests.update', $request->id), $dataUpdate);
        $response->assertJson(['status' => STATUS_SUCCESS]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('requests', [
            'id'                => $request->id,
            'status'            => 2,
            'is_long_time'      => 1,
            'actual_start_time' => $actualStartTime,
            'actual_end_time'   => $actualEndTime,
        ]);
    }

    public function testUpdateFailRequest()
    {
        // Error actual_end_time, must >= actual_start_time
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $startTime = \Carbon\Carbon::now()->subDays(6)->toDateString();
        $endTime = \Carbon\Carbon::now()->subDays(5)->toDateString();
        $actualStartTime = \Carbon\Carbon::now()->subDays(4)->toDateString();
        $actualEndTime   = \Carbon\Carbon::now()->subDays(5)->toDateString();
        $request         = factory(\App\Models\Request::class)->create([
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'actual_start_time' => null,
            'actual_end_time' => null,
            'status' => 1
        ]);
        $dataUpdate = [
            '_token'            => csrf_token(),
            'status'            => 2,
            'is_long_time'      => 1,
            'start_time'        => $startTime,
            'actual_start_time' => $actualStartTime,
            'actual_end_time'   => $actualEndTime,
            'note'              => null
        ];
        $response = $this->json('PUT', route('requests.update', $request->id), $dataUpdate);
        $response->assertJson(['status' => STATUS_ERROR]);
        $this->assertDatabaseMissing('requests', [
            'id'                => $request->id,
            'actual_end_time'   => $actualEndTime,
        ]);
    }

    public function testDeleteRequest()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $request  = factory(\App\Models\Request::class)->create();
        $response = $this->call('DELETE', route('requests.destroy', $request->id), ['_token' => csrf_token()]);
        $response->assertStatus(302);
        $this->assertSoftDeleted('requests', ['id' => $request->id]);
        $response->assertRedirect(route('requests.index'));
    }

    public function testStoreRequestInListRequest()
    {
        $user = factory(User::class)->create([
            'type' => 0
        ]);
        $this->be($user);
        $startTime = \Carbon\Carbon::now()->toDateString();
        $endTime   = \Carbon\Carbon::now()->addDays(5)->toDateString();
        $projectId = factory(\App\Models\Project::class)->create()->id;
        $deviceId  = factory(\App\Models\Device::class)->create(['status' => STATUS_DEVICES_AVAIABLE])->id;
        $data   = [
            '_token'     => csrf_token(),
            'device_id'  => $deviceId,
            'project_id' => $projectId,
            'start_time' => $startTime,
            'end_time'   => $endTime,
        ];
        $response = $this->json('POST', route('requests.store'), $data);
        $response->assertJson(['status' => STATUS_SUCCESS]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('requests', [
            'status'       => 1,
            'is_long_time' => 0,
            'device_id'    => $deviceId,
            'project_id'   => $projectId,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
        ]);
    }

    public function testStoreFailRequestInListRequest()
    {
        $user = factory(User::class)->create([
            'type' => 0
        ]);
        $this->be($user);
        $startTime = \Carbon\Carbon::now()->toDateString();
        // Error end time >= star time
        $endTime   = \Carbon\Carbon::now()->subDay()->toDateString();
        $projectId = factory(\App\Models\Project::class)->create()->id;
        $deviceId  = factory(\App\Models\Device::class)->create(['status' => STATUS_DEVICES_AVAIABLE])->id;
        $data   = [
            '_token'     => csrf_token(),
            'device_id'  => $deviceId,
            'project_id' => $projectId,
            'start_time' => $startTime,
            'end_time'   => $endTime,
        ];
        $response = $this->json('POST', route('requests.store'), $data);
        $response->assertJson(['status' => STATUS_ERROR]);
        $this->assertDatabaseMissing('requests', [
            'status'       => 1,
            'is_long_time' => 0,
            'device_id'    => $deviceId,
            'project_id'   => $projectId,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
        ]);
    }

    public function testStoreRequestInListDevice()
    {
        $user = factory(User::class)->create([
            'type' => 0
        ]);
        $this->be($user);
        $startTime = \Carbon\Carbon::now()->toDateString();
        $endTime   = \Carbon\Carbon::now()->addDays(5)->toDateString();
        $projectId = factory(\App\Models\Project::class)->create()->id;
        $deviceId  = factory(\App\Models\Device::class)->create(['status' => STATUS_DEVICES_AVAIABLE])->id;
        $data   = [
            '_token'     => csrf_token(),
            'project_id' => $projectId,
            'start_time' => $startTime,
            'end_time'   => $endTime,
        ];
        $response = $this->json('POST', route('requests.store', ['device_id' => $deviceId]), $data);
        $response->assertJson(['status' => STATUS_SUCCESS]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('requests', [
            'status'       => 1,
            'is_long_time' => 0,
            'device_id'    => $deviceId,
            'project_id'   => $projectId,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
        ]);
    }

    public function testStoreFailRequestInListDevice()
    {
        $user = factory(User::class)->create([
            'type' => 0
        ]);
        $this->be($user);
        $startTime = \Carbon\Carbon::now()->toDateString();
        $endTime   = \Carbon\Carbon::now()->subDay()->toDateString();
        $projectId = factory(\App\Models\Project::class)->create()->id;
        $deviceId  = factory(\App\Models\Device::class)->create(['status' => STATUS_DEVICES_AVAIABLE])->id;
        $data   = [
            '_token'     => csrf_token(),
            'project_id' => $projectId,
            'start_time' => $startTime,
            'end_time'   => $endTime,
        ];
        $response = $this->json('POST', route('requests.store', ['device_id' => $deviceId]), $data);
        $response->assertJson(['status' => STATUS_ERROR]);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('requests', [
            'status'       => 1,
            'is_long_time' => 0,
            'device_id'    => $deviceId,
            'project_id'   => $projectId,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
        ]);
    }
}
