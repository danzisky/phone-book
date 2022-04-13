<?php

class Respond {

    function sendHeader ($url, $status, $message) {
        return header('Location: '.$url.'?status='.$status.'&message='.$message);
        exit();
    }

}