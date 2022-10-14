<?php

namespace App\Domain\Repository;

interface ProductRepositoryInterface
{
    public function searchByCriteria(array $criteria, int $limit): array;
}
