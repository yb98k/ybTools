<?php

include (__DIR__ . '/../vendor/autoload.php');

######################## toArray 测试 ########################
function toArrayTest()
{
    class TestParam {

        public $id = 0;

        public $name = '测试1';

        public $desc = '描述1';

        public $params = [
            'A' => 'xxxA',
            'B' => 'xxxB',
        ];
    }

    $res = \Yb98k\ybTools\core\ArrayHelper::toArray(new TestParam());
    var_dump($res);
}

######################## arraySort 测试 ########################
function arraySortTest()
{
    $testArr = [
        ['name' => '名称1', 'id' => 3, 'num' => 4],
        ['name' => '名称2', 'id' => 30, 'num' => 2],
        ['name' => '名称3', 'id' => 16, 'num' => 3],
        ['name' => '名称4', 'id' => 10, 'num' => 1],
        ['name' => '名称5', 'id' => 17, 'num' => 5],
    ];

    \Yb98k\ybTools\core\ArrayHelper::arraySort($testArr, 'id desc,num desc');
    var_dump($testArr);
}

######################## arraySwitch 测试 ########################
function arrayColumnsTest()
{
    $testArr = [
        ['name' => '名称1', 'id' => 3, 'num' => 4],
        ['name' => '名称2', 'id' => 30, 'num' => 2],
        ['name' => '名称3', 'id' => 16, 'num' => 3],
        ['name' => '名称4', 'id' => 10, 'num' => 1],
        ['name' => '名称5', 'id' => 17, 'num' => 5],
    ];

    $res = \Yb98k\ybTools\core\ArrayHelper::arrayColumns($testArr, 'id', 'name,num');
    var_dump($res);
}

######################## arrayFormat 测试 ########################
function arrayFormatTest()
{
    $testArr = [
        ['name' => '名称1', 'id' => 3, 'num' => 4],
        ['name' => '名称2', 'id' => 30, 'num' => 2],
        ['name' => '名称3', 'id' => 16, 'num' => 3],
        ['name' => '名称4', 'id' => 10, 'num' => 1],
        ['name' => '名称5', 'id' => 17, 'num' => 5],
    ];

    $formatArr = [
        3 => ['desc' => '描述1'],
        30 => ['desc' => '描述2'],
        16 => ['desc' => '描述3'],
        10 => ['desc' => '描述4'],
        17 => ['desc' => '描述5'],
    ];

    \Yb98k\ybTools\core\ArrayHelper::arrayFormat($testArr, $formatArr, 'id', ['desc' => 'diyDesc']);
    var_dump($testArr);
}

######################## getValue 测试 ########################
function getValueTest()
{
    $testArr = ['name' => '名称1', 'id' => 3, 'num' => 4];

    $res = \Yb98k\ybTools\core\ArrayHelper::getValue($testArr, 'id', '10');
    var_dump($res);

    $res = \Yb98k\ybTools\core\ArrayHelper::getValue($testArr, 'notExistKey', 'it is not exist!');
    var_dump($res);
}

######################## getMultiValues 测试 ########################
function getMultiValuesTest()
{
    $testArr = [
        ['name' => '名称1', 'id' => 3, 'num' => 4],
        ['name' => '名称2', 'id' => 30, 'num' => 2],
        ['name' => '名称3', 'id' => 16, 'num' => 3],
        ['name' => '名称4', 'id' => 10, 'num' => 1],
        ['name' => '名称5', 'id' => 17, 'num' => 5],
    ];

    $res = \Yb98k\ybTools\core\ArrayHelper::getMultiValues($testArr, 'id,name');
    var_dump($res);
}

######################## getMultiValues 测试 ########################
function removeTest()
{
    $testArr = [
        ['name' => '名称1', 'id' => 3, 'num' => 4],
        ['name' => '名称2', 'id' => 30, 'num' => 2],
        ['name' => '名称3', 'id' => 16, 'num' => 3],
        ['name' => '名称4', 'id' => 10, 'num' => 1],
        ['name' => '名称5', 'id' => 17, 'num' => 5],
    ];

    $res = \Yb98k\ybTools\core\ArrayHelper::remove($testArr, 'num');
    var_dump($testArr);
    var_dump($res);
}


function main()
{
    $param = getopt('', ['method::']);
    if (isset($param['method'])) $param['method']();
}

main();
