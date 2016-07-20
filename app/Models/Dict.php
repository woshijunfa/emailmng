<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Auth;
use Session;
use Config;
use DB;
use Exception;
use Hash;
use Cookie;
use Log;

class Dict extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dicts';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $fillable = [
                            'id',
                            'key',
                            'value',
                            'created_at',
                            'updated_at',
                            ];
    
    //注册用户
    public static function getBegin($count)
    {
        DB::beginTransaction();        
        try 
        {
            $id = self::where('key','tieba_page')->value('id');
            if (empty($id)) return false;

            //行独占锁
            DB::statement("set innodb_lock_wait_timeout = 1");
            DB::Raw("select id from dicts where id = ? for update", [$id]);

            //获取数字
            $result = self::where("id",$id)->value('value');

            //添加数字
            self::where("id",$id)->increment('value',$count);

            DB::commit();

            return $result;
        }
        catch (Exception $e) 
        {
            DB::rollBack();
            return false;
        }

    }
}
