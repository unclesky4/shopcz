<?php

//admin模型
class AdminModel extends Model
{
    public function getAdmins()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->getAll($sql);
    }

    //验证用户登录账号密码是否正确
    public function checkUser($username, $password)
    {
        $password=md5($password);
        $sql = "SELECT * FROM {$this->table}
              WHERE admin_name ='$username' AND password='$password'
              LIMIT 1";
        return $this->db->getRow($sql);
    }
}