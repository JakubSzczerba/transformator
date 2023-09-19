<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Service;

use App\Dictionary\CollectionDictionary;
use App\Entity\Overview;
use App\Entity\Report;

class CollectionService
{
    public function getOverview(string $description, ?string $dueDate, ?string $phone): Overview
    {
        $overview = new Overview();

        if (empty($dueDate)) {
            $overview->setStatus(CollectionDictionary::STATUS_NEW);
        } else {
            $overviewAt = new \DateTimeImmutable($dueDate);
            $overview
                ->setOverviewAt($overviewAt)
                ->setNumberOfWeek((int)$overviewAt->format('W'))
                ->setStatus(CollectionDictionary::STATUS_SCHEDULED);
        }

        $overview->setDescription($description);

        if (!empty($phone)) {
            $overview->setPhone($phone);
        }

        return $overview;
    }

    public function getReport(string $description, ?string $dueDate, ?string $phone, string $priority): Report
    {
        $report = new Report();

        if (empty($dueDate)) {
            $report->setStatus(CollectionDictionary::STATUS_NEW);
        } else {
            $report->setVisitedAt(new \DateTimeImmutable($dueDate));
            $report->setStatus(CollectionDictionary::STATUS_DATE);
        }

        $report->setDescription($description);
        $report->setPriority($priority);

        if (!empty($phone)) {
            $report->setPhone($phone);
        }

        return $report;
    }
}