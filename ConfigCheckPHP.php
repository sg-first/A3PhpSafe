<?
require_once dirname(__FILE__).'/CheckPHP.php';

CheckPHP::$PathMode=false;//默认为使用相对路径标示php文件
//向列表中添加所有可信的php路径（网站中用到的任何）
CheckPHP::AddPHP("ConfigCheckPHP.php");

//检查的方法是：CheckPHP::Check();