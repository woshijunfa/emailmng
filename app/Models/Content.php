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

class Content extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $fillable = [
                            'id',
                            'title',
                            'm_content',
                            'h_content',
                            'created_at',
                            'updated_at',
                            'is_valid'
                            ];

    //注册用户
    public static function insertContent($id,$content)
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
    

}
