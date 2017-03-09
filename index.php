<?php
/**
 * точка входа
 */
define('MK', TRUE);
//отправка заголовка типа документа и кодировки
header("Content-Type:text/html;charset=utf-8");
//не показывать ошибки
error_reporting(E_ALL);
//начало сессии
session_start();
//подключение конфигурационного файла
require 'config.php';
//изменение путей подключаемых файлов
set_include_path(get_include_path()
				.PATH_SEPARATOR.CONTROLLER
				.PATH_SEPARATOR.MODEL
				.PATH_SEPARATOR.LIB
				);
//автозагрузка классов МОЖНО ПЕРЕПИСАТЬ
function myautoload($class_name) {
    $filename = $class_name.'.php';
    if(file_exists($filename) || file_exists(CONTROLLER.DIRECTORY_SEPARATOR.$filename) || file_exists(MODEL.DIRECTORY_SEPARATOR.$filename) || file_exists(LIB.DIRECTORY_SEPARATOR.$filename)){
        require_once $filename;
    }else{
        throw new Exception('Не правильный файл для подключения');
    }
}

try{
    spl_autoload_register('myautoload');
    $obj = Route_Controller::get_instance();
    $obj->route();//создает объект класса controller
}

catch (Exception $e){
    echo $e->getMessage();
    exit;
}
