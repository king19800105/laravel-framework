<?php


namespace App\Http\Controllers;


use App\Http\Requests\Permission\IndexRequest;
use App\Http\Requests\Permission\DestroyRequest;
use App\Http\Requests\Permission\StoreRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Http\Responders\NoneResponder;
use App\Http\Responders\Permission\IndexResponder;
use App\Services\PermissionService;


class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * 获取管理员列表
     *
     * @param IndexRequest $request
     * @return IndexResponder
     */
    public function index(IndexRequest $request)
    {
        $result = $this->permissionService->getPermissionList();
        return new IndexResponder($result);
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
        $this->permissionService->storePermission($data);
        return new NoneResponder();
    }

    /**
     * 修改
     *
     * @param UpdateRequest $request
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $this->permissionService->updatePermission($data, $id);
        return new NoneResponder();
    }

    /**
     * 删除
     *
     * @param DestroyRequest $request
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function destroy(DestroyRequest $request, $id)
    {
        $this->permissionService->deletePermission($id);
        return new NoneResponder();
    }
}
