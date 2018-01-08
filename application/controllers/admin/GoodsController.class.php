<?php

/**
 * 后台商品管理
 * User: Levi
 * Date: 2017/2/9
 * Time: 15:36
 */
class GoodsController extends BaseController
{
    //显示商品
    public function indexAction(){
        include CUR_VIEW_PATH . "goods_list.html";
    }
    //显示添加商品页面
    public function addAction(){
        //获取所有的商品分类
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getCats();
        //获取所有的的品牌
        $brandModel = new BrandModel("brand");
        $brands = $brandModel->getBrands();
        //获取所有的商品类型
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();
        //载入视图页面
        include CUR_VIEW_PATH . "goods_add.html";
    }
    //商品入库操作
    public function insertAction(){
        //1.收集表单数据，以关联数组的形式来收集 CTRL+SHIFT +D 复制一行
        $data['goods_name'] = trim($_POST['goods_name']);
        $data['goods_sn'] = trim($_POST['goods_sn']);
        $data['shop_price'] = trim($_POST['shop_price']);
        $data['market_price'] = trim($_POST['market_price']);
        $data['cat_id'] = $_POST['cat_id'];
        $data['brand_id'] = $_POST['brand_id'];
        $data['type_id'] = $_POST['type_id'];
        $data['promote_start_time'] = strtotime($_POST['promote_start_time']);
        $data['promote_end_time'] = strtotime($_POST['promote_end_time']);
        $data['goods_desc'] = trim($_POST['goods_desc']);
        $data['goods_number'] = trim($_POST['goods_number']);
        $data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
        $data['is_hot'] = isset($_POST['is_hot']) ? $_POST['is_hot'] : 0;
        $data['is_new'] = isset($_POST['is_new']) ? $_POST['is_new'] : 0;
        $data['is_onsale'] = isset($_POST['is_onsale']) ? $_POST['is_onsale'] : 0;
        //对上传图片的处理，需要判断
        // var_dump($_FILES['goods_img']);
        if ($_FILES['goods_img']['tmp_name'] !== '') {
            //有上传
            $this->library('Upload');
            $upload = new Upload();
            if ($filename = $upload->up($_FILES['goods_img'])) {
                $data['goods_img'] = $filename; //成功
            } else {
                //失败
                $this->jump('index.php?p=admin&c=goods&a=add',$upload->error());
            }
        }
        //2.验证和处理
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        //3.调用模型完成入库[注意有一个关联插入]
        $goodsModel = new GoodsModel('goods');
        if ($goods_id = $goodsModel->insert($data)) {
            //成功，同时，需要收集所有的扩展属性，然后完成goods_attr表的insert操作
            if (isset($_POST['attr_id_list'])) {
                $ids = $_POST['attr_id_list'];
                $values = $_POST['attr_value_list'];
                $prices = $_POST['attr_price_list'];
                //批量插入，一次性插入多条记录--循环
                $model = new Model('goods_attr');
                foreach ($ids as $k => $v) {
                    $list['goods_id'] = $goods_id;
                    $list['attr_id'] = $v;
                    $list['attr_value'] = $values[$k];
                    $list['attr_price'] = $prices[$k];
                    $model->insert($list);
                }
            }
            $this->jump('index.php?p=admin&c=goods&a=index','添加商品成功',1);
        } else {
            //失败
            $this->jump('index.php?p=admin&c=goods&a=add','添加商品失败');
        }

    }
    //显示编辑商品页面
    public function editAction(){
        include CUR_VIEW_PATH . "goods_edit.html";
    }
    //商品更新操作
    public function updateAction(){

    }
    //删除商品操作
    public function deleteAction(){

    }
}