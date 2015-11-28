<?
class IoScrutineering{

/* 
处理原理：将要输出字符中的HTML字符全部转义
使用方法：使用该函数代替eaho
 */
public static function SafeOutput($str)
{echo htmlspecialchars(nl2br($str), ENT_QUOTES);}

/* 
处理原理：通过检查SERVER_NAME属性值检测该请求是否跨站
使用方法：调用该函数，返回布尔值
 */
public static function ScrutineeringSource()
{
    if(isset($_SERVER["HTTP_REFERER"]))
    {
        $serverhost = $_SERVER["SERVER_NAME"];
        $strurl = str_replace("http://","",$_SERVER["HTTP_REFERER"]);  
        $strdomain = explode("/",$strurl);           
        $sourcehost = $strdomain[0];              
        if(strncmp($sourcehost, $serverhost, strlen($serverhost)))
        {return false;}//疑似跨站伪造请求
        return true;
    }
}

}