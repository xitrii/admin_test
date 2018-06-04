<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 14:00
 */


/**
 * Class PageFactory
 * Весь sql не выходит за рамки этого класса
 */
class PageFactory
{


    public static function add(PageModel $pageModel) {
        $values = $pageModel->__toArray();
        System::get('DbClass')->query('INSERT INTO pages ('.implode(',', array_keys($values)).') VALUES ("'.implode('","', $values).'")');
        return $pageModel;
    }

    public static function update($params) {
        $update_str = [];
        foreach ($params as $key => $value) {
            $update_str[] = $key . ' = "'. $value . '"';
        }
        System::get('DbClass')->query('UPDATE pages SET ' . implode(', ', $update_str) . ' WHERE id='.$params['id']);
        return true;
    }

    public static function delete($id) {
        System::get('DbClass')->query('DELETE FROM pages WHERE id='.$id);
        return ['id' => $id];
    }





    public static function getByParams(array $params) {
        $pages = [];
        $query = 'SELECT id, title, head, body, ext_body, date_create, date_update FROM pages ';
        if (!empty($params)) {
            $query .= 'WHERE ';
            foreach ($params as $param) {
                $query .= implode(' ', $param);
            }
        }

        $result = System::get('DbClass')->query($query);
        foreach ($result as $_page) {
            $pageModel = new PageModel();
            $pageModel->setBody($_page['body']);
            $pageModel->setDateCreate($_page['date_create']);
            $pageModel->setDateUpdate($_page['date_update']);
            $pageModel->setExtBody($_page['ext_body']);
            $pageModel->setHead($_page['head']);
            $pageModel->setId($_page['id']);
            $pageModel->setTitle($_page['title']);
            $pages[] = $pageModel->__toArray();
        }
        return $pages;
    }
}