<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Admin\Blog\BlogType as BlogTypeModel;

class BlogTypeController extends Controller
{
	public function lists()
	{
		$blogTypeInfo = BlogTypeModel::select()->paginate(8);
		return view('admin.blog.blogTypeList', [
			'htmlTitle' => 'blog列表页'
			, 'blogTypeInfo' => $blogTypeInfo
			]);
	}

	public function add(Request $request) 
	{
		return view('admin.blog.blogTypeAdd', [
			'htmlTitle' => '发布blog'

			]);
	}
}