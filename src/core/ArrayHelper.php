<?php


namespace Yb98k\ybTools\core;

use TestParam;

/**
 * Class ArrayHelper
 * @package Yb98k\ybTools\core
 * @author <ykabps1314@gamil.com>
 */
class ArrayHelper
{
    /** @var array 排序方向转化 */
    const SORT_FLAGS = [
        'asc' => SORT_ASC,
        'desc' => SORT_DESC,
    ];

    /**
     * 将类、数组类或者类数组转化成纯数组
     * class TestParam {
     *
     *      public $id = 0;
     *
     *      public $name = '测试1';
     *
     *      public $desc = '描述1';

     *      public $params = [
     *          'A' => 'xxxA',
     *          'B' => 'xxxB',
     *      ];
     * }
     *
     * $res = \Yb98k\ybTools\core\ArrayHelper::toArray(new TestParam());
     * ////// out $res //////:
     *
     * [
     *      'id' => 0,
     *      'name' => '测试1',
     *      'desc' => '描述1',
     *      'params' => [
     *          'A' => 'xxxA',
     *          'B' => 'xxxB'
     *      ]
     * ]
     *
     * @param $object
     * @return mixed
     */
    public static function toArray($object)
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * 获取数组相应key的值，做了存在校验并可以给予默认值
     *
     * for example:
     *
     * $demoArr = ['name' => '名称1', 'id' => 3, 'num' => 4];
     *
     * $res = \Yb98k\ybTools\core\ArrayHelper::getValue($demoArr, 'id');
     * ////// out $res //////: 3
     *
     *
     * $res = \Yb98k\ybTools\core\ArrayHelper::getValue($demoArr, 'notExistKey', 'it is not exist!');
     * ////// out $res //////: it is not exist!
     *
     * @param $array
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public static function getValue(Array $array, $key, $default  = '')
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * 获取一维二维数组相应keys的值并组成新的数组返回，做了key存在校验并给予默认值
     *
     * for example:
     *
     * $demoArr = [
     *      ['name' => '名称1', 'id' => 3, 'num' => 4],
     *      ['name' => '名称2', 'id' => 30, 'num' => 2],
     *      ['name' => '名称3', 'id' => 16, 'num' => 3],
     *      ['name' => '名称4', 'id' => 10, 'num' => 1],
     *      ['name' => '名称5', 'id' => 17, 'num' => 5],
     * ];
     *
     * $res = \Yb98k\ybTools\core\ArrayHelper::getMultiValues($demoArr, 'id,name');
     * ////// out $res //////:
     * [
     *      ['name' => '名称1', 'id' => 3],
     *      ['name' => '名称2', 'id' => 30],
     *      ['name' => '名称3', 'id' => 16],
     *      ['name' => '名称4', 'id' => 10],
     *      ['name' => '名称5', 'id' => 17],
     * ]
     *
     * @param $array
     * @param $keys --- example: 'id,name,desc'
     * @return mixed|string
     */
    public static function getMultiValues(Array $array, $keys)
    {
        if (!$keys) return $array;
        $keyArr = explode(',', str_replace(' ', '', trim($keys, ',')));

        // 返回的结果数组
        $returnArr = [];

        // 如果是一维数组则直接获取
        if (count($array, 1) == count($array)) {
            foreach ($keyArr as $key) {
                $returnArr[$key] = static::getValue($array, $key);
            }
        } else {
            // 适用于二维数组
            array_map(function ($item) use (&$returnArr, $keyArr) {
                $tempArr = [];
                foreach ($keyArr as $key) {
                    $tempArr[$key] = static::getValue($item, $key);
                }
                $returnArr[] = $tempArr;
            }, $array);
        }

        return $returnArr;
    }

    /**
     * 移除一维/二维数组中的某个key并返回所有删除的值
     *
     * for example:
     *
     * $demoArr = [
     *      3 => ['name' => '名称1', 'id' => 3, 'num' => 4],
     *      30 => ['name' => '名称2', 'id' => 30, 'num' => 2],
     *      16 => ['name' => '名称3', 'id' => 16, 'num' => 3],
     *      10 => ['name' => '名称4', 'id' => 10, 'num' => 1],
     *      17 => ['name' => '名称5', 'id' => 17, 'num' => 5],
     * ];
     *
     * $res = \Yb98k\ybTools\core\ArrayHelper::remove($demoArr, 'num');
     * ////// out $demoArr //////:
     * [
     *      3 => ['name' => '名称1', 'id' => 3],
     *      30 => ['name' => '名称2', 'id' => 30],
     *      16 => ['name' => '名称3', 'id' => 16],
     *      10 => ['name' => '名称4', 'id' => 10],
     *      17 => ['name' => '名称5', 'id' => 17],
     * ];
     *
     * ////// out $res //////:
     * [
     *      3 => 4,
     *      30 => 2,
     *      16 => 3,
     *      10 => 1,
     *      17 => 5,
     * ];
     *
     * @param array $array
     * @param $rmKey
     * @param null $default
     * @return array|mixed|null
     */
    public static function remove(Array &$array, $rmKey, $default = null)
    {
        if (count($array, 1) == count($array)) {
            if (isset($array[$rmKey])) {
                $value = $array[$rmKey];
                unset($array[$rmKey]);

                return $value;
            }

            return $default;
        } else {
            $unsetValues = [];
            foreach ($array as $key => &$item) {
                if (isset($item[$rmKey])) {
                    $unsetValues[$key] = $item[$rmKey];
                    unset($item[$rmKey]);
                }
            } unset($item);

            return $unsetValues;
        }
    }

    /**
     * 二维数组排序
     *
     * for example:
     *
     * $demoArr = [
     *      ['name' => '名称1', 'id' => 3, 'num' => 4],
     *      ['name' => '名称2', 'id' => 30, 'num' => 2],
     *      ['name' => '名称3', 'id' => 16, 'num' => 3],
     *      ['name' => '名称4', 'id' => 10, 'num' => 1],
     *      ['name' => '名称5', 'id' => 17, 'num' => 5],
     * ];
     *
     * \Yb98k\ybTools\core\ArrayHelper::arraySort($demoArr, 'id desc,num desc');
     *  ////// out $demoArr //////:
     * [
     *      ['name' => '名称2', 'id' => 30, 'num' => 2],
     *      ['name' => '名称5', 'id' => 17, 'num' => 5],
     *      ['name' => '名称3', 'id' => 16, 'num' => 3],
     *      ['name' => '名称4', 'id' => 10, 'num' => 1],
     *      ['name' => '名称1', 'id' => 3, 'num' => 4],
     * ];
     *
     *
     * @param array $data
     * @param null $arg 类似mysql语句的排序 比如 'id desc,num asc'
     */
    public static function arraySort(Array &$data, $arg = null)
    {
        $sortArgs = [];
        if ($arg) {
            $sortFlagArr = explode(',', trim($arg, ','));

            foreach ($sortFlagArr as $item) {
                $tempStr = trim($item, ' ');
                if (strpos($tempStr, ' ') === false) continue;

                $tempArr = explode(' ', $tempStr);
                if (count($tempArr) < 2) continue;

                $sortArgs[] = array_column($data, $tempArr[0]) ?: [];
                $sortArgs[] = empty(self::SORT_FLAGS[strtolower($tempArr[1])])
                    ? SORT_ASC : self::SORT_FLAGS[strtolower($tempArr[1])];
            }
        }

        if ($sortArgs) {
            // 因为array_multisort对是数组的引用排序，所以call_user_func_array传参会copy一份传递，此时必须引用传递
            $sortArgs[] = &$data;
            call_user_func_array('array_multisort', $sortArgs);
        }
    }

    /**
     * 二维数组索引转换
     *
     * for example:
     *
     * $demoArr = [
     *      ['name' => '名称1', 'id' => 3, 'num' => 4],
     *      ['name' => '名称2', 'id' => 30, 'num' => 2],
     *      ['name' => '名称3', 'id' => 16, 'num' => 3],
     *      ['name' => '名称4', 'id' => 10, 'num' => 1],
     *      ['name' => '名称5', 'id' => 17, 'num' => 5],
     * ];
     *
     * $res = \Yb98k\ybTools\core\ArrayHelper::arrayColumns($testArr, 'id', 'name,num');
     * ////// out $res //////:
     *
     * [
     *      3 => ['name' => '名称1', 'num' => 4],
     *      30 => ['name' => '名称2', 'num' => 2],
     *      16 => ['name' => '名称3', 'num' => 3],
     *      10 => ['name' => '名称4', 'num' => 1],
     *      17 => ['name' => '名称5', 'num' => 5],
     * ];
     *
     * @param $data
     * @param $index
     * @param null $arg
     * @return array
     */
    public static function arrayColumns(Array $data, $index, $arg = null)
    {
        if (empty($index)) return $data;

        $argArr = $arg ? explode(',', str_replace(' ', '', trim($arg, ','))) : [];
        array_map(function ($item) use (&$retData, $index, $argArr) {
            if (isset($item[$index])) {
                // 根据需要获取的二维key进行数组重组
                $tempArr = [];
                foreach ($argArr as $key) {
                    if (isset($item[$key])) {
                        $tempArr[$key] = $item[$key];
                    }
                }

                $retData[$item[$index]]  = $tempArr ?: $item;
            } else {
                $retData[] = $item;
            }
        }, $data);

        return $retData;
    }

    /**
     * 关联数组使用关联字段进行原数组格式化
     *
     * for example:
     *
     * $demoArr = [
     *      ['name' => '名称1', 'id' => 3, 'num' => 4],
     *      ['name' => '名称2', 'id' => 30, 'num' => 2],
     *      ['name' => '名称3', 'id' => 16, 'num' => 3],
     *      ['name' => '名称4', 'id' => 10, 'num' => 1],
     *      ['name' => '名称5', 'id' => 17, 'num' => 5],
     * ];
     *
     * $formatArr = [
     *      3 => ['desc' => '描述1'],
     *      30 => ['desc' => '描述2'],
     *      16 => ['desc' => '描述3'],
     *      10 => ['desc' => '描述4'],
     *      17 => ['desc' => '描述5'],
     * ];
     *
     * \Yb98k\ybTools\core\ArrayHelper::arrayFormat($demoArr, $formatArr, 'id', ['desc' => 'diyDesc']);
     * ////// out $demoArr //////:
     * $demoArr = [
     *      ['name' => '名称1', 'id' => 3, 'num' => 4, 'diyDesc' => '描述1'],
     *      ['name' => '名称2', 'id' => 30, 'num' => 2, 'diyDesc' => '描述2'],
     *      ['name' => '名称3', 'id' => 16, 'num' => 3, 'diyDesc' => '描述3'],
     *      ['name' => '名称4', 'id' => 10, 'num' => 1, 'diyDesc' => '描述4'],
     *      ['name' => '名称5', 'id' => 17, 'num' => 5, 'diyDesc' => '描述5'],
     * ];
     *
     * @param array $array
     * @param array $formatArr
     * @param $contactKey --- 此key为$array的二维字段，同时作为$formatArr的索引
     * @param $contactParamName --- key为$formatArr的二维key，value则为$array的需要转化的key
     */
    public static function arrayFormat(Array &$array, Array $formatArr, $contactKey, Array $contactParamName = null)
    {
        $contactParamName = $contactParamName ? array_unique($contactParamName) : [];
        $array = array_map(function ($item) use ($formatArr, $contactKey, $contactParamName) {
            if ($contactParamName) {
                foreach ($contactParamName as $formatKey => $param) {
                    // 当关联对应键名的格式化数据数组使用_yb关键词则表明$formatArr为一维数组
                    if ($formatKey == '_yb') {
                        $item[$param] = empty($formatArr[$item[$contactKey]])
                            ? null : $formatArr[$item[$contactKey]];
                    } else {
                        $item[$param] = empty($formatArr[$item[$contactKey]][$formatKey])
                            ? null : $formatArr[$item[$contactKey]][$formatKey];
                    }
                }
            } else {
                // 如果没指定原数组和用来格式化数据的数组之间的对应键名 则使用啥变量名则使用
                $item['_ybParam'] = empty($formatArr[$item[$contactKey]]) ? null : $formatArr[$item[$contactKey]];
            }

            return $item;
        }, $array);
    }
}