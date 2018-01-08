<?php
//前台首页控制器
class IndexController extends Controller {
	//显示首页
	public function indexAction(){
		//获取所有的分类
		$categoryModel = new CategoryModel('category');
		$cats = $categoryModel->frontCats();
		//获取推荐商品
		$goodsModel = new GoodsModel('goods');
		$bestGoods = $goodsModel->getBestGoods();
		// var_dump($cats);
		include  CUR_VIEW_PATH . "index.html";
	}
}