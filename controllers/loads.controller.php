<?php

class LoadsController extends Controller {
    
    public function __construct($data = array()) {
        parent::__construct($data); // вызываем конструктор из родительского класса с атрибутом data в кот.храняться данные для представления
        $this->model = new Load();
    }
    
    public function index(){
        $path = 'upload'.DS;
        if(isset($_FILES['file']['tmp_name'])) {
            
            //проверяем наличие и тип загружаемого файла
            if(empty($_FILES['file']['tmp_name'])){
                Session::setFlash('Error. File not found.');
            }
            elseif($_FILES['file']['type'] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && $_FILES['file']['type'] != 'application/vnd.ms-excel'){
                Session::setFlash('Error. File is not Excel format.');
            }
            else{
                move_uploaded_file($_FILES['file']['tmp_name'], $path.$_FILES['file']['name']);
                Session::setFlash('Ok! File was loaded.');
                
                //получаем имя файла
                $filename = $_FILES['file']['name'];
                //подключаем класс PHPExcel_IOFactory
                require_once(ROOT.DS.'vendor'.DS.'phpoffice'.DS.'phpexcel'.DS.'Classes'.DS.'PHPExcel'.DS.'IOFactory.php');
                // Открываем файл
                $xls = PHPExcel_IOFactory::load('upload'.DS.$filename);
                // Устанавливаем индекс активного листа
                $xls->setActiveSheetIndex(0);
                // Получаем активный лист
                $sheet = $xls->getActiveSheet();
                $rowIterator = $sheet->getRowIterator();
                foreach ($rowIterator as $keys => $row) {
                    // Получили ячейки текущей строки и обойдем их в цикле
                    $cellIterator = $row->getCellIterator();
                    foreach ($cellIterator as $key => $cell) {
                        $this->data[$key] = $cell->getCalculatedValue();
                    }
                    $this->model->save($this->data); //циклично записываем полученные из файла данные в БД с помощью метода save обьекта model
                }
            }
        }
    }
}
