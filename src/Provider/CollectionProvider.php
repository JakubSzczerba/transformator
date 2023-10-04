<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Provider;

use App\Dictionary\CollectionDictionary;
use App\Service\CollectionService;

class CollectionProvider
{
    private CollectionService $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function getData(string $filePath): array
    {
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        return [
            'overviews' => $this->transformOverviews($data),
            'reports' => $this->transformReports($data),
            'invalid' => $this->transformInvalids($data),
        ];
    }

    private function transformOverviews(array $data): array
    {
        $overviews = [];
        $descriptions = [];

        foreach ($data as $item) {
            $description = strtolower($item['description']);

            if (in_array($description, $descriptions)) {
                continue;
            }

            if (stripos($description, CollectionDictionary::KEY)) {
                $overview = $this->collectionService->getOverview($item['description'], $item['dueDate'], $item['phone']);
                $descriptions[] = $description;
                $overviews[] = $overview->jsonSerialize();
            }
        }

        return $overviews;
    }

    private function transformReports(array $data): array
    {
        $reports = [];
        $descriptions = [];

        foreach ($data as $item) {
            $description = strtolower($item['description']);

            if (in_array($description, $descriptions)) {
                continue;
            }

            if (stripos($description, CollectionDictionary::KEY)) {
                continue;
            }

            $priority = $this->getPriorityForDescription($description);
            $report = $this->collectionService->getReport($item['description'], $item['dueDate'], $item['phone'], $priority);
            $descriptions[] = $description;
            $reports[] = $report->jsonSerialize();
        }

        return $reports;
    }

    private function transformInvalids(array $data): array
    {
        $invalid = [];
        $descriptions = [];

        foreach ($data as $item) {
            $description = strtolower($item['description']);

            if (in_array($description, $descriptions)) {
                $invalid[] = $item;
                continue;
            }

            if (stripos($description, CollectionDictionary::KEY)) {
                continue;
            }

            $descriptions[] = $description;
        }

        return $invalid;
    }

    private function getPriorityForDescription(string $description): string
    {
        if (stripos($description, CollectionDictionary::VERY_IMPORTANT) !== false) {
            return CollectionDictionary::CRITICAL;
        } elseif (stripos($description, CollectionDictionary::IMPORTANT) !== false) {
            return CollectionDictionary::HIGH;
        }

        return CollectionDictionary::NORMAL;
    }
}