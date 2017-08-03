<?php

class StringUtil {

    /*
     * 字符串拼接，传入两个参数 $title,$array
     * $title:字符串前缀（可为空）
     * $array:需要拼接的内容
     */
    public static function Mosaic($title,$array) {

        $til = $title ? $title.":\t" : $title;
        foreach($array as $hashkey => $value) {
            $str[] = $hashkey . "=" .$value;
        }
        $str = implode(',',$str);
        return $til.$str;
    }

    /**
     * check $haystack has string(strings) $needles or not, case-insensitive
     * diffrence from strpos is the second param could be a type of array.
     * return TRUE when any substring in $needles contained in haystack, 
     * otherwize, return FALSE
     * @param $haystack string: main string to check
     * @param $needles  string: substring 
     * @return Boolean
     */
    public static function icontains($haystack, $needles) 
    {
        if (is_array($needles)) 
        {
            if (empty($needles)) 
            {
                return FALSE;
            }

            foreach ($needles as $needle) 
            {
                if (stripos($haystack, $needle) !== FALSE)
                {
                    return TRUE;
                }
            }
        } 
        else 
        {
            return stripos($haystack, $needles) !== FALSE;
        }

        return FALSE;
    }

}