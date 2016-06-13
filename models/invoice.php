<?php
//для работы с авторизацией

class Invoice extends Model {
    
    public function getList() {
        $sql = "select * from pricelist where 1";
        return $this->db->query($sql);
    }
    
    public function checkConsultTaxID($data){
        $sql = "select tax_id from order_header where tax_id = '{$data['tax_id']}'";
        $check_tax_id = $this->db->query($sql);
        return $check_tax_id;
    }

    public function saveHeader($data){ //добавляет или обновляет данные в табл.
        if(!isset($data['order_date']) || !isset($data['consult_name']) || !isset($data['tax_id']) || !isset($data['consult_num'])){ //проверяем заполнены ли все поля формы
            return false;
    }
        
        //подготавливаем данные перед записью в БД
        $order_date = $this->db->escape($data['order_date']);
        $consult_name= $this->db->escape($data['consult_name']);
        $consult_num = $this->db->escape($data['consult_num']);
        $tax_id = $this->db->escape($data['tax_id']);
        $comment = $this->db->escape($data['comment']);
        $operator_name = $this->db->escape($data['operator_name']);
        $operator_role = $this->db->escape($data['operator_role']);
        
        $sql = "
            insert into order_header
            set order_date = '{$order_date}',
                consult_name = '{$consult_name}',
                tax_id = '{$tax_id}',
                consult_num = '{$consult_num}',
                comment = '{$comment}',
                operator_name = '{$operator_name}',
                operator_role = '{$operator_role}'
            ";
        return $this->db->query($sql); //возвращаем результат запроса к БД
    }
    
    public function getOrderID($data){ //получаем из БД номер заказа
        $sql = "select order_id from order_header where order_date = '{$data['order_date']}' and consult_name = '{$data['consult_name']}' and tax_id = '{$data['tax_id']}'";
        return $this->db->query($sql);
    }
    
    public function saveOrder($data){
        $str = '';
        foreach($data as $value){ //проходим циклом по массиву, формируем строку запроса к БД
            $str .= "(";
            foreach ($value as $val){
                $str .= "'".$this->db->escape($val)."',";
            }
            $str = trim($str,",");
            $str.="),";
        }
        $str = trim($str,",");
        $sql = "insert into orders (`order_id`, `product_id`, `product_code`, `product_name`, `product_qnty`, `product_price`) values ".$str;
        return $this->db->query($sql);
    }
    
    public function deleteOrder($data){
        $sql = "
            delete from order_header where order_id = '{$data}';
            ";
        return $this->db->query($sql);
    }
    
    public function getOrderDetail($data) {
        $sql = "
                select 	order_header.order_id, 
                        order_header.order_date, 
                        order_header.consult_name,
                        order_header.tax_id,
                        order_header.consult_num,
                        order_header.operator_name,
                        order_header.operator_role,
                        orders.product_code,
                        orders.product_name,
                        orders.product_qnty,
                        orders.product_price
                from    order_header, 
                        orders
                where   order_header.order_id = orders.order_id
                    and order_header.order_id = '{$data}';
                ";
        return $this->db->query($sql);
    }
    
    public function saveConsultHeader($data){ //добавляет или обновляет данные в табл.
        if(!isset($data['order_date']) || !isset($data['consult_name']) || !isset($data['consult_num'])){ //проверяем заполнены ли все поля формы
            return false;
    }
        
        //подготавливаем данные перед записью в БД
        $order_date = $this->db->escape($data['order_date']);
        $consult_name= $this->db->escape($data['consult_name']);
        $consult_num = $this->db->escape($data['consult_num']);
        $tax_id = $this->db->escape($data['tax_id']);
        $comment = $this->db->escape($data['comment']);
        $operator_name = $this->db->escape($data['operator_name']);
        $operator_role = $this->db->escape($data['operator_role']);
        
        $sql = "
            insert into order_header
            set order_date = '{$order_date}',
                consult_name = '{$consult_name}',
                tax_id = '{$tax_id}',
                consult_num = '{$consult_num}',
                comment = '{$comment}',
                operator_name = '{$operator_name}',
                operator_role = '{$operator_role}'
            ";
        return $this->db->query($sql); //возвращаем результат запроса к БД
    }
    
    public function getConsultOrderID($data){ //получаем из БД номер заказа
        $sql = "select order_id from order_header where order_date = '{$data['order_date']}' and consult_name = '{$data['consult_name']}' and consult_num = '{$data['consult_num']}'";
        return $this->db->query($sql);
    }
    
    public function searchInvoice($data){ //получаем из БД номер заказа
        $sql = "select order_id from order_header where order_id = '{$data}'";
        return $this->db->query($sql);
    }
}