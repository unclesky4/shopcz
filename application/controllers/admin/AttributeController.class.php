<?php

/**
 * 后台商品属性管理
 * User: Levi
 * Date: 2017/2/9
 * Time: 9:43
 */
class AttributeController extends BaseController
{
    //显示属性
    public function indexAction()
    {
        $type_id = isset($_GET['type_id']) ? $_GET['type_id'] + 0 : 0;
        $attrModel = new AttributeModel('attribute');
//        $attrs=$attrModel->getAttrs($type_id);
        $typeModel = new TypeModel("goods_type");
        $types = $typeModel->getTypes();
        //分页获取
        $pagesize = 2;
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current - 1) * $pagesize;
        $attrs = $attrModel->getPageAttrs($type_id, $offset, $pagesize);
        $this->library('Page');
        if ($type_id == 0) {
            $where = "";
        } else {
            $where = "type_id={$type_id}";
        }
        $total = $attrModel->total($where);
        $page = new Page($total, $pagesize, $current, 'index.php',
            array("p" => "admin", 'c' => 'attribute', 'a' => 'index', 'type_id' => $type_id));
        $pageinfo = $page->showPage();
        include CUR_VIEW_PATH . "attribute_list.html";
    }

    //显示添加属性页面
    public function addAction()
    {
        //获取所有商品类型
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();
        include CUR_VIEW_PATH . "attribute_add.html";
    }

    //属性入库操作
    public function insertAction()
    {
        //以关联数组的方式来收集表单数据
        $data['attr_name'] = trim($_POST['attr_name']);
        $data['type_id'] = $_POST['type_id'];
        $data['attr_type'] = $_POST['attr_type'];
        $data['attr_input_type'] = $_POST['attr_input_type'];
        $data['attr_value'] = isset($_POST['attr_value']) ? trim($_POST['attr_value']) : "";
        //验证和处理
        if ($data['attr_name'] === '') {
            $this->jump('index.php?p=admin&c=attribute&a=add', '属性名称不能为空');
        }
        if ($data['type_id'] == 0) {
            $this->jump('index.php?p=admin&c=attribute&a=add', '必须要选择商品类型');
        }
        //转义
        $this->helper('input');
        $data = deephandlechars($data);
        //调用模型完成入库操作
        $attrModel = new AttributeModel('attribute');
        if ($attrModel->insert($data)) {
            $this->jump("index.php?p=admin&c=attribute&a=index&type_id={$data['type_id']}", '添加属性成功', 1);
        } else {
            $this->jump('index.php?p=admin&c=attribute&a=add', '添加属性失败');
        }
    }

    //获取指定类型下的属性
    public function getAttrsAction()
    {
        $type_id = $_GET['type_id'] + 0;
        //调用模型完成具体的操作
        $attrModel = new AttributeModel('attribute');
        // $attrs = $type_id;
        $attrs = $attrModel->getAttrsTable($type_id);
        echo <<<STR
		<script type="text/javascript">
			window.parent.document.getElementById("tbody-goodsAttr").innerHTML = "$attrs";
		</script>
STR;
    }
}