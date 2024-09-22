<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\UpdateVehicleLocationInFleetCommand;
use App\Domain\ValueObject\FleetId;
use App\Domain\ValueObject\Location;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'fleet:localize-vehicle', description: 'Localize vehicle into fleet')]
final class LocalizeVehicleIntoFleetConsoleCommand extends Command
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
        $this->addArgument('lat', InputArgument::REQUIRED, 'Latitude');
        $this->addArgument('lng', InputArgument::REQUIRED, 'Longitude');
        $this->addArgument('alt', InputArgument::OPTIONAL, 'Altitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $fleetIdArgument */
        $fleetIdArgument = $input->getArgument('fleetId');
        $fleetId = new FleetId($fleetIdArgument);
        /** @var string $vehiclePlateNumber */
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        /** @var float $latitude */
        $latitude = $input->getArgument('lat');
        /** @var float $longitude */
        $longitude = $input->getArgument('lng');
        /** @var float|null $altitude */
        $altitude = $input->getArgument('alt');


        $output->writeln("Start to localize vehicle : {$vehiclePlateNumber} into fleet : {$fleetId->toString()}");
        try {
            $this->handle(new UpdateVehicleLocationInFleetCommand(
                $fleetId,
                $vehiclePlateNumber,
                new Location(
                    $latitude,
                    $longitude,
                    $altitude
                )
            ));
        } catch (ExceptionInterface $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return Command::FAILURE;
        }

        $output->writeln("Vehicle was localized successfully");

        return Command::SUCCESS;
    }
}
