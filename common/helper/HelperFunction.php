<?php

namespace common\helper;
use yii\db\ActiveQuery;

class HelperFunction
{
    public static function getFirstErrorModel($model)
    {
        $message = '';
        foreach ($model->getFirstErrors() as $er) {
            $message = $er;
            break;
        }
        return $message;
    }

    /**
     * Convert vi to slug
     * @param $str
     * @return null|string|string[]
     */
    public static function convert_vi_to_en($str)
    {
        $str = trim($str);
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace(" ", '-', $str);
        return $str;
    }

    /**
     * Log error về folder log
     * @param $message
     */
    public static function error_log($message)
    {
        $message = "[" . date("d-m-Y H:i:s") . "]$message" . "\n";
        $log_path = LOG_PATH . DIRECTORY_SEPARATOR . \Yii::$app->name . date("dmY") . ".log";

        if (!file_exists($log_path)) {
            $fh = fopen($log_path, 'w');
            fclose($fh);
        }

        error_log($message, 3, $log_path);
    }

    /**
     * Random trong khoảng length ký tự a-z0-9
     * @param int $random_string_length
     * @return string
     */

    public static function randomString($random_string_length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $random_string_length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }

    /**
     * Return query list về dạng next back rows
     *
     * @param ActiveQuery $query
     * @param int $page
     * @param int $limit
     * @return array
     */
    static function format($price, $d = 0)
    {
        return number_format($price, $d, ',', '.') . 'đ';
    }

    public static function executeList($query, $page = 0, $limit = 20)
    {

        $data = [
            'next' => true,
            'back' => true,
            'rows' => [],
            'page' => $page,
            'limit' => $limit
        ];
        if (!$page || $page <= 0) {
            $page = 1;
        }

        $query->limit($limit + 1);
        $query->offset(($page - 1) * $limit);

        $data['rows'] = $query->asArray(true)->all();
        $rowCount = count($data['rows']);

        if ($page >= 1) {
            $data['back'] = false;
        }

        if ($rowCount < $limit) {
            $data['next'] = false;
        }

        return $data;
    }

    static function printf($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit();
    }

}