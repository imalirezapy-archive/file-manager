<?php

function getMethod() : string
{
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    if ($method == 'get') {
        return $method;
    }

    if (isset($_POST['_method'])) {
        $method = strtolower($_POST['_method']);
        if (in_array($method, ['put', 'patch', 'delete'])) {
            return $method;
        };
    }

    return 'post';

}

function getUrl() : string
{
    $url = $_SERVER['REQUEST_URI'];

    $position = strpos($url, '?');

    if ($position !== false) {
        $url = substr($url, 0, $position);
    }
    return $url;
}

function isGet()
{
    return getMethod() == 'get';
}

function isPost()
{
    return in_array(getMethod(), ['put', 'post', 'patch', 'delete']);
}

function query(string $key=null)
{
    $data = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);

    if (!is_null($key)) {
        if (isset($data[$key])) {
            return urldecode($data[$key]);
        }
        return null;
    }

    return $data;
}


function request(string $key=null)
{
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    if (!is_null($key)) {
        return $data[$key] ?? null;
    }

    return $data;
}