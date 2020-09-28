<?php


namespace App\Http\Responders;


use App\Traits\FormatDate;
use App\Traits\FormatResponse;
use Illuminate\Contracts\Support\Responsable;

abstract class BaseResponder implements Responsable
{
    use FormatResponse, FormatDate;

    protected $result;

    protected $code;

    protected $status;

    protected $message;

    /**
     * BaseResponder constructor.
     *
     * @param $result
     * @param int $code
     * @param string $message
     * @param int $status
     */
    public function __construct($result, $code = 0, $message = 'success', $status = 200)
    {
        $this->result  = $result;
        $this->code    = $code;
        $this->message = $message;
        $this->status  = $status;
    }


    /**
     * 自定义格式化操作
     *
     * @return mixed
     */
    abstract protected function transform();

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $responseData = $this->transform();
        return response()->json(
            $this->format($responseData, $this->code, $this->message),
            $this->status
        );
    }

    /**
     *  获取结果集
     *
     * @param null $key
     * @return mixed
     */
    public function getResult($key = null)
    {
        $result = (array)$this->result;
        if (null === $key) {
            return $result;
        }

        return $result[$key] ?? null;
    }
}
