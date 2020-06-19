<?php

include (__DIR__ . '/../vendor/autoload.php');

######################## outZip 测试 ########################
function outZipTest()
{
    $filenameArray = [
        __DIR__ . '/../src/core/ArrayHelper.php',
        __DIR__ . '/../src/core/FileHelper.php',
    ];

    try {
        \Yb98k\ybTools\core\FileHelper::outZip($filenameArray, 'ybCore.zip', false);
    } catch (Exception $ex) {
        var_dump($ex->getMessage());
    }
}

######################## download 测试 ########################
function downloadTest()
{
    \Yb98k\ybTools\core\FileHelper::download('ybCore.zip');
}





function main()
{
    $param = getopt('', ['method::']);
    if (isset($param['method'])) $param['method']();
}

main();
