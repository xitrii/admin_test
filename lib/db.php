<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 13:56
 */

class DbClass
{
    private $mysqli;

    /**
     * Подключение к БД
     * @param $connectParams
     * @throws Exception
     */
    public function __construct($connectParams) {
        $this->mysqli = new mysqli($connectParams['host'], $connectParams['user'], $connectParams['pass'], $connectParams['db']);

        if( $this->mysqli->connect_error ){
            $error = "Ошибка подключения (" . $this->mysqli->connect_errno . ") ".$this->mysqli->connect_error;
            throw new Exception($error);
        }

        if( !$this->mysqli->set_charset("utf8") ){
            $error = "Ошибка подключения ".$this->mysqli->error;
            throw new Exception($error);
        }
    }


    /**
     * @param $query
     * @return array
     * @throws Exception
     */
    public function query($query){
        $result = [];

        $mysqliResult = $this->mysqli->query($query);
        if( $mysqliResult !== false ){
            if( $mysqliResult->num_rows > 0 ){
                for( $i = 0; $i < $mysqliResult->num_rows; $i++ ){
                    $result[] = $mysqliResult->fetch_assoc();
                }
            }
        } else {
            throw new Exception($this->mysqli->error . " В ЗАПРОСЕ " . $query);
        }

        return $result;
    }
}