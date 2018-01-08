<?php
//品牌模型
class BrandModel extends Model{

	//获取所有的品牌信息
	public function getBrands(){
		$sql = "select * from {$this->table}";
		return $this->db->getAll($sql);
	}

	//分页获取品牌信息
	public function getPageBrands($offset,$limit){
		$sql = "select * from {$this->table} limit $offset,$limit";
		return $this->db->getAll($sql);
	}
}