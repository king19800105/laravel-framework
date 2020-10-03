<?php

namespace App\Http\Controllers;


use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\PlayVideoRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\ViewDocRequest;
use App\Http\Responders\NoneResponder;
use App\Http\Responders\User\GetInfoResponder;
use App\Http\Responders\User\IndexResponder;
use App\Http\Responders\User\ShowResponder;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 用户列表
     *
     * @param IndexRequest $request
     * @return IndexResponder
     */
    public function index(IndexRequest $request)
    {
        $result = $this->userService->getUserList();
        return new IndexResponder($result);
    }

    /**
     * 用户详情
     *
     * @param ShowRequest $request
     * @param $id
     * @return ShowResponder
     */
    public function show(ShowRequest $request, $id)
    {
        $result = $this->userService->getUser($id);
        return new ShowResponder($result);
    }

    /**
     * 更新用户信息
     *
     * @param UpdateRequest $request
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $roleIds = $data['role_ids'] ?? [];
        $this->userService->updateUser($data, $id, $roleIds);
        return new NoneResponder();

    }

    /**
     * 获取用户信息
     *
     * @param Request $request
     * @return GetInfoResponder
     */
    public function getInfo(Request $request)
    {
        $info = $request->user();
        return new GetInfoResponder($info);
    }

    /**
     * 播放视频
     *
     * @param PlayVideoRequest $request
     */
    public function playVideo(PlayVideoRequest $request)
    {
        dd('Do Play ...');
    }

    /**
     * 浏览文档
     *
     * @param ViewDocRequest $request
     */
    public function viewDoc(ViewDocRequest $request)
    {
        dd('Do View ...');
    }

    /**
     * 删除用户
     *
     * @param $id
     * @return NoneResponder
     * @throws \Throwable
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return new NoneResponder();
    }
}
