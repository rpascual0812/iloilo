<?php
class ClassParent {
    protected function get($sql){
        $query = pg_query($sql);
        $return="";
        if(pg_numrows($query)){
            $return['status'] = true;
            $return['sql'] = $sql;
            $return['msg'] = "Success";
            $return['data']="";
            while($row = pg_fetch_assoc($query)){
                $return['data'][] = $row;
            }
        }
        else{
            $return['status'] = false;
            $return['sql'] = $sql;
            $return['msg'] = pg_last_error();
            $return['data'] = NULL;
        }
        
        return $return;
    }

    protected function update($sql){
        $query = pg_query($sql);
        $return="";

        if($query){
            $return['status'] = true;
            $return['sql'] = $sql;
            $return['msg'] = "Success";
        }
        else{
            $return['status'] = false;
            $return['sql'] = $sql;
            $return['msg'] = pg_last_error();
        }
        return $return;

        pg_free_result($query);
    }

    protected function insert($sql){
        $query = pg_query($sql);
        $return="";

        if($query){
            $return['status'] = true;
            $return['sql'] = $sql;
            $return['msg'] = "Success";
        }
        else{
            $return['status'] = false;
            $return['sql'] = $sql;
            $return['msg'] = pg_last_error();
        }
        return $return;

        pg_free_result($query);
    }

    protected function returning($sql){
        $query = pg_query($sql);
        $return="";
        if($query){
            $return['status'] = true;
            $return['sql'] = $sql;
            $return['msg'] = "Success";
            $return['returning'] = pg_fetch_assoc($query);
        }
        else{
            $return['status'] = false;
            $return['sql'] = $sql;
            $return['msg'] = pg_last_error();
        }
        return $return;

        pg_free_result($query);
    }
}

?>