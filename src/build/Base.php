<?php
/**
 * Created by PhpStorm.
 * User: PFinal南丞
 * Email: Lampxiezi@163.com
 * Date: 2020/5/18
 * Time: 13:41
 */

namespace pf\wad\build;

class Base
{
    private $zipStream;

    public function __construct()
    {
        $this->zipStream = new ZipStream();
    }

    public function packerSingleApk($apkFile, $channelName, $output = '')
    {
        if (!file_exists($apkFile)) {
            throw new ApkPackerException('apk file not found');
        }
        if (empty($channelName)) {
            throw new ApkPackerException('channel name is require');
        }

        $apkFileHandle = fopen($apkFile, 'rb');
        if ($apkFileHandle == false) {
            throw new ApkPackerException('failed to open the apk file');
        }

        $apkFileInfo = fstat($apkFileHandle);
        var_dump($apkFileInfo);
        $apkFileSize = isset($apkFileInfo['size']) ? $apkFileInfo['size'] : 0;
        if ($apkFileSize == 0) {
            throw new ApkPackerException('apk file size error');
        }

        if ($output) {
            if (file_exists($output)) {
                throw new ApkPackerException('apk file is already exists');
            }

            //create new apk file
            $newApkFile = fopen($output, 'wb');
            if ($newApkFile == false) {
                throw new ApkPackerException('failed to create new apk file');
            }

            if (copy($apkFile, $output)) {
                if ($this->_setApkComment($output, $channelName) == false) {
                    throw new ApkPackerException('failed to write comment');
                }
            } else {
                throw new ApkPackerException('failed to copy apk file');
            }
        } else {
            if ($this->_setApkComment($apkFile, $channelName) == false) {
                throw new ApkPackerException('failed to write comment');
            }
        }

        return true;
    }

    private function _setApkComment($apkFile, $comment)
    {
        $this->zipStream->open($apkFile);

        return $this->zipStream->setZipComment($comment);
    }
}