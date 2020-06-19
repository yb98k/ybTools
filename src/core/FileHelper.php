<?php


namespace Yb98k\ybTools\core;

/**
 * Class FileHelper
 * @package Yb98k\ybTools\core
 * @author <ykabps1314@gamil.com>
 */
class FileHelper
{
    /**
     * 下载文件
     * @param $filename
     */
    public static function download($filename)
    {
        php_sapi_name() != 'cli' or die('Cannot be executed in cli mode!');

        if (file_exists($filename)){
            header('Content-length: ' . filesize($filename));
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile($filename);
        } else {
            die('File does not exist!');
        }
    }

    /**
     * 保存成为zip文件
     *
     * for example:
     *
     * $filenameArray = [
     *      __DIR__ . '/ArrayHelper.php',
     *      __DIR__ . '/FileHelper.php',
     * ];
     *
     * try {
     *      \Yb98k\ybTools\core\FileHelper::outZip($filenameArray, 'ybCore.zip');
     * } catch (Exception $ex) {
     *      var_dump($ex->getMessage());
     * }
     *
     * @param $filenameArray
     * @param $zipName
     * @param $delete --- 当为true的时候将在导出zip的同时删除原各个文件
     * @throws \Exception
     */
    public static function outZip($filenameArray, $zipName, $delete = false)
    {
        if (!extension_loaded('zip')) {
            throw new \Exception('zip extension is not exist!');
        }

        try {
            // 防止使用人没有传后缀zip
            $zipName = strpos($zipName, '.zip') === false ? $zipName . '.zip' : $zipName;

            $zip = new \ZipArchive();
            $zip->open($zipName, \ZipArchive::CREATE);

            // 向压缩包中添加文件
            foreach ($filenameArray as $filename) {
                if (!file_exists($filename)) continue;
                // 添加文件进压缩包
                $zip->addFile($filename, basename($filename));
                // 如果选择了删除源文件则进行删除
                if ($delete === true) unlink($filename);
            }
            $zip->close();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}