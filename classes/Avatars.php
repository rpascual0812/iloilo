<?php
require_once('../../classes/ClassParent.php');
class Avatars extends ClassParent{
    var $name           = NULL;
    var $archived       = false;

    public function __construct(
                                    $name,
                                    $archived
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
    
    

    public function get(){
        $sql = <<<EOT
                select
                    *
                from avatars
                where archived = false
                and name not in (select avatar from users)
                ;
EOT;
        return ClassParent::get($sql);
    }
}
?>