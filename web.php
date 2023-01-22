<?php

require_once __DIR__ . '/controllers.php';


get('/', 'homeController');

get('/rename', 'renameIndexController');
post('/rename', 'renameController');

get('/remove', 'removeIndexController');
delete('/remove', 'removeController');

get('/createFile', 'createFileIndexController');
put('/createFile','createFileController');


get('/createDir', 'createDirIndexController');
put('/createDir','createDirController');




get('/copy', 'copyIndexController');
post('/copy', 'copyController');

get('/move', 'moveController');

solve();
