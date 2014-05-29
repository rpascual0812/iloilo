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
                order by datefrom asc,datecreated asc
                ;
EOT;
        return ClassParent::get($sql);
    }

    public function get_one(){
        $sql = <<<EOT
                with Q as 
                (
                    select
                        orderspk,
                        remark,
                        createdby,
                        datecreated
                    from orders_remarks
                    where orderspk = $this->pk
                    order by datecreated desc
                )
                select
                    pk,
                    customername,
                    mobilephone,
                    landline,
                    location as loc,
                    to_char(datefrom,'MM/DD/YYYY HH:MI AM') as datefrom,
                    to_char(dateto,'MM/DD/YYYY HH:MI AM') as dateto,
                    orders.createdby,
                    orders.datecreated,
                    status as stat,
                    array_to_string(array_agg(Q.remark||'~@~'||Q.datecreated::timestamp(0)),'||') as remark
                from orders
                left join Q on (orders.pk = Q.orderspk)
                where pk = $this->pk
                group by
                    pk,
                    customername,
                    mobilephone,
                    landline,
                    loc,
                    datefrom,
                    dateto,
                    orders.createdby,
                    orders.datecreated,
                    stat
                ;
EOT;
        return ClassParent::get($sql);
    }

    public function update($remark){
        $remark = pg_escape_string(trim(strip_tags($remark)));

        $sql = "begin;";
        $sql .= <<<EOT
                update orders
                set
                (
                    customername,
                    mobilephone,
                    landline,
                    location,
                    datefrom,
                    dateto,
                    createdby,
                    status
                )
                =
                (
                    '$this->customername',
                    '$this->mobilephone',
                    '$this->landline',
                    '$this->location',
                    '$this->datefrom'::timestamptz,
                    '$this->dateto'::timestamptz,
                    '$this->createdby',
                    '$this->status'
                )
                where pk = $this->pk
                ;
EOT;
        if($remark){
            $sql .= <<<EOT
                insert into orders_remarks
                (
                    orderspk,
                    remark,
                    createdby
                )
                values
                (
                    $this->pk,
                    '$remark',
                    '$this->createdby'
                )
                ;
EOT;
        }
        
        $sql .= "commit;";

        return ClassParent::update($sql);
    }
}
?>