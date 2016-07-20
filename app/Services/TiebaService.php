<?php

namespace App\Services;
use Log;
use App\Models\Dict;

class TiebaService
{
	//配置内容区域
	var $care_content_reg = "/([a-z0-9\-_\.]+@[a-z0-9]+\.com)/";
  	var $page = 0;
	var $depth = 20; 		//最大循环次数 
	var $contentList = [];


    public function setPage()
    {
    	$this->page = $page;
    }

	public function run()
	{
		$this->page = Dict::getBegin($this->depth);
		if ($this->page === false) 
		{
			var_dump("get start page failed!");
			Log::info("get start page failed!");
			return false;
		}

		for($i=0;$i<$this->depth;$i++) 
		{
			$this->scanfTopic($this->page);
			$this->page++;
		}
	}


	function scanfTopic($topic)
	{
		if (empty($topic)) return false;


		$pageurl = "http://tieba.baidu.com/p/$topic";

		while (is_string($pageurl) && strlen($pageurl) > 1) 
		{
			//获取内容
			// $content = file_get_contents($pageurl);
			$content = CommonService::curlRequest($pageurl);
			var_dump("scanf page url:" . $pageurl);
			//获取感兴趣的内容
			preg_match_all($this->care_content_reg, $content, $matches);
			if (!empty($matches)) $matches =  array_unique($matches[0]);

			//添加邮箱
			$this->addContents($matches);	

			//获取下一页面的链接
			$pageurl = $this->getNextPageUrl($content);
		}
	}

	function getNextPageUrl($content)
	{
		if (empty($content)) return false;

		$reg = "/<a\shref=[^>]+>下一页/";
		// $reg ="/([a-z0-9\-_\.]+@[a-z0-9]+\.com)/";

		preg_match($reg,$content,$matches);
		if (empty($matches)) return false;
		$url = $matches[0];

		$beginpos = stripos($url,'"');
		$endpos = strripos($url,'"');

		$url = substr($url,$beginpos+1,$endpos-$beginpos-1);


		return 'http://tieba.baidu.com'.$url;
	}


	function addContents($contents)
	{
		if (empty($contents)) return false;
		foreach ($contents as $value) $this->addContent($value);
	}

	function addContent($content)
	{
		if (empty($content)) return;
		$key = md5($content);
		if (isset($this->contentList[$key])) return;

		Log::info("添加内容：" . $content);
		$this->contentList[$key] = $content;
	}


}

