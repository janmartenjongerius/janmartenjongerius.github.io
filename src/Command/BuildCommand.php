<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:build',
    description: 'Build the application as a static webpage.',
)]
final class BuildCommand extends Command
{
    const ARGUMENT_URL = 'url';

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly RequestStack $requestStack,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument(
            self::ARGUMENT_URL,
            InputArgument::OPTIONAL,
            'The URL to request when building.',
            $_ENV['APP_HOMEPAGE'] ?? 'http://localhost/'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(
            $this
                ->kernel
                ->handle(
                    (
                        $this->requestStack->getCurrentRequest()
                        ?? Request::create($input->getArgument(self::ARGUMENT_URL))
                    ),
                    catch: false
                )
                ->getContent()
        );

        return self::SUCCESS;
    }
}
