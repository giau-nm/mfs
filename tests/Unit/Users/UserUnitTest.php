<?php

namespace Tests\Unit\Reports;

use app\Models\User;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Faker\Generator as Faker;
use App\Models\Report;
use Carbon\Carbon;

class UserUnitTest extends TestCase
{
    protected $app;
    protected $userLoginId = null;
    protected $userRepository = null;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public function setUp()
    {
        parent::setUp();
        $this->app = $this->createApplication();
        $this->userRepository = new UserRepository($this->app);
    }

    public function initData()
    {
        factory(\App\Models\User::class, 20)->create([
            'type' => User::TYPE_NORMAL
        ]);
        factory(\App\Models\User::class, 15)->create([
            'type' => User::TYPE_ADMIN
        ]);
    }

    public function testCallListNormalUser()
    {
        $this->initData();

        $listNormalUser = $this->userRepository->listNormalUser()->toArray();
        $this->assertCount(20, $listNormalUser);

        $listNormalUserCompare = User::where('type', User::TYPE_NORMAL)->pluck('name', 'id')->toArray();
        $this->assertSame($listNormalUser, $listNormalUserCompare);
    }

    public function testCallListAdminUser()
    {
        $this->initData();

        $userLoginId = factory(\App\Models\User::class)->create([
            'type' => User::TYPE_ADMIN
        ])->id;
        $this->fakeLoginWithid($userLoginId);

        $listAdminUser = $this->userRepository->listAdminUser()->toArray();
        $this->assertCount(15, $listAdminUser);

        $listAdminUserCompare = User::where('type', User::TYPE_ADMIN)
            ->where('id', '!=', $userLoginId)
            ->pluck('name', 'id')
            ->toArray();
        $this->assertSame($listAdminUser, $listAdminUserCompare);
    }

    public function testCanChangeUserPermissionNullListUserId()
    {
        $this->initData();

        $request = new Request();
        $request->listBecomeAdmin = null;
        $request->listBecomeNormal = null;

        $result = $this->userRepository->changeUserPermission($request);
        $expect = ['success' => false, 'message' => ''];

        $this->assertSame($result, $expect);
    }

    public function testCanChangeUserPermissionListAdminNotPassValidated()
    {
        $request = new Request();
        $request->listBecomeAdmin = [1, 2];
        $request->listBecomeNormal = null;

        factory(\App\Models\User::class)->create(['id' => 5]);
        factory(\App\Models\User::class)->create(['id' => 6]);
        factory(\App\Models\User::class)->create(['id' => 7]);
        factory(\App\Models\User::class)->create(['id' => 8]);
        factory(\App\Models\User::class)->create(['id' => 9]);
        $this->fakeLoginWithid(5);

        $result = $this->userRepository->changeUserPermission($request);
        $expectError = [
            'listBecomeAdmin.0' => ['Giá trị đã chọn trong trường listBecomeAdmin.0 không hợp lệ.'],
            'listBecomeAdmin.1' => ['Giá trị đã chọn trong trường listBecomeAdmin.1 không hợp lệ.']
        ];
        $this->assertSame($result['success'], false);
        $this->assertSame($result['message']->messages(), $expectError);
    }

    public function testCanChangeUserPermissionListNormalNotPassValidated()
    {
        $request = new Request();
        $request->listBecomeAdmin = null;
        $request->listBecomeNormal = [1, 2];

        factory(\App\Models\User::class)->create(['id' => 5]);
        factory(\App\Models\User::class)->create(['id' => 6]);
        factory(\App\Models\User::class)->create(['id' => 7]);
        factory(\App\Models\User::class)->create(['id' => 8]);
        factory(\App\Models\User::class)->create(['id' => 9]);
        $this->fakeLoginWithid(5);

        $result = $this->userRepository->changeUserPermission($request);
        $expectError = [
            'listBecomeNormal.0' => ['Giá trị đã chọn trong trường listBecomeNormal.0 không hợp lệ.'],
            'listBecomeNormal.1' => ['Giá trị đã chọn trong trường listBecomeNormal.1 không hợp lệ.']
        ];

        $this->assertSame($result['success'], false);
        $this->assertSame($result['message']->messages(), $expectError);
    }

    public function testCanChangeUserPermissionNotChangeCurrentUser()
    {
        $request = new Request();
        $request->listBecomeAdmin = null;
        $request->listBecomeNormal = [5];

        factory(\App\Models\User::class)->create(['id' => 5]);
        factory(\App\Models\User::class)->create(['id' => 6]);
        $this->fakeLoginWithid(5);

        $result = $this->userRepository->changeUserPermission($request);
        $expectError = ['listBecomeNormal.0' => ['Giá trị đã chọn trong trường listBecomeNormal.0 không hợp lệ.']];

        $this->assertSame($result['success'], false);
        $this->assertSame($result['message']->messages(), $expectError);
    }

    public function testCanChangeUserPermissionChangeNormalToAdmin()
    {
        $request = new Request();
        $request->listBecomeAdmin = [5, 6];
        $request->listBecomeNormal = null;

        factory(\App\Models\User::class)->create(['id' => 5, 'type' => User::TYPE_NORMAL]);
        factory(\App\Models\User::class)->create(['id' => 6, 'type' => User::TYPE_NORMAL]);
        factory(\App\Models\User::class)->create(['id' => 7]);
        factory(\App\Models\User::class)->create(['id' => 8]);
        factory(\App\Models\User::class)->create(['id' => 9]);

        $this->fakeLoginWithid(7);

        $result = $this->userRepository->changeUserPermission($request);

        $this->assertSame($result, ['success' => true, 'message' => '']);
        $this->assertDatabaseHas('users', ['id' => 5, 'type' => User::TYPE_ADMIN]);
        $this->assertDatabaseHas('users', ['id' => 6, 'type' => User::TYPE_ADMIN]);
    }

    public function testCanChangeUserPermissionChangeAdminToNormal()
    {
        $request = new Request();
        $request->listBecomeAdmin = null;
        $request->listBecomeNormal = [5, 6];

        factory(\App\Models\User::class)->create(['id' => 5, 'type' => User::TYPE_ADMIN]);
        factory(\App\Models\User::class)->create(['id' => 6, 'type' => User::TYPE_ADMIN]);
        factory(\App\Models\User::class)->create(['id' => 7]);
        factory(\App\Models\User::class)->create(['id' => 8]);
        factory(\App\Models\User::class)->create(['id' => 9]);

        $this->fakeLoginWithid(7);

        $result = $this->userRepository->changeUserPermission($request);

        $this->assertSame($result, ['success' => true, 'message' => '']);
        $this->assertDatabaseHas('users', ['id' => 5, 'type' => User::TYPE_NORMAL]);
        $this->assertDatabaseHas('users', ['id' => 6, 'type' => User::TYPE_NORMAL]);
    }

    public function testCanChangeUserPermissionCantnotChangeCurrentUserToNormal()
    {
        $request = new Request();
        $request->listBecomeAdmin = null;
        $request->listBecomeNormal = [5, 6];

        factory(\App\Models\User::class)->create(['id' => 5, 'type' => User::TYPE_ADMIN]);
        factory(\App\Models\User::class)->create(['id' => 6, 'type' => User::TYPE_ADMIN]);
        factory(\App\Models\User::class)->create(['id' => 7]);
        factory(\App\Models\User::class)->create(['id' => 8]);
        factory(\App\Models\User::class)->create(['id' => 9]);

        $this->fakeLoginWithid(5);
        $result = $this->userRepository->changeUserPermission($request);
        $expectError = ['listBecomeNormal.0' => ['Giá trị đã chọn trong trường listBecomeNormal.0 không hợp lệ.']];

        $this->assertSame($result['success'], false);
        $this->assertSame($result['message']->messages(), $expectError);
    }

    

}
