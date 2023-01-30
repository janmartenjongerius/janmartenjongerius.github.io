<?php

namespace App\Command;

use App\Entity\Employer;
use App\Entity\Image;
use App\Repository\EmployerRepository;
use App\Repository\ImageRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:employer:import-logo',
    description: 'Import the given file as the logo for the given employer.',
)]
final class EmployerImportLogoCommand extends Command
{
    private const ARGUMENT_FILE = 'file';
    private const OPTION_EMPLOYER = 'employer';

    public function __construct(
        private readonly EmployerRepository $employers,
        private readonly ImageRepository $images,
        private readonly ValidatorInterface $validator,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument(
            name: self::ARGUMENT_FILE,
            mode: InputArgument::REQUIRED,
            description: 'The logo file.'
        );

        $this->addOption(
            name: self::OPTION_EMPLOYER,
            mode: InputOption::VALUE_REQUIRED,
            description: 'The employer ID or employer name.',
            default: null
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument(self::ARGUMENT_FILE);

        if (!is_readable($file)) {
            $io->error(sprintf('Cannot read contents of %s', $file));
            return self::INVALID;
        }

        $employerId = $input->getOption('employer') ?? $io->askQuestion(
            new ChoiceQuestion(
                'Select employer',
                array_reduce(
                    $this->employers->findAll(),
                    static fn (array $carry, Employer $employer): array => array_replace(
                        $carry,
                        [$employer->getId() => $employer->getName()]
                    ),
                    []
                )
            )
        );
        $employer = $this->employers->find($employerId) ?? $this->employers->findOneBy(
            ['name' => $employerId]
        );

        if (!$employer instanceof Employer) {
            $io->error(
                sprintf('Could not find employer <%s>', $employerId)
            );
            return self::FAILURE;
        }

        $image = new Image();
        $image->setContent(file_get_contents($file));

        $errors = $this->validator->validate($image);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $io->error($error->getMessage());
            }
            return self::FAILURE;
        }

        $this->images->save($image, flush: true);
        $employer->setLogo($image);
        $this->employers->save($employer, flush: true);

        $io->success(
            sprintf(
                'Imported logo for employer #%d <%s>',
                $employer->getId(),
                $employer->getName()
            )
        );

        return Command::SUCCESS;
    }
}
