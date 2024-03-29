<?php
namespace app\admin\Model;

use think\Model;

class Structure extends Model
{
    //组织排序[列表使用]
    public function catetree($cateRes){
        //$cateRes=$this->order('sort asc')->select();
        return $this->sort($cateRes);
    }

    public function catetreeadd()
    {
        $cateRes=$this->order('sort asc')->select();
        return $this->sort($cateRes);
    }
    public function sort($cateRes,$pid=0,$level=0){
        static $arr=array();
        foreach($cateRes as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($cateRes,$v['id'],$level+1);
            }
        }
        return $arr; 
    }
    //获取组织及子组织ID
    public function childrenids($structureid){
        $data=$this->field('id,pid')->select();
        return $this->_childrenids($data,$structureid);
    }
    private function _childrenids($data,$structureid){
        static $arr=array();
        foreach ($data as $k=>$v){
            if($v["pid"]==$structureid){
                $arr[]=$v["id"];
                $this->_childrenids($data,$v["id"]);
            }
        }
        return $arr;
    }

    //批量删除
    public function delAll($idarrs)
    {
        foreach($idarrs as $k=>$v){
            $idArr[]=$this->childrenids($v);
            $v=(int)$v;
            $idArr[][]=$v;
        }
        $_idArr=array();
        foreach ($idArr as $k=>$v) {
            foreach ($v as $k1=>$v1) {
                $_idArr[]=$v1;
            }
        }
        $id=array_unique($_idArr);
        $this::destroy($id);
    }
}


























