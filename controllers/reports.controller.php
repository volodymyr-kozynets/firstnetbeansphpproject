<?php

class ReportsController extends Controller {
    
    public function __construct($data = array()) {
        parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
        $this->model = new Report();
    }

    public function index(){

    }

    public function invoicereport(){
        if($_REQUEST){
            $this->data = $this->model->getInvoiceReport($_POST);
            for($i=0; $i<count($this->data); $i++){
                $date = $this->data[$i]['order_date'];
                $this->data[$i]['order_date'] = @date('d.m.Y', strtotime($date));
            }
        }
    }
    
    public function xlsinvoicereport(){
        if($_REQUEST){
            $this->data = $this->model->getInvoiceReport($_POST);
            $result = $this->data;
            for($i=0; $i<count($this->data); $i++){
                $date = $this->data[$i]['order_date'];
                $this->data[$i]['order_date'] = @date('d.m.Y', strtotime($date));
            }
            require_once(ROOT.DS.'vendor'.DS.'phpoffice'.DS.'phpexcel'.DS.'Classes'.DS.'PHPExcel.php');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $active_sheet = $objPHPExcel->getActiveSheet();

            //Создаем шапку таблички данных
            $active_sheet->setCellValue('A1','Номер накладной');
            $active_sheet->setCellValue('B1','Дата накладной');
            $active_sheet->setCellValue('C1','ФИО Консультанта');
            $active_sheet->setCellValue('D1','ИНН Консультанта');
            $active_sheet->setCellValue('E1','Консультантский номер');
            $active_sheet->setCellValue('F1','Оператор');

            //В цикле проходимся по элементам массива и выводим все в соответствующие ячейки
            $row_start = 2;
            $i = 0;
            foreach($result as $item) {
                    $row_next = $row_start + $i;

                    $active_sheet->setCellValue('A'.$row_next,$item['order_id']);
                    $active_sheet->setCellValue('B'.$row_next,$item['order_date']);
                    $active_sheet->setCellValue('C'.$row_next,$item['consult_name']);
                    $active_sheet->setCellValue('D'.$row_next,$item['tax_id']);
                    $active_sheet->setCellValue('E'.$row_next,$item['consult_num']);
                    $active_sheet->setCellValue('F'.$row_next,$item['operator_name']);

                    $i++;
            }

            header("Content-Type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename='invoice_report.xls'");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function productreport(){
        $this->data['product'] = $this->model->getProductList();
        if($_REQUEST){
            $this->data = $this->model->getProductReport($_POST);
            for($i=0; $i<count($this->data); $i++){
                $date = $this->data[$i]['order_date'];
                $this->data[$i]['order_date'] = @date('d.m.Y', strtotime($date));
            }
            $this->data['product'] = $this->model->getProductList();
        }
    }
    
    public function xlsproductreport(){
        $this->data['product'] = $this->model->getProductList();
        if($_REQUEST){
            $this->data = $this->model->getProductReport($_POST);
            $result = $this->data;
            for($i=0; $i<count($this->data); $i++){
                $date = $this->data[$i]['order_date'];
                $this->data[$i]['order_date'] = @date('d.m.Y', strtotime($date));
            }
            $this->data['product'] = $this->model->getProductList();
            
            require_once(ROOT.DS.'vendor'.DS.'phpoffice'.DS.'phpexcel'.DS.'Classes'.DS.'PHPExcel.php');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $active_sheet = $objPHPExcel->getActiveSheet();

            //Создаем шапку таблички данных
            $active_sheet->setCellValue('A1','Код продукции');
            $active_sheet->setCellValue('B1','Наименование продукции');
            $active_sheet->setCellValue('C1','Количество продукции');
            $active_sheet->setCellValue('D1','Номер накладной');
            $active_sheet->setCellValue('E1','Дата накладной');

            //В цикле проходимся по элементам массива и выводим все в соответствующие ячейки
            $row_start = 2;
            $i = 0;
            foreach($result as $item) {
                    $row_next = $row_start + $i;

                    $active_sheet->setCellValue('A'.$row_next,$item['product_code']);
                    $active_sheet->setCellValue('B'.$row_next,$item['product_name']);
                    $active_sheet->setCellValue('C'.$row_next,$item['product_qnty']);
                    $active_sheet->setCellValue('D'.$row_next,$item['order_id']);
                    $active_sheet->setCellValue('E'.$row_next,$item['order_date']);

                    $i++;
            }

            header("Content-Type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename='product_report.xls'");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }
}

