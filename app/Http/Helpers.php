<?php 

namespace App\Http;

use Mail;
use Config;
use App\Models\Category;
use Illuminate\Support\Str;

class Helpers{
	
	public static function getBrowserName($user_http){
		$t = strtolower($user_http);
        $t = " " . $t;
        if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
        elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
        elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
        elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
        elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
        elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
        return 'Unkown';
	}

    public static function UploadImage($image, $path){
        $imageName = Str::random().'.'.$image->getClientOriginalExtension();
        $path = $image->move($path, $imageName);
        if($path == true){
            return $imageName;
        }else{
            return null;
        }
    }

}