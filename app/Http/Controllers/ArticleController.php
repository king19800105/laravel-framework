<?php


namespace App\Http\Controllers;


use App\Components\File\FileHandler;
use App\Components\Hash\HashHandler;
use App\Components\Local\LocalCache;
use App\Http\Responders\OriginalResponder;
use Vtiful\Kernel\Excel;

class ArticleController extends Controller
{

    protected $hash;

    protected $localCache;

    public function __construct(HashHandler $handler)
    {
        $this->hash = $handler;
    }

    public function show($id)
    {
//        return new OriginalResponder([
//            'title'   => '标题',
//            'content' => '内容'
//        ]);
    }
}
