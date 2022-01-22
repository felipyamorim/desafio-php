<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\ValueObject;

use App\Domain\ValueObject\Document;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DocumentType extends StringType
{
    public const TYPE_NAME = 'vo_document';

    /**
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof Document) {
            return $value;
        }

        return parent::convertToDatabaseValue(
            (string) $value,
            $platform
        );
    }

    /**
     * @return Document|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return new Document(
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