<?php


namespace App\Http\Controllers;


use App\Http\Requests\Role\AssignRequest;
use App\Http\Requests\Role\DestroyRequest;
use App\Http\Requests\Role\IndexRequest;
use App\Http\Requests\Role\ShowRequest;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Responders\NoneResponder;
use App\Http\Responders\Role\IndexResponder;
use App\Http\Responders\Role\ShowResponder;
use App\Services\PermissionService;

class RoleController
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * 角色列表
     *
     * @param IndexRequest $request
     * @return IndexResponder
     */
    public function index(IndexRequest $request)
    {
        $result = $this->permissionService->getRoleList();
        return new IndexResponder($result);
    }

    /**
     * 角色显示详情
     *
     * @param ShowRequest $request
     * @param $id
     * @return ShowResponder
     */
    public function show(ShowRequest $request, $id)
    {
        $result = $this->permissionService->getRole($id);
        return new ShowResponder($result);
    }

    /**
     * 保存管理员
     *
     * @param StoreRequest $request
     * @return NoneResponder
     * @throws \Throwable
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $this->permissionService->storeRole($data);
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
        $data = $request->validated();
        $this->permissionService->updateRole($data, $id);
        return new NoneResponder();
    }

    /**
     * 删除角色
     *
     * @param DestroyRequest $request
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function destroy(DestroyRequest $request, $id)
    {
        $this->permissionService->deleteRole($id);
        return new NoneResponder();
    }

    /**
     * 角色分配权限
     *
     * @param AssignRequest $request
     * @return NoneResponder
     * @throws \Throwable
     */
    public function assign(AssignRequest $request)
    {
        [
            'id'             => $id,
            'permission_ids' => $permissionIds
        ] = $request->validated();
        $this->permissionService->assignPermissions($id, $permissionIds);
        return new NoneResponder();
    }
}
