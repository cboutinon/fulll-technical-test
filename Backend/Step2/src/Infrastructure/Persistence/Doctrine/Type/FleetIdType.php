<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\FleetId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;

final class FleetIdType extends GuidType
{
    public const NAME = 'fleet_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof FleetId) {
            return $value->toString();
        }

        throw ConversionException::conversionFailedInvalidType($value, self::NAME, ['null', FleetId::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof FleetId) {
            return $value;
        }

        try {
            /** @var string $value */
            return FleetId::fromString($value);
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
