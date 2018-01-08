<?php

/**
 * 商品分类模型
 * User: Levi
 * Date: 2017/2/7
 * Time: 15:01
 */
class CategoryModel extends Model
{
    //获取所有商品分类
    public function getCats()
    {
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        return $this->tree($cats);
    }

    /**
     * 重新排序
     * @param array $arr [要排序的数组]
     * @param int $pid [父ID]
     * @return array [排好序的数组]
     */
    public function tree($arr, $pid = 0,$level=0,$res=array())
    {
        foreach ($arr as $v) {
            if ($v['parent_id'] == $pid) {
                //说明找到 先保存 然后递归查找
                $v["level"]=$level;
                $res[] = $v;
                $res=$this->tree($arr, $v['cat_id'],$level+1,$res);
            }
        }
        return $res;
    }

    /**
     * 得到自己以及子节点的cat_id
     * @param $cat_id
     * @return array
     */
    public function getSubIds($cat_id){
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        $cats=$this->tree($cats,$cat_id);
        foreach($cats as $v){
            $cat_ids[]=$v['cat_id'];
        }
        $cat_ids[]=$cat_id;

        return $cat_ids;
    }

    /**
     * 构造嵌套结构的多维数组
     * @param  [array]  $arr [要处理的二维数组]
     * @param  integer $pid [从哪个节点开始]
     * @return [array]       [处理之后的多维数组]
     */
    public function child($arr,$pid = 0) {
        $res = array();
        foreach ($arr as $v) {
            if ($v['parent_id'] == $pid) {
                //找到了，继续找，递归
                $childs = $this->child($arr,$v['cat_id']);
                //将找到的结果保存到当前数组的下标为child的元素中
                $v['child'] = $childs;
                $res[] = $v;
            }
        }
        return $res;
    }

    public function frontCats(){
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        return $this->child($cats);
    }
}