<?php


namespace App\Http\Responders;

use App\Traits\FormatResponse;
use Illuminate\Contracts\Support\Responsable;

/**
 * Class NoneResponder
 * @package App\Http\Responders
 */
class NoneResponder implements Responsable
{
    use FormatResponse;
    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        return response()->json($this->format('{}'));
    }
}
