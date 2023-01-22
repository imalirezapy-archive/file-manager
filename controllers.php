<?php

function homeController()
{
    $address = validAddress(query('address'));

    if (is_null($address)) {
        header('Location: /?address='. validAddress(__DIR__ . '/root'));
        return;
    }
    view('home', ['files' => listDirectory($address)]);
}

function renameIndexController()
{
    $address = validAddress(query('address'));
    $names = explode('\\', $address);
    $info = [
        'name' => end($names),
        'parent' => getParent($address),
        'is_dir' => is_dir($address),
    ];

    return view('rename', $info);

}
function renameController()
{

    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
    }



    $name = request('name');

    if (!preg_match('/^[\w\d\s\.\-\s]*$/', trim($name), $name)) {
        header('Location: /?address='.getParent($address));
        return;
    };

    $path = explode('\\', $address);
    if ($name[0] == end($path)){
        header('Location: /?address='.getParent($address));
        return;
    }


    $path = join('\\', array_slice($path, 0, count($path)-1));

    if (is_dir($address)) {
        copyDirectory($address, $path. '\\' . $name[0]);
        deleteDirectory($address);
        header('Location: /?address='.getParent($address));
        return;
    };

   rename($address, $path . '\\' . $name[0]);
   header('Location: /?address='.getParent($address));
    return;

}

function removeIndexController()
{
    $address = validAddress(query('address'));
    #TODO: convert address to php constant
    $names = explode('\\', $address);

    $info = [
        'name' => end($names),
        'parent' => getParent($address),
        'is_dir' => is_dir($address),
    ];
    view('remove', $info);
}

function removeController()
{

    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
    }

    if (is_dir($address)) {
        deleteDirectory($address);
    }
    deleteFile($address, '');
    header('Location: /?address='.getParent($address));
}

function createFileIndexController()
{
    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
    }


    view('create', ['is_dir' => false, 'address' => $address]);
    return;
}

function createFileController()
{
    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
    }
    $name = request('name');

    if (!preg_match('/^[\w\d\s\.\-\s]*$/', trim($name), $name)) {
        header('Location: /?address='.getParent($address));
        return;
    };

    createFile($name[0], $address);
    header('Location: /?address='.$address);
    return;
}


function createDirIndexController()
{
    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
    }

    view('create', ['is_dir' => true, 'address' => $address]);
    return;
}

function createDirController()
{
    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
    }
    $name = request('name');

    if (!preg_match('/^[\w\d\s\.\-\s]*$/', trim($name), $name)) {
        header('Location: /?address='.$address);
        return;
    };

    createDirectory($name[0], $address);
    header('Location: /?address='.$address);
    return;
}

function copyIndexController()
{
    $address = validAddress(query('address'));

    if ($address == null || !file_exists($address)) {
        abort(400);
    }

    $names = explode('\\', $address);

    $info = [
        'name' => end($names),
        'parent' => getParent($address),
        'is_dir' => is_dir($address),
    ];
    view('copy', $info);
    return;
}
function copyController()
{
    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
        return;
    }

    $path = validAddress(request('path'));
    if (is_null($path) || trim($path == '')) {
        abort(400);
        return;
    }
    if (is_dir($address)) {
        copyDirectory($address, $path);
    } else {
        copyFile($address, $path);
    }

    header('Location: /?address='.getParent($address));
    return;
}

function moveIndexController()
{
    $address = validAddress(query('address'));

    if ($address == null || !file_exists($address)) {
        abort(400);
    }

    $names = explode('\\', $address);

    $info = [
        'name' => end($names),
        'parent' => getParent($address),
        'is_dir' => is_dir($address),
    ];

    view('move', $info);
    return;

}

function moveController()
{
    $address = validAddress(query('address'));
    if ($address == null || !file_exists($address)) {
        abort(400);
        return;
    }

    $path = validAddress(request('path'));
    if (is_null($path) || trim($path == '')) {
        abort(400);
        return;
    }
    if (is_dir($address)) {
        copyDirectory($address, $path);
        deleteDirectory($address);
    } else {
        copyFile($address, $path);
        deleteFile($address);
    }

    header('Location: /?address='.getParent($address));
    return;
}



