<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Auth;
use Session;
use Config;
use DB;
use Hash;
use Cookie;
use Log;

class Email extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $fillable = [
                            'id',
                            'email',
                            'type',
                            'last_send_time',
                            'created_at',
                            'updated_at',
                            'tag',
                            'ip',
                            'is_valid',
                            'pici'
                            ];

    //注册用户
    public static function insertMail($email,$tag='')
    {
        if (empty($email)) return false;

        //判断是否是email
        if (!gIsEmail($email)) 
        {
            Log::info("insertemail_failed:$email is not email skip");
            return false;
        }

        $emailInfo = [];
        $emailInfo['email'] = $email;
        $emailInfo['type'] = gGetEmailType($email);
        $emailInfo['tag'] = empty($tag) ? '' : $tag;

        try 
        {
            
            $result = self::insert($emailInfo);
            Log::info("insertemail_ok: $email type:" . $emailInfo['type'] . ' tag:' . $tag);

            return $result ? true : false;
        } catch (\Exception $e) 
        {
            Log::info("insertemail_failed: $email  exception_message:" . $e->getMessage());
            return false;
        }

        return false;
    }    
    

}
