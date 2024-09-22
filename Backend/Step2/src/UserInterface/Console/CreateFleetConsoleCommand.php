<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\CreateFleetByUserCommand;
use App\Domain\ValueObject\FleetId;
use App\Domain\ValueObject\UserId;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'fleet:create', description: 'Create fleet by user')]
final class CreateFleetConsoleCommand extends Command
{
    use HandleTrait;
    public function __construct(
        MessageBusInterface $messageBus,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->messageBus = $messageBus;
    }

    protected function configure(): void
    {
        $this->addArgument('userId', InputArgument::REQUIRED, 'User Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start to create fleet');

        /** @var string $userIdArgument */
        $userIdArgument = $input->getArgument('userId');
        $userId = new UserId($userIdArgument);
        try {
            /** @var FleetId $fleetIdCreated */
            $fleetIdCreated = $this->handle(new CreateFleetByUserCommand($userId));
        } catch (ExceptionInterface $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return Command::FAILURE;
        }

        $output->writeln("Fleet with ID : {$fleetIdCreated->toString()} was created");

        return Command::SUCCESS;
    }
}
