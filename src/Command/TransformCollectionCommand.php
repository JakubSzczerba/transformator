<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Command;

use App\Provider\CollectionProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'transform:collection')]
class TransformCollectionCommand extends Command
{
    private CollectionProvider $collectionProvider;

    public function __construct(CollectionProvider $collectionProvider)
    {
        $this->collectionProvider = $collectionProvider;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Transforms collection data')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the source file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->collectionProvider->getData($input->getArgument('file'));

        $reportsData = $data['reports'] ?? [];
        $overviewsData = $data['overviews'] ?? [];
        $invalidData = $data['invalid'] ?? [];
        $folderName = (new \DateTime('now', new \DateTimeZone('Europe/Warsaw')))->format('Y-m-d_H-i-s');
        $outputPath = '%kernel.root_dir%/../src/Data/Output/' . $folderName . '/';

        if (!is_dir($outputPath)) {
            mkdir($outputPath, 0777, true);
        }

        /* Getting reports */
        $reportsJson = json_encode($reportsData);
        file_put_contents($outputPath . 'reports.json', $reportsJson);

        /* Getting overviews */
        $overviewsJson = json_encode($overviewsData);
        file_put_contents($outputPath . 'overviews.json', $overviewsJson);

        /* Getting invalid messages */
        $invalidJson = json_encode($invalidData);
        file_put_contents($outputPath . 'invalid.json', $invalidJson);

        /* Getting summary*/
        $totalMessages = count($reportsData) + count($overviewsData) + count($invalidData);
        $reportsCount = count($reportsData);
        $overviewsCount = count($overviewsData);
        $invalidCount = count($invalidData);

        $output->writeln('Transform file has been completed at ' . $folderName);
        $output->writeln("Total messages processed: $totalMessages");
        $output->writeln("Reports created: $reportsCount");
        $output->writeln("Overviews created: $overviewsCount");
        $output->writeln("Invalid messages: $invalidCount");

        if ($invalidCount > 0) {
            $output->writeln("Some messages has not been processed:");

            foreach ($invalidData as $index => $item) {
                $output->writeln("  - Message {$item['number']}: {$item['description']})");
            }
        }

        return Command::SUCCESS;
    }
}