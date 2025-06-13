<?php

namespace App\Command;

use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:build',
    description: 'Build the application as a static webpage.',
)]
final class BuildCommand extends Command
{
    const string ARGUMENT_PATH = 'path';
    const string OPTION_BASE_URL = 'base-url';

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly RequestStack $requestStack,
        private readonly UriFactoryInterface $uriFactory,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument(
            self::ARGUMENT_PATH,
            InputArgument::REQUIRED,
            'Path to request.'
        );

        $this->addOption(
            self::OPTION_BASE_URL,
            'b',
            InputOption::VALUE_OPTIONAL,
            'The Base URL to request when building.',
            $_ENV['APP_HOMEPAGE'] ?? 'http://localhost/'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(
            $this->getResponse($input)->getContent()
        );

        return self::SUCCESS;
    }

    private function getResponse(InputInterface $input): Response
    {
        return $this->kernel->handle(
            $this->getRequest($input),
            catch: false
        );
    }

    private function getRequest(InputInterface $input): Request
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            $request = Request::create(
                (string) $this
                    ->uriFactory
                    ->createUri((string) $input->getOption(self::OPTION_BASE_URL))
                    ->withPath((string) $input->getArgument(self::ARGUMENT_PATH))
            );
        }

        return $request;
    }
}
