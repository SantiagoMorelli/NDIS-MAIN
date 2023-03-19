<?php

namespace App\Services;

use Carbon\Carbon;

class Common
{
    /**
     * Datetime Client TZ to UTC
     */
    public static function dateClientTZToUTC($format, $datetime, $client_timezone)
    {
        
        $date = Carbon::createFromFormat($format, $datetime, $client_timezone);
        $date->setTimezone('UTC');
        return $date;
    }

    /**
     * Datetime UTC to Client TZ
     */
    public static function dateUTCToClientTZ($format, $datetime, $is_timestampms,$client_timezone)
    {
        $datetime = self::timestampToDate($datetime, $is_timestampms);
        
                  
        /*$ch = curl_init();
        $options = array(
            CURLOPT_URL => 'http://ipinfo.io/json',
            CURLOPT_HEADER => 0, // remove header in response
            CURLOPT_RETURNTRANSFER => true,
        ); // cURL options
        
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        $errors = curl_error($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        if (isset(json_decode($result)->timezone)) {
            $s_timezone = json_decode($result)->timezone;
        }
        
        $timezone = $s_timezone ?? 'UTC';*/
        $date = Carbon::createFromFormat($format, $datetime, 'UTC');
        $date->setTimezone($client_timezone);
        
        return $date;
    }

    /**
     * convert timestamp to date
     *
     * @param $timestamp timestamp to be convert into date
     * @param $ms true if need timestamp is in miliseconds
     */
    public static function timestampToDate($timestamp, $ms = false)
    {
        if ($ms) {
            $timestamp = $timestamp / 1000;
            //return (Carbon::parse($date)->timestamp) * 1000;
        }
        //return Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'UTC')->setTimezone('UTC');
        return Carbon::createFromTimestamp($timestamp);
    }

    /**
     * Convert seconds to HH:mm
     */
    public static function secondsToHM($seconds)
    {
        return gmdate('H:i', $seconds);
    }

    /** seconds to ms */
    public static function secondsToMilliSecond($seconds) {
        return $seconds * 1000;
    }

}