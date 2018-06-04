<?php
/**
 * Created by IntelliJ IDEA.
 * User: akhmed
 * Date: 04.06.18
 * Time: 3:45
 */

class AuthController
{

    public static function authenticate() {
        $headers = getallheaders();
        if (!isset($headers['auth_token']) || $headers['auth_token'] == null)
            throw new RestException(401, 'Нет авторизации', 'Клиент не авторизован');
        $token = $headers['auth_token'];
        $user_id = $token[0];
        $query = 'SELECT login,token,login_date FROM users WHERE id = "'. $user_id . '"';
        $result = System::get('DbClass')->query($query);
        if (empty($result))
            throw new RestException(401, 'Нет авторизации', 'Клиент не найден');
        $user = $result[0];
        if ($token != $user['token'])
            throw new RestException(401, 'Нет авторизации', 'Клиент не авторизован');
        return true;

    }


    public function post() {
        $params = $this->getHttpBody();
        foreach (array_keys($params) as $key) {
            if (!in_array($key, ['login','password']))
                throw new RestException(400,'Ошибка выполнения запроса','Неверный параметр');
        }
        $query = 'SELECT id,login,password,token FROM users WHERE login = "'. $params['login'] . '"';
        $result = System::get('DbClass')->query($query);
        if (empty($result))
            throw new RestException(401, 'Нет авторизации', 'Клиент не найден');
        if (md5($params['password']) != $result[0]['password'])
            throw new RestException(401, 'Нет авторизации', 'Клиент не авторизован');
        $token = $result[0]['id'].'|'.md5($params['password'].date('H:i:s'));
        System::get('DbClass')->query('UPDATE users SET token = "'.$token.'" WHERE id='.$result[0]['id']);
        return $token;
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