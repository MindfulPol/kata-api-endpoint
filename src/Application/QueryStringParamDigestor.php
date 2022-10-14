<?php

namespace App\Application;

class QueryStringParamDigestor
{
    public function execute(?string $queryString): array
    {
        if (!$queryString) {
            return [];
        }
        $formattedQueryParams = [];
        $queryParamArray = explode('&', $queryString);
        foreach ($queryParamArray as $queryParam) {
            $queryParamSplit = explode('=', $queryParam);
            $formattedQueryParams[$queryParamSplit[0]] = $queryParamSplit[1];
        }
        return $formattedQueryParams;
    }
}
