<?php

namespace App\Services;

use App\Models\ApplicationStatistic;
use App\Models\ExternalStatistic;
use Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

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

    /**
     * Отправляет запрос в Apptica и получает статистику в топе
     * @param \DateTimeInterface $date
     * @return Collection|ApplicationStatistic[]
     * @throws RequestException
     */
    public function getStatistic(\DateTimeInterface $date): Collection
    {
        $url = $this->getRequestUrl($date);
        $response = Http::get($url);

        $response->onError(function (Response $response) {
            throw $response->toException();
        });

        return $this->convertResponseJsonToApplicationStatisticCollection($response->json());
    }

    /**
     * Конвертирует пришедшие данные в коллекцию моделей ApplicationStatistic
     * @param array $json
     * @return Collection|ApplicationStatistic[]
     */
    private function convertResponseJsonToApplicationStatisticCollection(array $json): Collection
    {
        $statistic = $json['data'];
        $result = new Collection();

        foreach ($statistic as $category => $items) {
            $as = new ApplicationStatistic();
            $as->category = $category;

            foreach ($items as $key => $value) {
                $value = [array_keys($value)[0], array_values($value)[0]];
                $as->actual_date = $value[0];

                if (!$as->position) {
                    $as->position = $value[1];
                    continue;
                }

                $as->position = min($as->position, $value[1]);
            }

            $result->add($as);
        }

        return $result;
    }
}
