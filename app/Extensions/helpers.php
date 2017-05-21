<?php
if (!function_exists('array_multi_column')) {
    function array_multi_column($array, $columns)
    {
        $new_array = [];
        foreach ($array as $val) {
            $new_array[] = array_only($val, $columns);
        }
        return $new_array;
    }
}
/**
 * @uses 根据生日计算年龄，年龄的格式是：2016-09-23
 * @param string $birthday 格式'yyyy-mm-dd H:i:s'
 * @return string|number
 */
if (!function_exists('calcAge')) {
    function calcAge($birthday)
    {
        $iage = 0;
        if (!empty($birthday)) {
            $year = date('Y', strtotime($birthday));
            $month = date('m', strtotime($birthday));
            $day = date('d', strtotime($birthday));

            $now_year = date('Y');
            $now_month = date('m');
            $now_day = date('d');

            if ($now_year > $year) {
                $iage = $now_year - $year - 1;
                if ($now_month > $month) {
                    $iage++;
                } else if ($now_month == $month) {
                    if ($now_day >= $day) {
                        $iage++;
                    }
                }
            }
        }
        return $iage;
    }
}
/**
 * 根据日期获取星座
 */
if (!function_exists('calcAge')) {
    function getConstellation($date)
    {
        $month = date('m', strtotime($date));
        $day = date('d', strtotime($date));
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31) return false;
        $signs = array(
            array('20' => '水瓶座'),
            array('19' => '双鱼座'),
            array('21' => '白羊座'),
            array('20' => '金牛座'),
            array('21' => '双子座'),
            array('22' => '巨蟹座'),
            array('23' => '狮子座'),
            array('23' => '处女座'),
            array('23' => '天秤座'),
            array('24' => '天蝎座'),
            array('22' => '射手座'),
            array('22' => '摩羯座')
        );
        list($start, $name) = each($signs[$month - 1]);
        if ($day < $start)
            list($start, $name) = each($signs[($month - 2 < 0) ? 11 : $month - 2]);
        return $name;
    }
}
/**
 * 根据图片ＩＤ与宽度获取图片地址
 */
if (!function_exists('getImageUrl')) {
    function getImageUrl($id, $width)
    {
        return env("IMAGE_LOCATION_PREFIX") . $id . '/' . $width;
    }
}
/** 毫秒转换为秒 */
if (!function_exists('microtime_to_time')) {
    function microtime_to_time($time)
    {
        return intval(substr($time, 0, 10));
    }
}
/** 秒转换为毫秒 */
if (!function_exists('time_to_microtime')) {
    function time_to_microtime($time)
    {
        return $time * 1000;
    }
}


/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
if (!function_exists('generate_password')) {
    function generate_password($length = 8)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@';
        $chars = 'abcdefghjkmnprstuvwxyACDEFGHJKLMNPQRSTUVWXYZ34567@';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $password;
    }
}


if (!function_exists('getfirstchar')) {
    function getfirstchar($s0)
    {
        $firstchar_ord = ord(strtoupper($s0{0}));
        if (($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57)) return $s0{0};
        $s = iconv("UTF-8", "gb2312", $s0);
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 and $asc <= -20284) return "A";
        if ($asc >= -20283 and $asc <= -19776) return "B";
        if ($asc >= -19775 and $asc <= -19219) return "C";
        if ($asc >= -19218 and $asc <= -18711) return "D";
        if ($asc >= -18710 and $asc <= -18527) return "E";
        if ($asc >= -18526 and $asc <= -18240) return "F";
        if ($asc >= -18239 and $asc <= -17923) return "G";
        if ($asc >= -17922 and $asc <= -17418) return "H";
        if ($asc >= -17417 and $asc <= -16475) return "J";
        if ($asc >= -16474 and $asc <= -16213) return "K";
        if ($asc >= -16212 and $asc <= -15641) return "L";
        if ($asc >= -15640 and $asc <= -15166) return "M";
        if ($asc >= -15165 and $asc <= -14923) return "N";
        if ($asc >= -14922 and $asc <= -14915) return "O";
        if ($asc >= -14914 and $asc <= -14631) return "P";
        if ($asc >= -14630 and $asc <= -14150) return "Q";
        if ($asc >= -14149 and $asc <= -14091) return "R";
        if ($asc >= -14090 and $asc <= -13319) return "S";
        if ($asc >= -13318 and $asc <= -12839) return "T";
        if ($asc >= -12838 and $asc <= -12557) return "W";
        if ($asc >= -12556 and $asc <= -11848) return "X";
        if ($asc >= -11847 and $asc <= -11056) return "Y";
        if ($asc >= -11055 and $asc <= -10247) return "Z";
        return null;
    }
}

if (!function_exists('password_strength')) {
    function password_strength($password)
    {
        $score = 0;
        if (preg_match("/[0-9]+/", $password)) {
            $score++;
        }
        if (preg_match("/[0-9]{3,}/", $password)) {
            $score++;
        }
        if (preg_match("/[a-z]+/", $password)) {
            $score++;
        }
        if (preg_match("/[a-z]{3,}/", $password)) {
            $score++;
        }
        if (preg_match("/[A-Z]+/", $password)) {
            $score++;
        }
        if (preg_match("/[A-Z]{3,}/", $password)) {
            $score++;
        }
        if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $password)) {
            $score += 2;
        }
        if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/", $password)) {
            $score++;
        }
        if (strlen($password) >= 10) {
            $score++;
        }
        return $score;
    }
}
/**
 * 账号安全等级检测
 * 1、纯数字或字母 低 1
 * 2、字母+数字组合 中 2
 * 3、含有特殊字符 高 3
 */
if (!function_exists('security_level_check')) {
    function security_level_check($password)
    {
        $score = 0;
        if (preg_match("/^[0-9]+$/", $password)) {
            $score++;
        } elseif (preg_match("/^[a-zA-Z]+$/", $password)) {
            $score++;
        } elseif (preg_match("/^[0-9a-zA-Z]+$/", $password)) {
            $score += 2;
        } elseif (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $password)) {
            $score += 3;
        }

        return $score;
    }
}
/**
 * 金额格式化处理 保留2位小数
 */
if (!function_exists('money_double_2')) {
    function money_double_2($amount)
    {
        return number_format(doubleval($amount), 2);
    }
}