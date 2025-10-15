<?php

namespace App\Command;

use App\Entity\Quote;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add-quote',
    description: 'Add a short description for your command',
)]
class AddQuoteCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private MovieRepository $movieRepo
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('quote', InputArgument::REQUIRED, 'The quote text')
            ->addArgument('movieId', InputArgument::REQUIRED, 'Movie Id')
            ->addArgument('character', InputArgument::REQUIRED, 'Character name'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $quoteText = $input->getArgument('quote');
        $movieId = $input->getArgument('movieId');
        $character = $input->getArgument('character');

        if ($quoteText && $movieId && $character) {
            $movie = $this->movieRepo->find($movieId);
            if (!$movie) {
                $io->error('Movie not found');
            }

            $io->note(sprintf("You passed  this quote: %s \n for this movie : %s \n from this character: %s", $quoteText,$movie->getName(), $character ));

            $quote = new Quote();
            $quote->setQuote($quoteText);
            $quote->setCharacter($character);
            $quote->setMovie($movie);

            $this->em->persist($quote);
            $this->em->flush();

            $io->success("Quote added: \"$quoteText\"");


        }


        return Command::SUCCESS;
    }
}
