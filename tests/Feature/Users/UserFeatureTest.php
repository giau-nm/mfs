<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Device;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class UserFeatureTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testGetFormChangeUserPermissionFromNormalUser()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_NORMAL
        ]);
        $this->be($user);

        $response = $this->get(route('users.formChangeUserPermission'));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testGetFormChangeUserPermissionFromAdminUser()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $response = $this->get(route('users.formChangeUserPermission'));
        $response->assertStatus(200);
        $response->assertViewIs('user.form_change_user_permission');
    }

    public function testPostChangeUserPermissionFromNormalUser()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_NORMAL,
        ]);
        $this->be($user);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => null,
            'listBecomeNormal'   => null,
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(302);
    }

    public function testPostChangeUserPermissionEmptyData()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => null,
            'listBecomeNormal'   => null,
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), '{"success":false,"message":""}');
    }

    public function testPostChangeUserPermissionWithDataIsCurrentUserInAdmin()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => [$user->id],
            'listBecomeNormal'   => null,
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), json_encode(
                [
                    'success' => false,
                    'message' => [
                        'listBecomeAdmin.0' => ['Giá trị đã chọn trong trường listBecomeAdmin.0 không hợp lệ.']
                    ]
                ])
        );
    }

    public function testPostChangeUserPermissionWithDataIsCurrentUserInNormal()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => null,
            'listBecomeNormal'   => [$user->id],
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), json_encode(
            [
                'success' => false,
                'message' => [
                    'listBecomeNormal.0' => ['Giá trị đã chọn trong trường listBecomeNormal.0 không hợp lệ.']
                ]
            ])
        );
    }

    public function testPostChangeUserPermissionWrongAdminUserId()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => [300],
            'listBecomeNormal'   => null,
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), json_encode(
            [
                'success' => false,
                'message' => [
                    'listBecomeAdmin.0' => ['Giá trị đã chọn trong trường listBecomeAdmin.0 không hợp lệ.']
                ]
            ])
        );
    }

    public function testPostChangeUserPermissionWrongNormalUserId()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => null,
            'listBecomeNormal'   => [300],
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), json_encode(
            [
                'success' => false,
                'message' => [
                    'listBecomeNormal.0' => ['Giá trị đã chọn trong trường listBecomeNormal.0 không hợp lệ.']
                ]
            ])
        );
    }

    public function testPostChangeUserPermissionUserBecomeAdmin()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $normalUser = factory(User::class)->create([
            'type' => User::TYPE_NORMAL,
        ]);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => [$normalUser->id],
            'listBecomeNormal'   => null,
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), '{"success":true,"message":""}');
        $this->assertDatabaseHas('users', ['id' => $normalUser->id, 'type' => User::TYPE_ADMIN]);
    }

    public function testPostChangeUserPermissionAdminBecomeNormal()
    {
        $user = factory(User::class, 2)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user[0]);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => null,
            'listBecomeNormal'   => [$user[1]->id],
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), '{"success":true,"message":""}');
        $this->assertDatabaseHas('users', ['id' => $user[1]->id, 'type' => User::TYPE_NORMAL]);
    }

    public function testPostChangeUserPermissionListUserBecomeAdmin()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user);

        $normalUser = factory(User::class, 2)->create([
            'type' => User::TYPE_NORMAL,
        ]);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => [$normalUser[0]->id, $normalUser[1]->id],
            'listBecomeNormal'   => null,
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), '{"success":true,"message":""}');
        $this->assertDatabaseHas('users', ['id' => $normalUser[1]->id, 'type' => User::TYPE_ADMIN]);
        $this->assertDatabaseHas('users', ['id' => $normalUser[0]->id, 'type' => User::TYPE_ADMIN]);
    }

    public function testPostChangeUserPermissionListAdminBecomeNormal()
    {
        $user = factory(User::class, 3)->create([
            'type' => User::TYPE_ADMIN,
        ]);
        $this->be($user[0]);

        $data = [
            '_token'        => csrf_token(),
            'listBecomeAdmin'    => null,
            'listBecomeNormal'   => [$user[1]->id, $user[2]->id],
        ];
        $response = $this->call('POST', route('users.postChangeUserPermission'), $data);
        $response->assertStatus(200);
        $this->assertSame($response->getContent(), '{"success":true,"message":""}');
        $this->assertDatabaseHas('users', ['id' => $user[1]->id, 'type' => User::TYPE_NORMAL]);
        $this->assertDatabaseHas('users', ['id' => $user[2]->id, 'type' => User::TYPE_NORMAL]);
    }

    public function testProfilePageNotLogin()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_NORMAL
        ]);
        $response = $this->get(route('users.profile', $user->id));
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testProfilePageLoginByUserNormal()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_NORMAL
        ]);
        $this->be($user);
        $userNormal = factory(User::class)->create([
            'type' => User::TYPE_NORMAL
        ]);

        $response = $this->get(route('users.profile', $userNormal->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testProfilePageLogin()
    {
        $user = factory(User::class)->create([
            'type' => User::TYPE_ADMIN
        ]);
        $this->be($user);
        $userNormal = factory(User::class)->create([
            'type' => User::TYPE_NORMAL
        ]);

        $response = $this->get(route('users.profile', $userNormal->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.profile');
    }
}
