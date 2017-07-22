<?

namespace Admin\Controller;
use Think\Controller;

class CountryController extends Controller {
	//
	public function show(){
		//获取国家的id
		$c = $_GET['ca'];

		$where['country']= $c;
		//创建对象
		$material = M('material2');

		//sql
		$data = $material->where($where)->select();
		echo json_encode($data);
		
	}
}

?>