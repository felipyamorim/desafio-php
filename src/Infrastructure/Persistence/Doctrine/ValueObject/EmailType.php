<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\ValueObject;

use App\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const TYPE_NAME = 'vo_email';

    /**
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof Email) {
            return $value;
        }

        return parent::convertToDatabaseValue(
            (string) $value,
            $platform
        );
    }

    /**
     * @return Email|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return new Email(
            parent::convertToPHPValue(
                $value,
                $platform
            )
        );
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}