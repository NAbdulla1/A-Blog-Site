<?php

namespace Blog;

class Utils
{
    public static function contains($arr, $mem, $len): bool
    {
        for ($i = 0; $i < $len; $i++) {
            if ($arr[$i] == strtolower($mem)) return true;
        }
        return false;
    }

    public static function getParagraphs($largeText, $minParaSizeInChars = 500): array
    {
        $paras = [];
        $lines = explode(".", $largeText);
        $curPara = "";
        foreach ($lines as $line) {
            if (empty($line)) continue;
            $curPara = $curPara . $line . ".";
            if (strlen($curPara) >= $minParaSizeInChars) {
                array_push($paras, $curPara);
                $curPara = "";
            }
        }
        if (strlen($curPara) > 0)
            array_push($paras, $curPara);
        return $paras;
    }

    public static function filterInput($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function printPre($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function titleCase($title_text): string
    {
        return ucwords(strtolower($title_text));
    }

    public static function getMysqlDate($date, bool $lastMoment = false)
    {
        $date = explode('-', $date);
        if ($lastMoment)
            $time = mktime(23, 59, 59, $date[1], $date[2], $date[0]);
        else
            $time = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
        return date('Y-m-d H:i:s', $time);
    }

    public static function getTime($timestamp)//format of timestamp 2021-04-08 08:37:14
    {
        $date = explode(" ", $timestamp)[0];
        $time = explode(" ", $timestamp)[1];
        $date = explode("-", $date);
        $time = explode(":", $time);
        $full = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
        return $full;
    }

    public static function topLevelImage($img_path)
    {
        return substr($img_path, 3);
    }

    public static function getBaseUrl()
    {
        return "/Pasco%20blog%20template/site";
    }


}