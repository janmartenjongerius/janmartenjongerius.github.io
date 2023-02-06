<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:build',
    description: 'Build the application as a static webpage.',
)]
final class BuildCommand extends Command
{
    public function __construct(
        private readonly KernelInterface $kernel,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(
            $this
                ->kernel
                ->handle(
                    Request::createFromGlobals(),
                    catch: false
                )
                ->getContent()
        );

        return self::SUCCESS;
    }
}
