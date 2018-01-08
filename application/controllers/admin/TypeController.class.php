<?php

/**
 * 后台商品类型管理
 * User: Levi
 * Date: 2017/2/8
 * Time: 15:57
 */
class TypeController extends BaseController
{
    //显示类型
    public function indexAction()
    {
        //实例化模型获得所有数据
        $typesModel=new TypeModel('goods_type');
//        $types=$typesModel->getTypes();
        //分页获取数据
        $pagesize=2;//每页显示的记录数
        $current=isset($_GET['page'])?$_GET['page']:1;//当前所在页数
        $offset=($current-1)*$pagesize;
        $types=$typesModel->getPageTypes($offset,$pagesize);
        //显示分页详情
        $this->library('Page');
        //获取总的记录数
        $total=$typesModel->total("");
        $page=new Page($total,$pagesize,$current,'index.php',
            array('p'=>'admin','c'=>'type','a'=>'index'));
        $pageinfo=$page->showPage();
        include CUR_VIEW_PATH . 'goods_type_list.html';
    }

    //显示添加类型
    public function addAction()
    {
        include CUR_VIEW_PATH . 'goods_type_add.html';
    }

    //显示编辑类型
    public function editAction()
    {
        //实例化模型获得需要编辑的信息并显示
        $type_id=$_GET['type_id']+0;
        $typesModel=new TypeModel('goods_type');
        $type=$typesModel->selectByPk($type_id);
        include CUR_VIEW_PATH . 'goods_type_edit.html';
    }

    //显示更新类型
    public function updateAction()
    {
        include CUR_VIEW_PATH . 'goods_type_edit.html';
    }

    //类型入库操作
    public function insertAction()
    {
        //收集表单数据
        $data['type_name']=trim($_POST['type_name']);
        //验证和处理
        if($data['type_name']===''){
            $this->jump("index.php?p=admin&c=type&a=add","商品类型名称不能为空");
        }
        //进行转义处理
        $this->helper('input');
        $data=deephandlechars($data);
        //调用模型完成入库操作
        $typeModel=new TypeModel('goods_type');
        if ($typeModel->insert($data)) {
            $this->jump("index.php?p=admin&c=type&a=index", "添加商品类型成功", 1);
        } else {
            $this->jump("index.php?p=admin&c=type&a=add", "添加商品类型失败");
        }
    }

    //类型删除操作
    public function deleteAction()
    {

    }
}