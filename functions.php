<?php

function validAddress($address)
{
    if (is_null($address)) {
        return '';
    }
    $pattern = '/([\w\d\.]+[\s\-]*)/';

    preg_match_all($pattern, trim($address), $matches);
    $path = join('/', $matches[0]);
    if (in_array($path, ['', '.'])) {
        return '';
    }
    return '/' . $path;
}

function listDirectory($address)
{
//    $path = __DIR__ . validAddress($address);
    $path = $address;

    if (!file_exists($path)) {
        return [];
    }

    $ls = array_slice(scandir( $path), 1);
    sort($ls);
    return $ls;
}

function createFile($name, $address)
{
    $name = trim($name);
    $address = validAddress($address);

//    $path = __DIR__."$address/$name";
    $path = "$address/$name";

    if (file_exists($path) or $name == "") {
        return;
    }
    createDirectory($address, '');
    file_put_contents($path, '');

}

function createDirectory($name, $address)
{
    $name = validAddress($name);
    $address = validAddress($address);

//    $path = __DIR__."$address$name";
    $path = $address . $name;

    if (file_exists($path) or $name == '') {
        return;
    }

    mkdir($path, 0777, true);
}

function deleteFile($name, $address)
{
    $address = validAddress($address);

//    $path = __DIR__ . $address . '/' . $name;
    $path =  $address . '/' . $name;
    if ((!file_exists($path)) or $name == "") {
        return;
    }

    unlink($path);
}

function deleteDirectory($address)
{
    $address = validAddress($address);
//    $path = __DIR__ . $address;
    $path = $address;
    if (!file_exists($path)) {
        return true;
    }

    if (!is_dir($path)) {
        return unlink($path);
    }

    foreach (listDirectory($address) as $item) {
        if ($item == '..') {
            continue;
        }
        if (!deleteDirectory($address . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }
    return rmdir($path);
}

function searchFile($name, $address)
{
//    $address = __DIR__.validAddress($address);
    $address = '.' . validAddress($address);
    if (!is_dir($address) ) {
        return [];
    }
    $di = new RecursiveDirectoryIterator($address,  );
    $iterator = new RecursiveIteratorIterator($di);

    $files = [];
    foreach ($iterator as $filename => $file) {
        $path = pathinfo($filename);
        if ($path['basename'] == $name) {
//            $last_path = explode('/',$path['dirname']);
            $path = $path['dirname'].'\\'.$path['basename'];

            $files[] = str_replace('./', '',str_replace('\\' ,'/', $path));
        }
    }
    return $files;
}

function editFile($name, $address, $content)
{
//    $address = __DIR__ . validAddress($address);
    $address =  validAddress($address);

    $path = "$address/$name";
    if ((!file_exists($path)) or $name == "") {
        return;
    }
    file_put_contents($path, $content);
}

function getFile($name, $address)
{
//    $path = __DIR__ . validAddress($address) . '/' . trim($name);
    $path = validAddress($address) .  '/' . trim($name);

    if (!file_exists($path)) {
        return '';
    }

    return file_get_contents($path);
}

function copyFile($from, $to)
{
//    $from = __DIR__ . validAddress($from);
//    $to = explode('/',__DIR__ . validAddress($to));
    $from = validAddress($from);
    $to = explode('/', validAddress($to));

    if ((!file_exists($from)) or (!$to)) {
        return;
    }

    $to_directories = join('/', array_slice($to, 1, -1));

    createDirectory( $to_directories , '');

    $from = explode('/', $from);

    $from_file_name = $from[count($from)-1];
    $from_path = join('/',array_slice($from, 1, -1)??[]);

    file_put_contents(join('/',$to), getFile($from_file_name, $from_path));
}


function moveFile($from, $to)
{
//    $from = __DIR__ . validAddress($from);
//    $to = explode('/',__DIR__ . validAddress($to));

    $from = validAddress($from);
    $to = explode('/', validAddress($to));

    if ((!file_exists($from)) or (!$to)) {
        return;
    }

    $to_directories = join('/', array_slice($to, 1, -1));
    createDirectory($to_directories, '');

    rename($from, join('/', $to));
}

function view($path, $data=[])
{
    extract($data);
    return require __DIR__ . '/views'.validAddress($path).'.view.php';
}