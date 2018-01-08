<?php

/**
 * 商品类型模型
 * User: Levi
 * Date: 2017/2/8
 * Time: 16:31
 */
class TypeModel extends Model
{
    //获取所有的商品类型
    public function getTypes()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->getAll($sql);
    }

    //分页获取商品类型--第二版
    public function getPageTypes($offset,$limit){
        $sql = "select a.*,count(attr_id) as num from cz_goods_type as a
				left join cz_attribute as b
				on a.type_id = b.type_id
				group by type_name
				limit $offset,$limit";
        return $this->db->getAll($sql);
    }
//    /**
//     * 分页获取商品类型
//     * @param $offset
//     * @param $pagesize
//     */
//    public function getPageTypes($offset, $pagesize)
//    {
//        $sql="SELECT * FROM {$this->table}
//        ORDER BY type_id DESC
//        LIMIT $offset,$pagesize";
//        return $this->db->getAll($sql);
//    }
}