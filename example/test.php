<?php
/**
 * Created by PhpStorm.
 * User: PFinal南丞
 * Email: Lampxiezi@163.com
 * Date: 2020/5/18
 * Time: 13:53
 */

require __DIR__.'/../vendor/autoload.php';

$ppapk = new \pf\wad\PPApk();
$ppapk->packerSingleApk(__DIR__.'/app-release.apk','123',"target.apk");

