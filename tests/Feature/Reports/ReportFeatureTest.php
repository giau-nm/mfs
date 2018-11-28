<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Device;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReportFeatureTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListReportPage()
    {
        $response = $this->get('/reports');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    public function testDeleteReport()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $report = factory(\App\Models\Report::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->call('DELETE', route('reports.destroy', $report->id), ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('reports', ['deleted_at' => null, 'id' => $report->id]);
    }

    public function testDeleteReportFail()
    {
        $userReport = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $userLogin = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($userLogin);
        $report = factory(\App\Models\Report::class)->create([
            'user_id' => $userReport->id
        ]);

        $response = $this->call('DELETE', route('reports.destroy', $report->id), ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('reports', ['deleted_at' => null, 'id' => $report->id]);
    }

    public function testCreateReport()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $response = $this->call('GET', route('reports.create'), []);
        $response->assertStatus(200);
        $response->assertSee('name="project_id"');
        $response->assertSee('name="device_id"');
        $response->assertSee('name="content"');
        $response->assertSee(trans('report.title.create'));
    }

    public function testStoreReport()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $projectId = factory(\App\Models\Project::class)->create()->id;
        $deviceId = factory(\App\Models\Device::class)->create()->id;
        $data = [
            '_token'        => csrf_token(),
            'project_id'    => $projectId,
            'device_id'     => $deviceId,
            'content'       => 'test store report content',
        ];
        $response = $this->call('POST', route('reports.store'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('reports', ['project_id' => $projectId, 'device_id' => $deviceId]);
        $response->assertRedirect(route('reports.index'));
    }

    public function testStoreFailValidateReport()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);

        $deviceId = factory(\App\Models\Device::class)->create()->id;
        $data = [
            '_token'        => csrf_token(),
            'project_id'    => null,
            'device_id'     => $deviceId,
            'content'       => 'test store report content',
        ];
        $response = $this->call('POST', route('reports.store'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('reports', ['project_id' => null, 'device_id' => $deviceId]);
    }

    public function testShowReport()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $reports = factory(\App\Models\Report::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->call('GET', route('reports.show', $reports->id), []);
        $response->assertStatus(200);
        $response->assertSee('name="project_id"');
        $response->assertSee('name="device_id"');
        $response->assertSee('name="content"');
    }
}
