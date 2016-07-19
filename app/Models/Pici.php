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

class Pici extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pici';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $fillable = [
                            'id',
                            'pici',
                            'created_at',
                            'updated_at',
                            ];
    
    //注册用户
    public static function insertPici($content)
    {
        if (empty($content)) return false;

        try 
        {
                $result = self::insert($content);

            return $result ? true : false;
        } catch (\Exception $e) 
        {
            return false;
        }

        return false;
    }
}
