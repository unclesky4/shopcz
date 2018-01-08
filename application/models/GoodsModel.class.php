<?php
//商品模型
class GoodsModel extends Model {
	//获取推荐商品
	public function getBestGoods(){
		$sql = "SELECT goods_id,goods_name,goods_img,shop_price FROM {$this->table}
		        WHERE  is_best = 1 AND is_onsale = 1
				ORDER BY goods_id DESC
		        LIMIT 4";
		return $this->db->getAll($sql);
	}
}