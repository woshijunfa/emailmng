<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 3/15/16
 * Time: 16:34
 */

namespace App\Services;
use Log;
use Config;
use View;
use App\Models\Email;
use App\Models\PiciLog;

class EmailSerivce
{

    /**
     * 发送邮件
     * @param $title 标题
     * @param $content 内容
     * @param array $receiver 接收人 array('receiver@domain.org', 'other@domain.org' => 'A name')
     * @return int
     */
    public static function sendEmail($title , $content , $receiver)
    {
        try 
        {
            //邮箱配置相关获取
            $mailHost = Config::get('mail.host');
            $mailport = Config::get('mail.port');
            $mailEncryption = Config::get('mail.encryption');
            $userName = Config::get('mail.username');
            $password = Config::get('mail.password');

            //port实例化
            $transport = \Swift_SmtpTransport::newInstance($mailHost, $mailport, $mailEncryption);
            $transport->setUsername($userName);
            $transport->setPassword($password);

            //邮件对象实例化
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance();
            $message->setFrom([$userName => 'ShareApi']);
            $message->setTo($receiver);
            $message->setSubject($title);
            $message->setBody($content, 'text/html', 'utf-8');
            $r = $mailer->send($message);
            return true;
        }
        catch (\Exception $e) 
        {
            Log::info("EmailSerivce::sendEmail 发生异常失败");
            Log::info($e);
            return false;
        }
    }

    //发送末班邮件
    public static function sendBladeEmail($emails,$title,$blade,$data=[])
    {
        $content = View::make($blade,$data)->render();
        return self::sendEmail($title,$content,$emails);
    }

    //发送异常报警邮件
    public static function sendExceptionMail($e)
    {
        try 
        {
            if (empty($e)) return false;

            $request = app()->request;

            $infoList = [];
            $infoList['date'] = date("Y-m-d H:i:s");
            if (!empty($request))   $infoList['url'] =  $request->fullUrl();
            $infoList['error_code'] = $e->getCode();
            $infoList['error_message'] = $e->getMessage();
            $infoList['error file'] = "{$e->getFile()} at line {$e->getLine()}";
            $infoList['error trac'] = $e->getTraceAsString();
            $infoList['server'] = $_SERVER;
            $infoList['post'] = $_POST;
            $infoList['get'] = $_GET;

            //邮件title
            $title = "电销平台 code: {$e->getCode()} message: {$e->getMessage()}";

            $content = "<div style='border-bottom:2px solid #999'><p style='color:#E6E0E0;background:red;'>  ".
              $title."<p>"."<pre>".str_replace(["\n", " "], ["<br>", "&nbsp;"],var_export($infoList, true))."</pre></div>";  

            self::sendEmail($title,$content);

        } 
        catch (\Exception $e) 
        {
            Log::info("EmailSerivce::sendExceptionMail 发生异常失败");
            Log::info($e);
        }
    }

    //导入email
    static public function  insertMail($content,$tag='')
    {
        //获取其中的email
        $emails = gGetEmail($content);
        if (empty($emails)) return false;

        foreach ($emails as $email) 
        {
            Email::insertMail($email,$tag);
        }

        return true;
    }

    //发送批次邮件
    static public function sendPiciEmail($logInfo)
    {
        //已经发送完成则不再发送
        if (!empty($logInfo->end_time) && $logInfo->end_time >= $logInfo->send_time) return true;



        //循环发送邮件
        $perCount = 10;
        while (true) 
        {
            $uuid =  CommonService::getuuid();
            $sendTime = date("Y-m-d H:i:s");
            $updateInfo = [
                'last_send_time' => $sendTime,
                'uuid' => $uuid
            ];

            //标记发送时间和uuid
            $count = Email::where('pici',$logInfo->pici)
                            ->where('is_valid',1)
                            ->where('last_send_time','<',$logInfo->send_time)
                            ->take($perCount)
                            ->update($updateInfo);
            var_dump("update fetch email count:$count");
            //发送完成
            if ($count <= 0)
            {
                $logInfo->sendOk();
                return true;
            } 

            //循环发送
            $emails = Email::where('pici',$logInfo->pici)
                        ->where('last_send_time',$sendTime)
                        ->where('uuid',$uuid)
                        ->get();

            self::sendEmailsOfContent($emails,$logInfo);
        }

    }

    static public function sendEmailsOfContent($emails,$logInfo)
    {
        if(empty($emails) || empty($logInfo)) return false;

        $title = $logInfo->title;
        $content = CommonService::renderContent($logInfo->content_id);

        $successCount = 0;
        foreach($emails as $email)
        {
            $isSuccess = self::sendEmail($title,$content,[$email->email => $email->email]);
            Log::info("发送邮件 ". $email->email . ":$title 批次：" . $logInfo->id . " success:" . $isSuccess);
            var_dump("发送邮件 ". $email->email . ":$title 批次：" . $logInfo->id . " success:" . $isSuccess);
            if($isSuccess)  $successCount++ ;
        }

        //更新成功和失败数量
        PiciLog::where('id',$logInfo->id)->increment('success_count',$successCount);
    }
}












