<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Device;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DeviceFeatureTest extends TestCase
{

    public function testListDevicePage()
    {
        $response = $this->get('/devices');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    public function testDeleteDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $device = factory(\App\Models\Device::class)->create();

        $response = $this->call('DELETE', route('devices.destroy', $device->id), ['_token' => csrf_token()]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('devices', ['deleted_at' => null, 'id' => $device->id]);
    }

    public function testChangeStatusDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $device = factory(\App\Models\Device::class)->create([
            'status' => 1
        ]);

        $response = $this->call('POST', route('devices.change-status', $device->id), ['_token' => csrf_token(), 'status' => 0]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('devices', ['status' => 1, 'id' => $device->id]);
        $this->assertDatabaseHas('devices', ['status' => 0, 'id' => $device->id]);
    }

    public function testCreateDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $response = $this->call('GET', route('devices.create'), []);
        $response->assertStatus(200);
        $response->assertSee('name="name"');
    }

    public function testStoreDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $data = [
            '_token' => csrf_token(),
            'name'        => 'Device 1',
            'code'        => 'DV-00012',
            'screen_size' => '400x200',
            'os' => 'Android',
            'type' => 'Phone',
            'manufacture' => 'Lenovo',
            'carrier' => '',
            'phone_number' => '',
            'imei' => '12312fsdfs',
            'udid' => 'sdfsdf',
            'serial' => '981231827391273',
            'status' => 2,
            'checked_at'      => \Carbon\Carbon::now()->toDateString()
        ];
        $response = $this->call('POST', route('devices.store'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('devices', ['name' => 'Device 1', 'code' => 'DV-00012']);
        $response->assertRedirect(route('devices.index'));
    }

    public function testStoreFailValidateDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $data = [
            '_token' => csrf_token(),
            'name'        => 'dfgdf',
            'code'        => '',
            'screen_size' => '400x200',
            'os' => 'Android',
            'type' => 'Phone',
            'manufacture' => 'Lenovo',
            'carrier' => '',
            'phone_number' => '',
            'imei' => '12312fsdfs',
            'udid' => 'sdfsdf',
            'serial' => '981231827391273',
            'status' => 2,
            'checked_at'      => \Carbon\Carbon::now()->toDateString()
        ];
        $response = $this->call('POST', route('devices.store'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('devices', ['name' => 'dfgdf', 'code' => '']);
        $response->assertSessionHasErrors(['code']);
    }

    public function testEditDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $device = factory(\App\Models\Device::class)->create();

        $response = $this->call('GET', route('devices.edit', $device->id), []);
        $response->assertStatus(200);
        $response->assertSee('name="name"');
    }

    public function testUpdateDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $device = factory(\App\Models\Device::class)->create([
            'name'        => 'Device 1',
            'code'        => 'DV-00012',
            'screen_size' => '400x200',
            'os' => 'Android',
            'type' => 'Phone',
            'manufacture' => 'Lenovo',
            'carrier' => '',
            'phone_number' => '',
            'imei' => '12312fsdfs',
            'udid' => 'sdfsdf',
            'serial' => '981231827391273',
            'status' => 2,
            'checked_at'      => \Carbon\Carbon::now()->toDateString()
        ]);

        $dataUpdate = [
            '_token' => csrf_token(),
            'name'        => 'Device 2',
            'code'        => 'DV-00012',
            'screen_size' => '400x200',
            'os' => 'Android',
            'type' => 'Phone',
            'manufacture' => 'Lenovo',
            'carrier' => '',
            'phone_number' => '',
            'imei' => '12312fsdfs',
            'udid' => 'sdfsdf',
            'serial' => '981231827391273',
            'status' => 2,
            'checked_at'      => \Carbon\Carbon::now()->toDateString()
        ];
        $response = $this->call('PUT', route('devices.update', $device->id), $dataUpdate);
        $response->assertStatus(302);
        $this->assertDatabaseHas('devices', ['name' => 'Device 2','code' => 'DV-00012']);
        $response->assertRedirect(route('devices.index'));
    }

    public function testUpdateFailValidateDevice()
    {
        $user = factory(\App\Models\User::class)->create([
            'type' => 1
        ]);
        $this->be($user);
        $device = factory(\App\Models\Device::class)->create([
            'name'        => 'Device 1',
            'code'        => 'DV-00012',
            'screen_size' => '400x200',
            'os' => 'Android',
            'type' => 'Phone',
            'manufacture' => 'Lenovo',
            'carrier' => '',
            'phone_number' => '',
            'imei' => '12312fsdfs',
            'udid' => 'sdfsdf',
            'serial' => '981231827391273',
            'status' => 2,
            'checked_at'      => \Carbon\Carbon::now()->toDateString()
        ]);
        $data = [
            '_token' => csrf_token(),
            'name'        => '',
            'code'        => 'DV-00012',
            'screen_size' => '400x200',
            'os' => 'Android',
            'type' => 'Phone',
            'manufacture' => 'Lenovo',
            'carrier' => '',
            'phone_number' => '',
            'imei' => '12312fsdfs',
            'udid' => 'sdfsdf',
            'serial' => '981231827391273',
            'status' => 2,
            'checked_at'      => \Carbon\Carbon::now()->toDateString()
        ];
        $response = $this->call('PATCH', route('devices.update', $device->id), $data);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('devices', ['name' => '', 'code' => 'DV-00012']);
        $response->assertSessionHasErrors(['name']);
    }

    // public function testItCanExportToCsv()
    // {
    //     $user = factory(\App\Models\User::class)->create([
    //         'type' => 1
    //     ]);
    //     $this->be($user);
    //     $devices = factory(\App\Models\Device::class, 30)->create();
    //     $response = $this->call('GET', route('devices.index'), ['export' => 1]);
    //     $response->assertStatus(200);
    //     $response->assertHeader('content-disposition', 'attachment; filename="Filename.csv"');
    //     $file = $response->getFile();
    //     $filename = $file->getPathname();
    // }

}
