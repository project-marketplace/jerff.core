<?php

namespace Project\Core;

use Bitrix\Main\Application;

class Location {

    static public function setCity($cityName) {
        $city = getCityFromBitrixLocation($cityName);

        if ($city)
            setCitySession($city["NAME_RU"], $city["ID"]);
        else
            setDefaultCity();
    }

    static public function setDefaultCity() {
        $_SESSION['LOCATION']['TYPE'] = 'default';
        setCitySession("Екатеринбург", 2204);
    }

    static public function getCityFromBitrixLocation($nameCity) {
        CModule::IncludeModule("sale");

        $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                    'select' => array(
                        'ID',
                        'NAME_RU' => 'NAME.NAME'
                    ),
                    'filter' => array(
                        '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                        'NAME_RU' => $nameCity
                    )
        ));

        $arLocation = $res->fetch();


        if ($arLocation)
            return $arLocation;
        else
            return false;
    }

    static public function getCityByIp() {
        $_SESSION['LOCATION']['TYPE'] = 'ip';
        $is_bot = preg_match(
                "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i", $_SERVER['HTTP_USER_AGENT']
        );

        // do not send request from robots
        if ($is_bot)
            return false;

        $ip = $_SERVER['REMOTE_ADDR'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://api.sypexgeo.net/json/" . $ip);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);
        $city = json_decode($data, $assoc = true);

        if ($city["city"]["name_ru"])
            return $city["city"]["name_ru"];
        else
            return false;
    }

    static public function setCitySession($cityName, $locationId = false) {
        $_SESSION['LOCATION']['CURRENT_CITY'] = $cityName;
        if ($locationId)
            $_SESSION['LOCATION']['ID'] = $locationId;
    }

}
