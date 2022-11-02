<?php

namespace App\Services;

use Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class AppticaTopAppsService
{
    /**
     * Уникальный идентификатор приложения, в тестовом задании его значение 1421444 (это приложение Among Us)
     */
    const APPLICATION_ID = 1421444;

    /**
     * Уникальный идентификатор страны, в тестовом задании его значение 1 (United States)
     */
    const COUNTRY_ID = 1;

    /**
     * Наверняка, это API токен для Apptica
     */
    const B4NKGg = "fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l";

    /**
     * Парсит строку для запроса
     * @param \DateTimeInterface $date Дата, на которую нужно получить статистику
     * @return string
     */
    private function getRequestUrl(\DateTimeInterface $date): string
    {
        $dateString = $date->format("Y-m-d");

        return sprintf("https://api.apptica.com/package/top_history/%d/%d?date_from=%s&date_to=%s&B4NKGg=%s",
            self::APPLICATION_ID,
            self::COUNTRY_ID,
            $dateString,
            $dateString,
            self::B4NKGg
        );
    }

    public function getData(\DateTimeInterface $date)
    {
        $url = $this->getRequestUrl($date);
        $response = Http::get($url);

        $response->onError(function (Response $response) {
            throw $response->toException();
        });


    }
}
