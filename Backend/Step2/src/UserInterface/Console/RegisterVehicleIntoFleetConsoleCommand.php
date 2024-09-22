<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\RegisterVehicleInFleetCommand;
use App\Domain\ValueObject\FleetId;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'fleet:register-vehicle', description: 'Register vehicle into fleet')]
final class RegisterVehicleIntoFleetConsoleCommand extends Command
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
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle plate number');
        $this->addArgument('vehicleType', InputArgument::OPTIONAL, 'Type of vehicle');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $fleetIdArgument */
        $fleetIdArgument = $input->getArgument('fleetId');
        $fleetId = new FleetId($fleetIdArgument);
        /** @var string $vehiclePlateNumber */
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        /** @var string|null $vehicleType */
        $vehicleType = $input->getArgument('vehicleType');

        $output->writeln("Start to register vehicle : {$vehiclePlateNumber} into fleet : {$fleetId->toString()}");
        try {
            $this->messageBus->dispatch(new RegisterVehicleInFleetCommand(
                $fleetId,
                $vehiclePlateNumber,
                $vehicleType ?? ''
            ));
        } catch (ExceptionInterface $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return Command::FAILURE;
        }

        $output->writeln("Vehicle {$vehiclePlateNumber} was successfully registered into fleet : {$fleetId->toString()}");

        return Command::SUCCESS;
    }
}
