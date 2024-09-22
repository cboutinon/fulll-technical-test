<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\VehicleId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;

final class VehicleIdType extends GuidType
{
    public const NAME = 'vehicle_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof VehicleId) {
            return $value->toString();
        }

        throw ConversionException::conversionFailedInvalidType($value, self::NAME, ['null', VehicleId::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof VehicleId) {
            return $value;
        }

        try {
            /** @var string $value */
            return VehicleId::fromString($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
