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

class PiciLog extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pici_log';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $fillable = [
                            'id',
                            'pici',
                            'send_time',
                            'end_time',
                            'total_count',
                            'success_count',
                            'created_at',
                            'updated_at',
                            'title',
                            'status'
                            ];

    //注册用户
    public static function insertLog($id,$content)
    {
        if (empty($content)) return false;

        try 
        {
            if ($id) 
            {
                $result = self::where('id',$id)->update($content);
            }
            else
            {
                $result = self::insert($content);
            }

            return $result ? true : false;
        } catch (\Exception $e) 
        {
            return false;
        }

        return false;
    }    
    
    public function getStatus()
    {
        $list = [];
        $list['init'] = "未发送";
        $list['sending'] = "发送中";
        $list['end'] = "发送完成";

        return !empty($list[$this->status]) ? $list[$this->status] : '未知';
    }
}
