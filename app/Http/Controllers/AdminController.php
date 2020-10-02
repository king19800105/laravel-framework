<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\IndexRequest;
use App\Http\Requests\Admin\ShowRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Http\Responders\Admin\IndexResponder;
use App\Http\Responders\Admin\ShowResponder;
use App\Http\Responders\NoneResponder;
use App\Services\AdminService;

class AdminController extends Controller
{
    /**
     * @var AdminService
     */
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * 管理员列表
     *
     * @param IndexRequest $request
     * @return IndexResponder
     */
    public function index(IndexRequest $request)
    {
        $result = $this->adminService->getAdminList();
        return new IndexResponder($result);
    }

    /**
     * 管理员详情
     *
     * @param ShowRequest $request
     * @param $id
     * @return ShowResponder
     */
    public function show(ShowRequest $request, $id)
    {
        $result = $this->adminService->getAdmin($id);
        return new ShowResponder($result);
    }

    /**
     * 创建管理员
     *
     * @param StoreRequest $request
     * @return NoneResponder
     * @throws \Throwable
     */
    public function store(StoreRequest $request)
    {
        $data    = $request->validated();
        $roleIds = $data['role_ids'] ?? [];
        $this->adminService->storeAdmin($data, $roleIds);
        return new NoneResponder();
    }

    /**
     * 修改管理员
     *
     * @param UpdateRequest $request
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function update(UpdateRequest $request, $id)
    {
        $data    = $request->validated();
        $roleIds = $data['role_ids'] ?? [];
        $this->adminService->updateAdmin($data, $id, $roleIds);
        return new NoneResponder();
    }

    /**
     * 删除管理员（软删除）
     *
     * @param DestroyRequest $request
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function destroy(DestroyRequest $request, $id)
    {
        $this->adminService->deleteAdmin($id);
        return new NoneResponder();
    }

}
