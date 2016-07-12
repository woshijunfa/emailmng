<?php

if (! function_exists('gIsEmail')) 
{
	function gIsEmail($email)
	{
		$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		return preg_match($pattern,$email);
	}

    function gGetEmailType($email)
    {
        if (!is_string($email)) return '';

        $type = NULL;
        for($i=0;$i<strlen($email);$i++)
        {
            $value = $email[$i];
            if($type === NULL)
            {
                if ($value == '@') $type='';
            }
            else if ($type !== NULL)
            {
                if($value != '.') $type .= $value;
                else break;
            }
        }

        return empty($type) ? '' : $type;
    }

    function gGetEmail($str) 
    {                 
        if (empty($str)) return [];

        //匹配邮箱内容
        $pattern = "/([a-z0-9\-_\.]+@[a-z0-9]+\.[a-z0-9\-_\.]+)/"; 
        preg_match_all($pattern,$str,$emailArr); 
        return $emailArr[0]; 
    }

    //php生成GUID
    function gGuid()
    {
        return md5(uniqid(mt_rand(), true));
    }

    //时间长度转换
    function gFormatSecond($seconds)
    {
    	if (empty($seconds)) return '0秒';
    	if ($seconds < 60) return $seconds . "秒";
    	if ($seconds < 3600) return floor($seconds/60) . '分' . $seconds%60 . '秒';

    	return floor($seconds/3600) . '小时' . floor(($seconds%3600)/60) . '分' . $seconds%60 . '秒';
    }

    //字节大小转换
    function gFormatSize($size)
    {
    	if (empty($size)) return '0Bytes';
    	if ($size < 1024*1024) return round($size/1024,2) . "KB";
    	if ($size < 1024*1024*1024) return round($size/(1024*1024),2) . "MB";

    	return round($size/(1024*1024*1024),2) . "GB";
    }
}

