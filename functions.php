<?php

function validAddress($address)
{
    $address = trim(urldecode($address));
    if (is_null($address) or $address == '') {
        return null;
    }
    $address = preg_replace('/[\\\|\/]+/', DIRECTORY_SEPARATOR, trim($address));
    if ($address[strlen($address)-1] == DIRECTORY_SEPARATOR){
        $address = join(DIRECTORY_SEPARATOR, array_filter(explode(DIRECTORY_SEPARATOR, $address), fn($i) => $i != ''));

    }

//    preg_match('/^\w+\:(\\\[\w\d\-\s\.]+)*$/', $address, $matches);

    return $address;
}

function getParent($address)
{
    $address = validAddress($address);
    $parent_address = explode(DIRECTORY_SEPARATOR, $address);
    $parent_address = join(DIRECTORY_SEPARATOR, array_slice($parent_address, 0, count($parent_address)-1));
    return $parent_address;

};
function fileInfo($address, $name)
{
    $address = validAddress($address);
    $path = validAddress($address . '/' . $name);

    if (!file_exists($path)) {
        return [];
    }

    $fileNameParts = explode('.', $name);
    $is_dir = is_dir($path);
    $name = $is_dir ?
            $name :
            join('.', array_slice($fileNameParts, 0, count($fileNameParts)-1));

    error_reporting(E_ERROR | E_PARSE);
    $mime = mime_content_type($path) ?? null;




    if ($name == '..') {
        return [
            'name' => $name,
            'href' => "/?address=".getParent($address),
        ];
    }
    return [
        'name' => $name,
        'href' => "$path",
        'is_dir' => $is_dir,
        'mime' => $mime,
        'extension' => $is_dir ? 'Folder File' :  end($fileNameParts),
        'size' => filesize($path)
    ];
}

function listDirectory($address)
{
//    $path = __DIR__ . validAddress($address);

    $address = validAddress($address);

    if (!file_exists($address)) {
        return abort(404);
    }

    $ls = array_slice(scandir($address), 1);


    for ($i = 0; $i < count($ls); $i++) {
        $ls[$i] = fileInfo($address,$ls[$i]);
    }

    return $ls;
}

function createFile($name, $address)
{
    $name = trim($name);
    $address = validAddress($address);

//    $path = __DIR__."$address/$name";
    $path = "$address\\$name";

    if (file_exists($path) or $name == "") {
        return;
    }
    createDirectory($address, '');
    file_put_contents($path, '');

}

function createDirectory($name, $address)
{
    $address = validAddress($address);

//    $path = __DIR__."$address$name";
    $path = "$address\\$name";

    if (file_exists($path) or trim($name) == '') {
        return;
    }

    mkdir($path, 0777, true);
}

function deleteFile($address)
{
    $address = validAddress($address);


    if ((!file_exists($address))) {
        return;
    }

    unlink($address);
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

    foreach (scandir($address) as $item) {
        if ($item == '..' || $item == '.') {
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
            $path = $path['dirname'].DIRECTORY_SEPARATOR.$path['basename'];

            $files[] = str_replace('./', '',str_replace(DIRECTORY_SEPARATOR ,'/', $path));
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

    return require __DIR__ . '/views'. '/'.$path.'.view.php';
}

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die();

}

function dump($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function abort($code)
{
    http_response_code($code);

    view('404');

    die();
}


function addressMap()
{

    $address = explode(DIRECTORY_SEPARATOR, validAddress(query('address')));
    $map = [];

    foreach ($address as $key => $dir) {
        $href = join(DIRECTORY_SEPARATOR, array_slice($address, 0, $key+1));

        if (!file_exists($href)) {
            $url = null;
        }
        $map[] = [
            'name' => $dir,
            'href' => $href,
        ];

    }

    return $map;
}




function copyDirectory(
    string $sourceDirectory,
    string $destinationDirectory,
    string $childFolder = ''
): void {
    $directory = opendir($sourceDirectory);

    if (is_dir($destinationDirectory) === false) {
        mkdir($destinationDirectory);
    }

    if ($childFolder !== '') {
        if (is_dir("$destinationDirectory/$childFolder") === false) {
            mkdir("$destinationDirectory/$childFolder");
        }

        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir("$sourceDirectory/$file") === true) {
                copyDirectory("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            } else {
                copy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            }
        }

        closedir($directory);

        return;
    }

    while (($file = readdir($directory)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_dir("$sourceDirectory". DIRECTORY_SEPARATOR. $file) === true) {
            copyDirectory("$sourceDirectory". DIRECTORY_SEPARATOR. $file, "$destinationDirectory". DIRECTORY_SEPARATOR. $file);
        }
        else {
            copy("$sourceDirectory". DIRECTORY_SEPARATOR. $file, "$destinationDirectory". DIRECTORY_SEPARATOR. $file);
        }
    }

    closedir($directory);
}














