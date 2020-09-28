<?php


namespace App\Http\Controllers;


use App\Events\AdminLoginEvent;
use App\Http\Requests\Login\AdminLoginRequest;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Login\RegisterRequest;
use App\Http\Responders\NoneResponder;
use App\Http\Responders\OriginalResponder;
use App\Services\UserService;
use App\Traits\JWTHandler;


class LoginController extends Controller
{
    use JWTHandler;

    protected const
        ADMIN_GUARD = 'admin', USER_GUARD = 'api';

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['only' => ['logout']]);
        $this->middleware('auth:admin', ['only' => ['adminLogout']]);
        $this->userService = $userService;
    }

    /**
     * 用户注册
     *
     * @param RegisterRequest $request
     * @return NoneResponder
     * @throws \Throwable
     */
    public function register(RegisterRequest $request)
    {
        // todo 缓存中校验验证码是否相同，然后执行后续操作
        $data = $request->validated();
        $this->userService->storeUser($data);
        return new NoneResponder();
    }

    /**
     * 用户登入
     *
     * @param LoginRequest $request
     * @return OriginalResponder
     * @throws \App\Exceptions\AccountException
     */
    public function login(LoginRequest $request)
    {
        $data   = $request->validated();
        $result = $this->getLoginInfoByGuard(self::USER_GUARD, $data);
        return new OriginalResponder($result);
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        $this
            ->setGuard(self::USER_GUARD)
            ->destroyToken();
        return new NoneResponder();
    }

    /**
     * 管理员登入
     *
     * @param AdminLoginRequest $request
     * @return OriginalResponder
     * @throws \App\Exceptions\AccountException
     */
    public function adminLogin(AdminLoginRequest $request)
    {
        $data   = $request->validated();
        $result = $this->getLoginInfoByGuard(self::ADMIN_GUARD, $data);
        event(new AdminLoginEvent($result));
        return new OriginalResponder($result);
    }

    /**
     * 管理员登出
     */
    public function adminLogout()
    {
        $this
            ->setGuard(self::ADMIN_GUARD)
            ->destroyToken();
        return new NoneResponder();
    }

    /**
     * 获取登入信息
     *
     * @param $guard
     * @param $data
     * @return array
     * @throws \App\Exceptions\AccountException
     */
    protected function getLoginInfoByGuard($guard, $data)
    {
        $result = $this
            ->setGuard($guard)
            ->createToken($data);

        ['token' => $token] = $result;
        $auth             = $this->getUserByToken($token);
        $result['mobile'] = $auth->mobile ?? '';
        $result['name']   = $auth->name ?? '';
        $result['email']  = $auth->email ?? '';

        return $result;
    }
}
