<?php

function jsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}

function redirect_back()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}