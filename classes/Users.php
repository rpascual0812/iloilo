<?php
require_once('../../classes/ClassParent.php');
class Users extends ClassParent{
    var $username       = NULL;
    var $password       = NULL;
    var $firstname      = NULL;
    var $lastname       = NULL;
    var $usertype       = NULL;
    var $archived       = false;
    var $avatar         = NULL;

    public function __construct(
                                    $username,
                                    $password,
                                    $firstname,
                                    $lastname,
                                    $usertype,
                                    $archived,
                                    $avatar
                                ){
        
        $arr = get_defined_vars();
        if(empty($arr)){
            return(FALSE);
        }

        foreach($arr as $k=>$v){
            if(is_string($v)){
                $this->$k = pg_escape_string(trim(strip_tags($v)));
            }
        }
    }
    
    

    public function login(){
        $sql = <<<EOT
                select
                    *
                from users
                where username = '$this->username'
                and password = md5('$this->password')
                and archived = false
                ;
EOT;
        return ClassParent::get($sql);
    }

    public function userinfo(){
        $sql = <<<EOT
                select
                    *
                from users
                where username = '$this->username'
                ;
EOT;
        return ClassParent::get($sql);
    }

    public function update($username){
        $username = pg_escape_string(trim(strip_tags($username)));

        $sql = "begin;";
        $sql .= <<<EOT
                update users set
                (username,firstname,lastname,avatar)
                =
                ('$this->username','$this->firstname','$this->lastname','$this->avatar')
                where username = '$username'
                ; 
EOT;
        
        if($this->password != 'NULL'){
            $sql .= <<<EOT
                update users set
                password = md5('$this->password')
                where username = '$username'
                ;
EOT;
        }

        $sql .= 'commit;';

        return ClassParent::update($sql);
    }
}
?>