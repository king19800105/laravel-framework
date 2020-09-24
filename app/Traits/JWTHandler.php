<?php


namespace App\Traits;


use App\Exceptions\AccountException;

/**
 * Trait JWTHandler
 * @package App\Traits
 */
trait JWTHandler
{
    protected $guard;

    protected $ttl;

    protected $claims;

    /**
     * @param null $guard
     * @return $this
     */
    public function setGuard($guard = null)
    {
        $this->guard = $guard;
        return $this;
    }

    /**
     * 设置token过期时间
     *
     * @param null $ttl
     * @return $this
     */
    public function setTTL($ttl = null)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * 设置自定义条件
     *
     * @param array $claims
     * @return $this
     */
    public function setClaims(array $claims = [])
    {
        $this->claims = $claims;
        return $this;
    }

    /**
     * 创建用户token
     *
     * @param array $data
     * @return array
     * @throws AccountException
     */
    public function createToken(array $data): array
    {
        $auth  = $this->getAuth();
        $token = $auth->attempt($data);
        if (!$token) {
            throw new AccountException(__('reason.account_err'));
        }

        return [
            'token'   => $token,
            'type'    => 'Bearer',
            'expires' => $auth->factory()->getTTL() * 60
        ];
    }

    /**
     * 根据用户id获取token
     *
     * @param $id
     * @return mixed
     */
    public function getTokenByUserId($id)
    {
        return $this->getAuth()->tokenById($id);
    }

    /**
     * 登出操作
     */
    public function logout()
    {
        $this->getAuth()->logout();
    }

    /**
     * 刷新token
     *
     * @param bool $isSetBlackList
     * @return array
     */
    public function refresh($isSetBlackList = false)
    {
        $auth  = $this->getAuth();
        $token = $auth->refresh($isSetBlackList, $isSetBlackList);
        return [
            'token'   => $token,
            'type'    => 'Bearer',
            'expires' => $auth->factory()->getTTL() * 60
        ];
    }

    /**
     * 把当前用户的token过期
     *
     * @param bool $isSetBlackList
     * @return mixed
     */
    public function invalidate($isSetBlackList = false)
    {
        return $this->getAuth()->invalidate($isSetBlackList);
    }

    /**
     * 根据token获取用户
     *
     * @param $token
     * @return mixed
     * @throws AccountException
     */
    public function getUserByToken($token)
    {
        $result = $this->getAuth()->setToken($token)->user();
        if (!$result) {
            throw new AccountException(__('reason.token_create_fail'));
        }

        return $result;
    }

    /**
     * 获取auth对象
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function getAuth()
    {
        $guard = $this->guard ?? 'web';
        $auth  = auth($guard);
        if ($this->ttl && is_int($this->ttl) && $this->ttl > 0) {
            $auth = $auth->setTTL($this->ttl);
        }

        if (!empty($this->claims)) {
            $auth->claims($this->claims);
        }

        return $auth;
    }
}
