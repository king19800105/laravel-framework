<?php


namespace App\Http\Controllers;


use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Responders\NoneResponder;
use App\Services\PermissionService;

class RoleController
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
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
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $this->permissionService->updateRole($data, $id);
        return new NoneResponder();
    }


}
