<?php
require_once('../../classes/ClassParent.php');
class Orders extends ClassParent{
    var $pk             = NULL;
    var $customername   = NULL;
    var $mobilephone    = NULL;
    var $landline       = NULL;
    var $location       = NULL;
    var $datefrom       = NULL;
    var $dateto         = NULL;
    var $archived       = FALSE;
    var $createdby      = NULL;
    var $datecreated    = NULL;
    var $status         = NULL;

    public function __construct(
                                    $pk,
                                    $customername,
                                    $mobilephone,
                                    $landline,
                                    $location,
                                    $datefrom,
                                    $dateto,
                                    $archived,
                                    $createdby,
                                    $datecreated,
                                    $status
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
    
    public function create($remarks){

        $remarks = pg_escape_string(trim(strip_tags($remarks)));
        $sql = "begin;";
        $sql .= <<<EOT
                insert into orders
                (
                    customername,
                    mobilephone,
                    landline,
                    location,
                    datefrom,
                    dateto,
                    createdby
                )
                values
                (
                    '$this->customername',
                    '$this->mobilephone',
                    '$this->landline',
                    '$this->location',
                    '$this->datefrom'::timestamptz,
                    '$this->dateto'::timestamptz,
                    '$this->createdby'
                );
EOT;

        if($remarks){
            $sql .= <<<EOT
                    insert into orders_remarks
                    (
                        orderspk,
                        remark,
                        createdby
                    )
                    values
                    (
                        currval('orders_pk_seq'),
                        '$remarks',
                        '$this->createdby'
                    );
EOT;
        }

        $sql .= "commit;";
        
        return ClassParent::insert($sql);
    }

    public function get_unique_customer(){
        $sql = <<<EOT
                select
                    distinct(customername) as customername
                from orders
                where customername ilike '%$this->customername%'
                order by customername asc
                limit 20
                ;
EOT;
        return ClassParent::get($sql);
    }

    public function report($from,$to){
        $sql = <<<EOT
                select
                    pk,
                    customername,
                    mobilephone,
                    landline,
                    location as loc,
                    to_char(datefrom,'Mon DD, YYYY HH:MI AM') as datefrom,
                    to_char(dateto,'Mon DD, YYYY HH:MI AM') as dateto,
                    createdby,
                    datecreated,
                    status as stat,
                    archived
                from orders
                where datefrom::date between '$from' and '$to'
                and archived = false
                ;
EOT;
        return ClassParent::get($sql);
    }

    
    //////////////////////////////////////////////
    public function updateCollegeInfo($pk, $body){
        $pk     = pg_escape_string(trim(strip_tags($pk)));
        $body   = pg_escape_string(trim($body));

        $this->archived = ($this->archived == 'f') ? $this->archived = 'false' : $this->archived = 'true';
        
        $sql = <<<EOT
            begin;
            update colleges set 
            (code,name,archived)
            =
            ('$this->code','$this->name',$this->archived)
            where pk = $pk;

            update articles set
            (title,body)
            =
            ('$this->name','$body')
            where pk = $this->articles_pk;
            commit;
EOT;
        return ClassParent::update($sql);
    }

    public function insertCollegeInfo($body){
        $body   = pg_escape_string(trim($body));

        $sql = <<<EOT
            begin;
            insert into articles
            (title,body)
            values
            ('$this->name',$body')
            ;
            insert into colleges
            (code,name,articles_pk)
            values
            ('$this->code','$this->name',currval('articles_pk_seq'))
            ;
            commit;
EOT;
        return ClassParent::insert($sql);
    }
}
?>