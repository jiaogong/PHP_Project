<?php 

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\PublicFunc\Funcs; // 私有的公共方法

use App\Model\Admin\HomePicture as homePictureModel;

/** 
 *  前台首页管理
 */
class homeShowController extends Controller 
{
	/**
	 *  前台首页图片地址
	 *
	 *  如： config('app.Index_Update_Img_Path') . $picturePath . date('Ym', time());
	 */
	const picturePathArr = [
		1 => 'rotationSixMin/'
		, 2 => 'rotationSixMinBackground/'
		, 3 => 'middleUpTwo/'
		, 4 => 'middleDwonFourMin/'
		, 5 => 'bottomMaxBackground/'
	];
	
	public function Lists () {
		$homeShowInfo = homePictureModel::all();
		return view('admin.homeShow.list', [
					'htmlTitle' => '前台-轮播-6小图-列表页'
					, 'homeShowInfo' => $homeShowInfo
					]);
	}

	/**
	 * rotationAdd 添加
	 * @param  Request $request 获取数据
	 * @return 
	 */
	public function add (Request $request) {
		if ( $request->isMethod('get') ) {

			return view('admin.homeShow.add', [
					'htmlTitle' => '前台-轮播-6小图-添加页'
					]);
		} elseif ($request->isMethod('post')) {
			

			$homePictureModel = new homePictureModel;
			if($request->file1 && $request->type){
				$picturePath = self::picturePathArr[(int)$request->type];
				//上传图片
		       	$saveDir = config('app.Index_Update_Img_Path') . $picturePath . date('Ym', time()); // 保存图片的路径
		       	$saveImagePath = Funcs::uploadOneImage($request->file1, $saveDir);
		       	if ($saveImagePath) {
		       		$homePictureModel->image_path = $saveImagePath['savePath'];
		       	}
	       	}
			$homePictureModel->title = $request->title;
			$homePictureModel->url = $request->url;
			$homePictureModel->status = $request->status;
			$homePictureModel->type = $request->type;
			$homePictureModel->subheading = $request->subheading;
			$homePictureModel->user_name = Session::get('admin_user_name') ?: '';
			$homePictureModel->user_id = Session::get('admin_user_id') ?: '';
			$homePictureModel->created_at = time();
        	$homePictureModel->updated_at = time();
			$result = $homePictureModel->save();

			if ($result) {
				return Redirect::route('admin_homeShow_list'); // 跳转至登录首页
			}
		}	
	}

	/**
	 * rotationReview 预览
	 * @return 
	 */
	public function review() {

	}

	/**
	 * rotationModify 修改
	 * @param  Request $request 获取数据
	 * @param  integer  $id      获取id
	 * @return 
	 */
	public function modify(Request $request, $id) {
		if ($request->isMethod('get') && $id) {
			$homeShowInfo = homePictureModel::where('id', $id)->first();
			if ($homeShowInfo) {
				return view('admin.homeShow.modify', [
					'htmlTitle' => '前台-轮播-6小图-修改页'
					, 'homeShowInfo' => $homeShowInfo
					, 'id' => $id
					]);
			}
		} elseif ($request->isMethod('post') && $id) {

			$this->validate($request, [
				'title' => 'required|max:50|min:4',
				'url' => 'required',
			]);
			$homePictureModel = new homePictureModel;
			$data = [];
			if($request->newFile){
				// 如果有上传图片
		       	$saveDir = config('app.Index_Update_Img_Path') . 'rotationSixMin/' . date('Ym', time()); // 保存图片的路径
		       	$saveImagePath = Funcs::uploadOneImage($request->newFile, $saveDir);
		       	
		       	if ($saveImagePath) {
		       		$data['image_path'] = $saveImagePath['savePath'];
		       	}
	       	}

			$data['title'] = $request->title;
			$data['url'] = $request->url;
			$data['status'] = $request->status;
			$result = $homePictureModel->where('id', $id)->update($data);

			if ($result) {
				return Redirect::route('admin_homeShow_list'); // 跳转至登录首页
			}
		}
	}

	/**
	 * rotationDel 删除
	 * @param  Request $request 获取数据
	 * @param  integer  $id      获取id
	 * @return 
	 */
	public function del(Request $request, $id) {
		if ($request->isMethod('get') && $id) {
			$homeShowInfo = homePictureModel::where('id', $id)->find(1);
			$result = $homeShowInfo->delete();

			if ($result) {
				return Redirect::route('admin_homeShow_list'); // 跳转至登录首页
			}
		}
	}
}