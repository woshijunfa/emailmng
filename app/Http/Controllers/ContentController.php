<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Services\CommonService;
use Auth;
use Input;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$contents = Content::where('is_valid',1)->orderBy('id','desc')->get();
        return view('content.index',compact('contents'));
    }

    public function add()
    {
        $id = Input::get("id");
        $content = '';
        if(!empty($id)) $content = Content::where('id',$id)->first();
    	return view("content.add",compact('content'));
    }

    public function addpost()
    {
        $id = Input::get('id');

        $title = trim(Input::get("title"));
        $is_valid = Input::get("is_valid");
        $htmlContent = trim(Input::get("content"));

        if (empty($title) || empty($htmlContent)) return $this->json(1,'','参数不完整');

        $mc = [
            'm_content'=>'',
            'title'=>$title,
            'h_content'=>$htmlContent,
            'is_valid' => empty($is_valid) ? 0 : 1
        ];

        Content::insertContent($id,$mc);

        return $this->json(0);
    }

    public function show($id)
    {
        $htmlContent = CommonService::renderContent($id);
        echo $htmlContent;
    }
}
