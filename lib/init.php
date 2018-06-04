<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 14:24
 */


include_once "../vendor/autoload.php";
class System{

    //Массив ссылок на объекты
    private static $objects = array();

    /**
     *
     * @param string $class_name
     * @param mixed $args
     * @param boolean $object_name
     * @return boolean
     */
    public static function registerObject($class_name,$args,$object_name = false){
        try{
            //Объект ReflectionClass для класса $class_name
            $class = new ReflectionClass($class_name);
            if(!$object_name)
                $object_name = $class_name;
            //Создание объекта
            self::$objects[$object_name] = $class->newInstance($args);
            return true;
        }
        catch(Exception $e){
            //Обработку исключения предполагается изменить каким-либо образом..
            echo $e->getMessage();
        }
        return false;
    }


    public static function get($object_name){
        return self::$objects[$object_name];
    }

}

//Регистрируем объект глобального доступа Db для работы с БД
System::registerObject('DbClass',array(
    'host' => 'ip',
    'user' => 'user',
    'pass' => 'pass',
    'db' => 'test'
));
