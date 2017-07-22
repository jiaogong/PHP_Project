<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Admin\Blog\BlogContent as BlogContentModel;

class BlogContentController extends Controller
{
	public function lists()
	{
		$blogInfo = BlogContentModel::select()->paginate(8);
		return view('admin.blog.blogList', [
			'htmlTitle' => 'blog列表页'
			, 'blogInfo' => $blogInfo
			]);
	}

	public function add(Request $request) 
	{
		return view('admin.blog.blogAdd', [
			'htmlTitle' => '发布blog'

			]);
	}
}