<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 13:44
 */

class PageController
{


    public function get() {
        $params = filter_input_array(INPUT_GET);
       /** @var PageModel $pageModel */
        $pageModelKeys = (new PageModel())->__toArray();
        foreach (array_keys($params) as $key) {
            if (!array_key_exists($key, $pageModelKeys))
                throw new RestException(400,'Ошибка выполнения запроса','Неверный параметр');
        }
        $_params = [];
        foreach ($params as $key => $param) {
            $_params[] = [$key, '=', $param];
        }

        return PageFactory::getByParams($_params);
    }

    public function post() {
        $params = $this->getHttpBody();
        $pageModel = new PageModel();
        $pageModel->setHead(isset($params['head']) ? $params['head'] : '');
        $pageModel->setTitle(isset($params['title']) ? $params['title'] : '');
        $pageModel->setBody(isset($params['body']) ? $params['body'] : '');
        $pageModel->setExtBody(isset($params['ext_body']) ? $params['ext_body'] : '');
        $dateTime = date('Y-m-d H:i:s');
        $pageModel->setDateCreate($dateTime);
        $pageModel->setDateUpdate($dateTime);
        PageFactory::add($pageModel);
        return [$pageModel->__toArray()];
    }

    public function put() {
        $params = $this->getHttpBody();
        if (!isset($params['id'])) {
            throw new RestException(400, 'Ошибка выполнения запроса','Не найден идентификатор');
        }
        if (empty(PageFactory::getByParams([['id', '=', $params['id']]]))){
            throw new RestException(404, 'Ошибка выполнения запроса', 'Не найдена запись');
        }
        /** @var PageModel $pageModel */
        $pageModelKeys = (new PageModel())->__toArray();
        foreach (array_keys($params) as $key) {
            if (!array_key_exists($key, $pageModelKeys))
                throw new RestException(400,'Ошибка выполнения запроса','Неверный параметр');
        }
        $params['date_update'] = date('Y-m-d H:i:s');
        PageFactory::update($params);
        return true;
    }

    public function delete() {
        $params = filter_input_array(INPUT_GET);
        if (!isset($params['id'])) {
            throw new RestException(400, 'Ошибка выполнения запроса','Не найден идентификатор');
        }
        if (empty(PageFactory::getByParams([['id', '=', $params['id']]]))){
            throw new RestException(404, 'Ошибка выполнения запроса', 'Не найдена запись');
        }
        return PageFactory::delete($params['id']);
    }


    protected function getHttpBody()
    {
        $params = [];
        $putData = file_get_contents('php://input');
        if (!empty($putData)) {
            $params = json_decode($putData, true);
        }
        return $params;
    }
    public function render($dataRows)
    {
        return json_encode([
            'status' => 200,
            'error' => '',
            'message' => '',
            'data' => [
                'rows' => $dataRows,
            ]
        ]);
    }

}