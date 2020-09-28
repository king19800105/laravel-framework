<?php


namespace App\Http\Responders;


/**
 * 不处理字段，直接返回
 * Class OriginalResponder
 * @package App\Http\Responders
 */
class OriginalResponder extends BaseResponder
{

    /**
     * @inheritDoc
     */
    protected function transform()
    {
        if (is_object($this->result)) {
            $this->result = (array) $this->result;
        }

        return $this->result;
    }
}
