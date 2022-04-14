<?php

class Respond {

    function sendHeader ($url, $status, $message) {
        return header('Location: '.$url.'?status='.$status.'&message='.$message);
        exit();
    }

}
class IfSet {
    function setValue ($expexted, $substitute) {
    $response = '';
    isset($expexted) ? $response = $expexted : $response = $substitute;

    return $response;
    }
    function ifIsset($expexted) {
        $response = '';
        isset($expexted) ? $response = true : $response = false;
        
        return $response;
    }
}

class Response {
    function generateResJSON ($status, $data=['data' => null], $message) {
        $response = array();
        $response['status'] = $status;
        $response['data'] = $data;
        $response['message'] = $message;
        $response = json_encode($response);
        echo $response;
        exit();
    }
    function sendResJSON ($response) {
        $response = json_encode($response);
        echo $response;
        exit();
    }
}