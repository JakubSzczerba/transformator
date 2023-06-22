<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
 */

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\TransformCollectionCommand;
use App\Provider\CollectionProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class TransformCollectionCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $filePath = '/path/to/source/file.json';

        $collectionProvider = $this->createMock(CollectionProvider::class);
        $collectionProvider->expects($this->once())
            ->method('getData')
            ->with($filePath)
            ->willReturn([
                'reports' => [
                    // sprawdzenie dla pustych zbiorów
                ],
                'overviews' => [
                    // sprawdzenie dla pustych zbiorów
                ],
                'invalid' => [
                    // sprawdzenie dla pustych zbiorów
                ],
            ]);

        $command = new TransformCollectionCommand($collectionProvider);
        $input = new ArrayInput(['file' => $filePath]);
        $output = new BufferedOutput();
        $statusCode = $command->run($input, $output);
        $this->assertSame(0, $statusCode);

        $now = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
        $folderName = $now->format('Y-m-d_H-i-s');

        $expectedOutput = <<<OUTPUT
Transform file has been completed at $folderName
Total messages processed: 0
Reports created: 0
Overviews created: 0
Invalid messages: 0
OUTPUT;

        $this->assertSame($expectedOutput, trim($output->fetch()));
    }
}