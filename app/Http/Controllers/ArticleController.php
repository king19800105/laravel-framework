<?php


namespace App\Http\Controllers;


use App\Http\Responders\OriginalResponder;

class ArticleController extends Controller
{
    public function show($id)
    {
        return new OriginalResponder([
            'title'   => '标题',
            'content' => '内容'
        ]);
    }
}
