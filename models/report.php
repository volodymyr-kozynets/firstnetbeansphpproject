<?php

class Report extends Model{
    
    public function getInvoiceReport($data){
        $sql = "
            select  order_id, 
                    order_date, 
                    consult_name,
                    tax_id,
                    consult_num,
                    operator_name
            from    order_header
            where   order_date between '{$data['startdate']}' and '{$data['finishdate']}';
        ";
        return $this->db->query($sql);
    }
    
    public function getProductList() {
        $sql = "select * from pricelist where 1";
        return $this->db->query($sql);
    }
    
    public function getProductReport($data){
        $sql = "
            select  orders.product_code,
                    orders.product_name,
                    orders.product_qnty,
                    orders.order_id,
                    order_header.order_date
            from    order_header,
                    orders
            where   order_header.order_id = orders.order_id and orders.product_code = '{$data['product']}' and order_header.order_date between '{$data['startdate']}' and '{$data['finishdate']}';
        ";
        return $this->db->query($sql);
    } 
}
