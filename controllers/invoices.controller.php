<?php


class InvoicesController extends Controller{
        

    public function __construct($data = array()) {
        parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
        $this->model = new Invoice();
    }
        
    public function index(){ //обрабатываем массив с детялями заказа и вызываем функции записи данных о заказе в БД
        $this->data = $this->model->getList(); //получаем список товаров из БД
        if($_REQUEST){
            if($_POST['consult_name'] && $_POST['consult_num']){ //приводим массив к нормальному виду для записи в БД
                
                $check_tax_id = $this->model->checkConsultTaxID($_POST);
                if(empty($check_tax_id[0]['tax_id'])){ //проверяем по ИНН наличие Консультанта в БД
                    
                    $header_array = $_POST;
                    $header_array = array_slice($header_array, 0, 8); //отделяем "шапку" заказа от массива товаров
                    $this->model->saveHeader($header_array); //сохраняем шапку заказа в БД
                    $order_id = $this->model->getOrderID($header_array); //получаем номер заказа из БД
                    
                    $product_array = $_POST;
                    $product_array = array_slice($product_array, 8);
                    $product_array = array_chunk($product_array, 5, false); //каждому товару задаем отдельный подмассив
                    $ordered_product = array();
                    for($i=0; $i<count($product_array); $i++){ //проходим по массиву с заказанными товарами, заменяем индексы на ассоциативные
                        $product_array[$i]['product_id'] = $product_array[$i][0];
                        unset($product_array[$i][0]);
                        $product_array[$i]['product_code'] = $product_array[$i][1];
                        unset($product_array[$i][1]);
                        $product_array[$i]['product_name'] = $product_array[$i][2];
                        unset($product_array[$i][2]);
                        $product_array[$i]['product_qnty'] = $product_array[$i][3];
                        unset($product_array[$i][3]);
                        $product_array[$i]['product_price'] = $product_array[$i][4];
                        unset($product_array[$i][4]);
                        if($product_array[$i]['product_qnty'] != 0){ //отделяем товары с не нулевым количеством (кол. стоит в индексе product_qnty)
                            $ordered_product[$i] = array_merge($order_id[0], $product_array[$i]); //каждому заказанному товару добавляем номер заказа
                        }
                    }
                    if(!empty($ordered_product)){
                        $this->model->saveOrder($ordered_product);
                        Router::redirect('/default/invoices/printinvoices/'.$order_id[0]['order_id']); //перенаправляемся на страницу подтверждения и печати заказа
                    }else{
                        $this->model->deleteOrder($order_id[0]['order_id']);
                        Session::setFlash('Ошибка! Продукция не выбрана!'); 
                    }
                }else{
                    Session::setFlash('Ошибка! Идентификационный код '.$check_tax_id[0]['tax_id'].' присутствует в базе данных');
                }             
            }else{
                Session::setFlash('Ошибка! Не заполнено поле ФИО Консультанта');
            }
        }
    }
    
    public function printinvoices() {
        $order_id = $this->params;
        if($order_id){
            $this->data = $this->model->getOrderDetail($order_id[0]);
            for($i=0; $i<count($this->data); $i++){
                $date = $this->data[$i]['order_date'];
                $this->data[$i]['order_date'] = @date('d.m.Y', strtotime($date));
            }
        }
    }
    
    public function deleteinvoice(){
        if(isset($this->params[0])){
            $result = $this->model->deleteOrder($this->params[0]);
            if($result){
                Session::setFlash('Order was delete.');
            }else{
                Session::setFlash('Error.');
                }
        }
        Router::redirect('/invoices/');
    }
    
    public function consultinvoice(){ //обрабатываем массив с детялями заказа и вызываем функции записи данных о заказе в БД
        $this->data = $this->model->getList(); //получаем список товаров из БД
        if($_REQUEST){
            if($_POST['consult_name'] && !empty($_POST['consult_num'])){ //приводим массив к нормальному виду для записи в БД
                    
                    $header_array = $_POST;
                    $header_array = array_slice($header_array, 0, 8); //отделяем "шапку" заказа от массива товаров
                    $this->model->saveConsultHeader($header_array); //сохраняем шапку заказа в БД
                    $order_id = $this->model->getConsultOrderID($header_array); //получаем номер заказа из БД
                    
                    $product_array = $_POST;
                    $product_array = array_slice($product_array, 8);
                    $product_array = array_chunk($product_array, 5, false); //каждому товару задаем отдельный подмассив
                    $ordered_product = array();
                    for($i=0; $i<count($product_array); $i++){ //проходим по массиву с заказанными товарами, заменяем индексы на ассоциативные
                        $product_array[$i]['product_id'] = $product_array[$i][0];
                        unset($product_array[$i][0]);
                        $product_array[$i]['product_code'] = $product_array[$i][1];
                        unset($product_array[$i][1]);
                        $product_array[$i]['product_name'] = $product_array[$i][2];
                        unset($product_array[$i][2]);
                        $product_array[$i]['product_qnty'] = $product_array[$i][3];
                        unset($product_array[$i][3]);
                        $product_array[$i]['product_price'] = $product_array[$i][4];
                        unset($product_array[$i][4]);
                        if($product_array[$i]['product_qnty'] != 0){ //отделяем товары с не нулевым количеством (кол. стоит в индексе product_qnty)
                            $ordered_product[$i] = array_merge($order_id[0], $product_array[$i]); //каждому заказанному товару добавляем номер заказа
                        }
                    }
                    if(!empty($ordered_product)){
                        $this->model->saveOrder($ordered_product);
                        Router::redirect('/default/invoices/printinvoices/'.$order_id[0]['order_id']); //перенаправляемся на страницу подтверждения и печати заказа
                    }else{
                        $this->model->deleteOrder($order_id[0]['order_id']);
                        Session::setFlash('Ошибка! Продукция не выбрана!'); 
                    }
            }else{
                Session::setFlash('Ошибка! Не заполнено поле ФИО или Номер Консультанта');
            }
        }
    }
    
    public function searchinvoice(){
        if($_REQUEST){
            if(!empty($_POST['order_id'])){
                $order_id = $this->model->searchInvoice($_POST['order_id']);
                if(!empty($order_id)){
                    Router::redirect('/invoices/printinvoices/'.$order_id[0]['order_id']);
                }  else {
                    Session::setFlash('Номер накладной не найден.');
                }       
            }else{
                Session::setFlash('Номер накладной не найден.');
            }
        }
    }
}