<?php


namespace App\Exceptions;


use Error;
use GuzzleHttp\Exception\ConnectException as GuzzleHttpConnectionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\ConnectionException as HttpConnectionException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Arr;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Exception;
use ErrorException;
use App\Traits\FormatResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


abstract class BaseException extends Exception
{
    use FormatResponse;

    /**
     * 标记
     */
    protected const
        CODE = 'code', MESSAGE = 'message', DEFAULT = 'default', DATA = 'data';

    /**
     * 错误原因格式化
     */
    protected const
        FORMAT_REASON = '%s，原因：%s', UNKNOWN_REASON = '未知';

    protected const
        ERROR_CODE = 1001,
        ERROR_PARAMS_CODE = 1422,
        ERROR_AUTHENTICATION_CODE = 1403,
        ERROR_UNAUTHORIZED_CODE = 1401,
        ERROR_NOT_FIND_CODE = 1404,
        ERROR_METHOD_NOT_ALLOW_CODE = 1405,
        ERROR_HTTP_TIME_OUT_CODE = 1408,
        ERROR_TOO_MANY_REQUESTS_CODE = 1429,
        DEFAULT_ERROR_CODE = 1999;


    protected const
        DEFAULT_ERROR_MESSAGE = '系统异常，请联系管理员',
        ERROR_MESSAGE = '服务器内部错误，请稍后重试',
        ERROR_PARAMS_MESSAGE = '提交的参数有误',
        ERROR_AUTHENTICATION_MESSAGE = '账号未被授权或已过期',
        ERROR_NOT_FIND_MESSAGE = '访问的资源未找到',
        ERROR_MODEL_NOT_FIND_MESSAGE = '数据模型未找到',
        ERROR_FILE_NOT_FIND_MESSAGE = '文件未找到',
        ERROR_METHOD_NOT_ALLOW_MESSAGE = '资源访问方式错误',
        ERROR_TOO_MANY_REQUESTS_MESSAGE = '访问过于频繁，请稍后再试',
        ERROR_HTTP_TIME_OUT_MESSAGE = '第三方资源访问超时',
        ERROR_TOO_MANY_OPERATE_MESSAGE = '操作正在进行中，请稍后',
        ERROR_NOT_LOGIN = '请先登入',
        ERROR_UNAUTHORIZED_MESSAGE = '账号或密码错误，请检查';

    protected const DATA_MAPPING = [
        ValidationException::class, ModelNotFoundException::class
    ];

    protected const EXCEPTION_MAPPING = [
        Error::class                         => [
            self::CODE    => self::ERROR_CODE,
            self::MESSAGE => self::ERROR_MESSAGE,
        ],
        ErrorException::class                => [
            self::CODE    => self::ERROR_CODE,
            self::MESSAGE => self::ERROR_MESSAGE,
        ],
        ValidationException::class           => [
            self::CODE    => self::ERROR_PARAMS_CODE,
            self::MESSAGE => self::ERROR_PARAMS_MESSAGE,
        ],
        AuthorizationException::class        => [
            self::CODE    => self::ERROR_AUTHENTICATION_CODE,
            self::MESSAGE => self::ERROR_AUTHENTICATION_MESSAGE,
        ],
        AccessDeniedHttpException::class     => [
            self::CODE    => self::ERROR_AUTHENTICATION_CODE,
            self::MESSAGE => self::ERROR_AUTHENTICATION_MESSAGE,
        ],
        AuthenticationException::class       => [
            self::CODE    => self::ERROR_AUTHENTICATION_CODE,
            self::MESSAGE => self::ERROR_AUTHENTICATION_MESSAGE,
        ],
        UnauthorizedException::class         => [
            self::CODE    => self::ERROR_UNAUTHORIZED_CODE,
            self::MESSAGE => self::ERROR_UNAUTHORIZED_MESSAGE,
        ],
        UnauthorizedHttpException::class     => [
            self::CODE    => self::ERROR_UNAUTHORIZED_CODE,
            self::MESSAGE => self::ERROR_UNAUTHORIZED_MESSAGE,
        ],
        ModelNotFoundException::class        => [
            self::CODE    => self::ERROR_NOT_FIND_CODE,
            self::MESSAGE => self::ERROR_MODEL_NOT_FIND_MESSAGE,
        ],
        NotFoundHttpException::class         => [
            self::CODE    => self::ERROR_NOT_FIND_CODE,
            self::MESSAGE => self::ERROR_NOT_FIND_MESSAGE,
        ],
        FileNotFoundException::class         => [
            self::CODE    => self::ERROR_NOT_FIND_CODE,
            self::MESSAGE => self::ERROR_FILE_NOT_FIND_MESSAGE,
        ],
        RouteNotFoundException::class        => [
            self::CODE    => self::ERROR_UNAUTHORIZED_CODE,
            self::MESSAGE => self::ERROR_NOT_LOGIN,
        ],
        ThrottleRequestsException::class     => [
            self::CODE    => self::ERROR_TOO_MANY_REQUESTS_CODE,
            self::MESSAGE => self::ERROR_TOO_MANY_REQUESTS_MESSAGE,
        ],
        TooManyRequestsHttpException::class  => [
            self::CODE    => self::ERROR_TOO_MANY_REQUESTS_CODE,
            self::MESSAGE => self::ERROR_TOO_MANY_REQUESTS_MESSAGE,
        ],
        MethodNotAllowedHttpException::class => [
            self::CODE    => self::ERROR_METHOD_NOT_ALLOW_CODE,
            self::MESSAGE => self::ERROR_METHOD_NOT_ALLOW_MESSAGE,
        ],
        MethodNotAllowedException::class     => [
            self::CODE    => self::ERROR_METHOD_NOT_ALLOW_CODE,
            self::MESSAGE => self::ERROR_METHOD_NOT_ALLOW_MESSAGE,
        ],
        HttpConnectionException::class       => [
            self::CODE    => self::ERROR_HTTP_TIME_OUT_CODE,
            self::MESSAGE => self::ERROR_HTTP_TIME_OUT_MESSAGE,
        ],
        GuzzleHttpConnectionException::class => [
            self::CODE    => self::ERROR_HTTP_TIME_OUT_CODE,
            self::MESSAGE => self::ERROR_HTTP_TIME_OUT_MESSAGE,
        ],
        LockTimeoutException::class          => [
            self::CODE    => self::ERROR_TOO_MANY_REQUESTS_CODE,
            self::MESSAGE => self::ERROR_TOO_MANY_OPERATE_MESSAGE,
        ],
        self::DEFAULT                        => [
            self::CODE    => self::DEFAULT_ERROR_CODE,
            self::MESSAGE => self::DEFAULT_ERROR_MESSAGE,
        ],
    ];

    /**
     * BaseException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message    = empty($message)
            ? $this->getMessage()
            : sprintf(self::FORMAT_REASON, $this->getMessage(), $message);
        $this->code += $code;
        parent::__construct($message, $this->code, $previous);
    }

    public static function renderByJson($request, $exception)
    {
        [
            self::DATA    => $data,
            self::CODE    => $code,
            self::MESSAGE => $message,
        ] = self::getExceptionData($exception);
        if (empty($data)) {
            $data = null;
        }

        $responseData = self::formatResponse($data, $code, $message);
        return new JsonResponse($responseData, Response::HTTP_OK);
    }

    /**
     * @param $exception
     * @return array
     */
    protected static function getExceptionData($exception): array
    {
        // 自定义异常设置
        if ($exception instanceof self) {
            return [
                self::CODE    => $exception->getCode(),
                self::MESSAGE => $exception->getMessage(),
                self::DATA    => $exception->getData(),
            ];
        }

        // 扩展包和系统异常设置
        $clazz = get_class($exception);
        if (array_key_exists($clazz, self::EXCEPTION_MAPPING)) {
            $result = self::EXCEPTION_MAPPING[$clazz];
            if (in_array($clazz, self::DATA_MAPPING)) {
                $data              = self::parseData($exception);
                $first             = !empty($data) && is_array($data) ? Arr::first($data) : static::UNKNOWN_REASON;
                $result['message'] .= '，原因：' . $first;
            }

            return array_merge($result, [self::DATA => '{}']);
        }

        // 默认异常
        return array_merge(self::EXCEPTION_MAPPING[self::DEFAULT], [self::DATA => '{}']);
    }

    public function getData()
    {
        return [];
    }

    protected static function parseData($exception)
    {
        if ($exception instanceof ValidationException) {
            return self::validationErrorFormat($exception->errors());
        }

        if ($exception instanceof ModelNotFoundException) {
            return ['model' => $exception->getModel()];
        }

        return [];
    }

    /**
     * 格式化参数校验
     *
     * @param $errors
     * @return array
     */
    protected static function validationErrorFormat($errors)
    {
        $result = [];
        if (!is_array($errors) || empty($errors)) {
            return [];
        }

        $keys = array_keys($errors);
        foreach ($keys as $key => $item) {
            $result = array_merge($result, [$item => $errors[$item][0]]);
        }

        return $result;
    }
}
