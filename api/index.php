<?php
/**
 * Created by IntelliJ IDEA.
 * User: bimdeer
 * Date: 01.06.18
 * Time: 13:43
 */

include '../lib/init.php';
try {
    header('Content-Type: application/json');
    $controllerName = explode('/', rtrim($_SERVER['REDIRECT_URL'], '/'))[2];

    if ($controllerName !== 'AuthController') {
        AuthController::authenticate();
   }

    if (!class_exists($controllerName)) {
        throw new RestException(403,'Ошибка выполнения запроса', 'Метод не поддерживается');
    }

    $controllerInstance = new $controllerName();
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

    if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST','PUT','DELETE']) || !method_exists($controllerInstance, $requestMethod)) {
        throw new RestException(403,'Ошибка выполнения запроса', 'Метод не поддерживается');
    }

    $result = $controllerInstance->$requestMethod();
    $responseCode = ($requestMethod === 'post') ? 201 : 200;
    http_response_code($responseCode);

    if ($requestMethod != 'delete') {
        echo $controllerInstance->render($result);
    }
}catch (RestException $controllerInstance){
    http_response_code($controllerInstance->getStatus());
    echo json_encode($controllerInstance->__toArray());
}
