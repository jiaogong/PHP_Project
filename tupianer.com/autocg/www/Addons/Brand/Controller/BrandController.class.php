<?php

namespace Addons\Brand\Controller;

use Home\Controller\AddonsController;

class BrandController extends AddonsController {

    /**
     * 品牌添加
     * @author  崔元欣 <15811506097@163.com>
     */
    public function add() {
        $this->display(T('Addons://Brand@Brand/edit'));
    }

    /**
     * 品牌编辑
     * @author  崔元欣 <15811506097@163.com>
     */
    public function edit() {
        $id = I('get.id', '');
        $BrandModel = D('Addons://Brand/Brand');
        $info = $BrandModel->detail($id);
        $this->assign('info', $info);
        $this->display(T('Addons://Brand@Brand/edit'));
    }

    /**
     * 品牌删除
     * @author  崔元欣 <15811506097@163.com>
     */
    public function del() {
        if (IS_GET) {
            $id = I('get.id', '');
        }
        if (IS_POST) {
            $id = array_unique((array) I('ids', 0));
            $id = is_array($id) ? implode(',', $id) : $id;
            if (empty($id)) {
                $this->error('请选择要操作的数据!');
            }
        }

        if (D('Addons://Brand/Brand')->del($id)) {
            $this->success('成功删除该品牌', Cookie('__forward__'));
        } else {
            $this->error(D('Addons://Brand/Brand')->getError());
        }
    }

    /**
     * 品牌保存
     * @author  崔元欣 <15811506097@163.com>
     */
    public function update() {
        $BrandModel = D('Addons://Brand/Brand');
        $res = $BrandModel->update();

        if (!$res) {
            $this->error($BrandModel->getError());
        } else {
            if ($res['id']) {
                $this->success('更新成功', Cookie('__forward__'));
            } else {
                $this->success('添加成功', Cookie('__forward__'));
            }
        }
    }

    /**
     * 品牌excel导入
     * @author  崔元欣 <15811506097@163.com>
     */
    public function excel_in() {
        if (IS_POST) {
            header("Content-Type:text/html;charset=utf-8");
            $upload = new \Think\Upload(); // 实例化上传类
            $upload->maxSize = 3145728; // 设置附件上传大小
            $upload->exts = array('xls', 'xlsx'); // 设置附件上传类
            $upload->rootPath = './Uploads/Excel/'; //保存根路径
            $upload->savePath = ''; // 设置附件上传目录
            // 上传文件
            $info = $upload->uploadOne($_FILES['excel']);
            $filename = $upload->rootPath . $info['savepath'] . $info['savename'];
            $exts = $info['ext'];
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功
                $this->import($filename, $exts);
            }
        } else {
            $this->display(T('Addons://Brand@Brand/excel_in'));
        }
    }

    /**
     * 导入数据方法
     * @author  崔元欣 <15811506097@163.com>
     */
    protected function import($filename, $exts = 'xls') {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import('Vendor.PHPExcel');
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if ($exts == 'xls') {
            import("Vendor.PHPExcel.Reader.Excel5");
            $PHPReader = new \PHPExcel_Reader_Excel5();
        } else if ($exts == 'xlsx') {
            import("Vendor.PHPExcel.Reader.Excel2007");
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        //获取总行数
        $allRow = $currentSheet->getHighestRow();
        // 获取数据数组
        $info = array();
        for ($row = 1; $row <= $allRow; $row ++) {
            for ($column = 'A'; $column <= $allColumn; $column ++) {
                $val = $currentSheet->getCellByColumnAndRow(ord($column) - 65, $row)->getValue();
                $info[$row][] = $val;
            }
        }
        $info[1][0] = 'brand';
        $info[1][1] = 'manufacturer';
        $info[1][2] = 'series';
        $info[1][3] = 'car';
        $DB = M('Brand');
        $data = array();
        for ($i = 2; $i <= count($info); $i ++) {
            for ($j = 0; $j < count($info[$i]); $j ++) {
                for ($k = 0; $k < count($info[1]); $k ++) {
                    $data[$i][$info[1][$k]] = $info[$i][$k];
                }
            }
        }
        $datalist = array_values($data);
        $result = $DB->addAll($datalist);
        if ($result) {
            $this->success('批量添加成功', Cookie('__forward__'));
        } else {
            $this->error('批量添加失败');
        }
    }

    //导出数据方法
    public function export() {
        $xlsName = date('YmdHis',time());
        $xlsCell = array(
            array('brand', '品牌'),
            array('manufacturer', '厂商'),
            array('series', '车系'),
            array('car', '车款'),
        );
        $xlsModel = M('Brand');
        $xlsData = $xlsModel->field('brand,manufacturer,series,car')->select();
        $this->exportExcel($xlsName, $xlsCell, $xlsData);
    }

    public function exportExcel($expTitle, $expCellName, $expTableData) {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        
        import('Vendor.PHPExcel');
        $PHPExcel = new \PHPExcel();

        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        $PHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1'); //合并单元格
        $PHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $PHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls"); //attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
