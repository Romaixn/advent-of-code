<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'aoc:submit',
    description: 'Submit your code to Advent of Code',
)]
class AocSubmitCommand extends Command
{
    private SymfonyStyle $io;

    public function __construct(
        private readonly HttpClientInterface $client,
        #[Autowire('%aoc_cookie%')]
        private readonly string $cookie
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('day', InputArgument::OPTIONAL, 'Day of the challenge')
            ->addArgument('level', InputArgument::OPTIONAL, 'Level of the challenge')
            ->addArgument('answer', InputArgument::OPTIONAL, 'Answer to submit')
            ->addArgument('year', InputArgument::OPTIONAL, 'Year of the challenge', '2022')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (null !== $input->getArgument('day') && null !== $input->getArgument('answer')) {
            return;
        }

        $this->io->title('Submit your code to Advent of Code');

        /** @var int|null $year */
        $year = $input->getArgument('year');
        if (null !== $year) {
            $this->io->text(' > <info>Year</info>: '.$year);
        } else {
            $year = $this->io->ask('Year', '2022');
            $input->setArgument('year', $year);
        }

        /** @var int|null $day */
        $day = $input->getArgument('day');
        if (null !== $day) {
            $this->io->text(' > <info>Day</info>: '.$day);
        } else {
            $day = $this->io->ask('Day', null);
            $input->setArgument('day', $day);
        }

        /** @var int|null $level */
        $level = $input->getArgument('level');
        if (null !== $level) {
            $this->io->text(' > <info>Level (1 or 2)</info>: '.$level);
        } else {
            $level = $this->io->ask('Level');
            $input->setArgument('level', $level);
        }

        /** @var int|string|null $answer */
        $answer = $input->getArgument('answer');
        if (null !== $answer) {
            $this->io->text(' > <info>Answer</info>: '.$answer);
        } else {
            $answer = $this->io->ask('Answer');
            $input->setArgument('answer', $answer);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var int $day */
        $day = $input->getArgument('day');
        /** @var int|string $answer */
        $answer = $input->getArgument('answer');
        /** @var int $year */
        $year = $input->getArgument('year');
        /** @var int $level */
        $level = $input->getArgument('level');

        $response = $this->client->request('POST', "https://adventofcode.com/{$year}/day/{$day}/answer", [
            'headers' => [
                'cookie' => 'session='.$this->cookie,
            ],
            'body' => [
                'level' => $level,
                'answer' => $answer,
            ],
        ]);

        $result = $response->getContent();

        if (str_contains($result, 'You gave an answer too recently')) {
            $io->error('Too many requests.');

            return Command::FAILURE;
        }

        if (str_contains($result, 'not the right answer')) {
            if (str_contains($result, 'too low')) {
                $io->error('Wrong answer. (too low)');

                return Command::FAILURE;
            }

            if (str_contains($result, 'too high')) {
                $io->error('Wrong answer. (too high)');

                return Command::FAILURE;
            }

            $io->error('Wrong answer.');

            return Command::FAILURE;
        }

        if (str_contains($result, 'seem to be solving the right level.')) {
            $io->error('Invalid level.');

            return Command::FAILURE;
        }

        $io->success('Good answer!');

        return Command::SUCCESS;
    }
}
