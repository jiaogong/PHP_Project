<?php

namespace APP\Http\Controllers\Index;

use App\User;
use App\Http\Controllers\Controller;

use App\Model\Index\UserComment as UserCommentModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\Index\HomePicture as homePictureModel;

class IndexController extends Controller
{
    // 默认home页
    public function __invoke(){
        $rsmInfo = homePictureModel::where(['status'=> '1', 'type' => '1'])->get();
        $newRsmInfo = [];
        if (!empty($rsmInfo)) {
          foreach($rsmInfo as $k=>$v){
              $key = floor($k/2);
              if($k%2===0){
                  $newRsmInfo[$key]['title1'] = $v->title;
                  $newRsmInfo[$key]['url1'] = $v->url;
                  $newRsmInfo[$key]['image_path1'] = $v->image_path;
              } else {
                  $newRsmInfo[$key]['title2'] = $v->title;
                  $newRsmInfo[$key]['url2'] = $v->url;
                  $newRsmInfo[$key]['image_path2'] = $v->image_path;
              }
          }
        }

        return view('index.home', [
            'htmlTitle' => 'home'
            , 'rsmInfo' => $newRsmInfo
        ]);
    }

    // about页
    public function about(){
        return view('index/about', [
            'htmlTitle'=>'about'
        ]);
    }

    // pages页
    public function pages(){
        return view('index.pages', [
            'htmlTitle'=>'pages'
        ]);
    }

    // gallery页
    public function gallery(){
        return view('index.gallery', [
            'htmlTitle'=>'gallery'
        ]);
    }

    // contact页
    public function contact(Request $request){
        if($request && $request->isMethod('post')){
            $UserCommentModel = new UserCommentModel;
            $data = [];
            if(Session::get('user_id') && Session::get('user_name')){
                $data['user_id'] = Session::get('user_id');
                $data['user_name'] = Session::get('user_name');
            }else{
                $data['user_name'] = $request->name;
                $data['user_email'] = $request->email;
            }
            $data['content'] = $request->content;
            $data['created_at'] = time();
            $date['updated_at'] = time();
            $result = $UserCommentModel->insert($data);
            if($result){
                return view('index.user.userResult', [
                    'htmlTitle' => '留言结果页'
                    , 'message' => '留言成功'
                    , 'gotoUrl' => route('home')
                    , 'gotoTime' => ''
                ]);
            }else{
                return view('index.user.userResult', [
                    'htmlTitle' => '留言结果页'
                    , 'message' => '留言失败'
                    , 'gotoUrl' => route('home')
                    , 'gotoTime' => ''
                ]);
            }
        } else {
            return view('index.contact', [
                'htmlTitle'=>'contact'
            ]);
        }
    }
}
