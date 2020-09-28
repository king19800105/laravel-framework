<?php


namespace App\Http\Controllers;


use App\Exceptions\AccountException;
use App\Http\Requests\Password\ForgetPasswordRequest;
use App\Http\Requests\Password\ResetPasswordRequest;
use App\Http\Responders\NoneResponder;
use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    protected $userService;

    protected $adminService;

    public function __construct(UserService $userService, AdminService $adminService)
    {
        $this->middleware('auth:api', ['only' => ['resetPassword']]);
        $this->middleware('auth:admin', ['only' => ['adminResetPassword']]);
        $this->userService  = $userService;
        $this->adminService = $adminService;
    }

    /**
     * 重置密码
     *
     * @param ResetPasswordRequest $request
     * @return NoneResponder
     * @throws AccountException
     * @throws \Throwable
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        [
            'old_password' => $oldPassword,
            'password'     => $password
        ] = $request->validated();
        $user = $request->user();
        $this->verifyResetPassword($oldPassword, $password, $user->password);
        $this->userService->updateUser(['password' => $password], $user->id);
        return new NoneResponder();
    }

    /**
     * 忘记密码
     *
     * @param ForgetPasswordRequest $request
     * @return NoneResponder
     * @throws AccountException
     * @throws \Throwable
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        // todo... 发送短信，获取短信验证码，然后修改，需缓存校手机号关联收到的验证码是否一致
        [
            'mobile'   => $mobile,
            'password' => $password
        ] = $request->validated();
        $user = $this->userService->getUserByMobile($mobile);
        if (!$user) {
            throw new AccountException(__('reason.unknown_err'));
        }

        if (Hash::check($password, $user->password)) {
            throw new AccountException(__('reason.same_password'));
        }

        $this->userService->updateUser(['password' => $password], $user->id);
        return new NoneResponder();
    }

    /**
     * 管理员重置密码
     *
     * @param ResetPasswordRequest $request
     * @return NoneResponder
     * @throws AccountException
     * @throws \Throwable
     */
    public function adminResetPassword(ResetPasswordRequest $request)
    {
        [
            'old_password' => $oldPassword,
            'password'     => $password
        ] = $request->validated();
        $admin = $request->user();
        $this->verifyResetPassword($oldPassword, $password, $admin->password);
        $this->adminService->updateAdmin(['password' => $password], $admin->id);
        return new NoneResponder();
    }

    /**
     * 校验重置密码
     *
     * @param $oldPassword
     * @param $newPassword
     * @param $hashPassword
     * @throws AccountException
     */
    protected function verifyResetPassword($oldPassword, $newPassword, $hashPassword)
    {
        if (!Hash::check($oldPassword, $hashPassword)) {
            throw new AccountException(__('reason.old_password_err'));
        }

        if ($oldPassword === $newPassword) {
            throw new AccountException(__('reason.same_password'));
        }
    }
}
