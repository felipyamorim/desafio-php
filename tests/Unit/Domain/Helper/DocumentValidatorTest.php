<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Helper;

use App\Domain\Helper\DocumentValidator;
use PHPUnit\Framework\TestCase;

class DocumentValidatorTest extends TestCase
{
    public function testCnpj()
    {
        self::assertTrue(DocumentValidator::cnpj('68.954.738/0001-21'));
        self::assertNotTrue(DocumentValidator::cnpj('123'));
        self::assertNotTrue(DocumentValidator::cnpj('9999999999999999999999999999999999999999999'));
        self::assertNotTrue(DocumentValidator::cnpj('11.222.333/4444-55'));
        self::assertNotTrue(DocumentValidator::cnpj('99.999.999/9999-99'));
    }

    public function testCpf()
    {
        self::assertTrue(DocumentValidator::cpf('477.005.660-54'));
        self::assertNotTrue(DocumentValidator::cpf('123'));
        self::assertNotTrue(DocumentValidator::cpf('9999999999999999999999999999999999999999999'));
        self::assertNotTrue(DocumentValidator::cpf('111.222.333-44'));
        self::assertNotTrue(DocumentValidator::cpf('111.111.111-11'));
    }
}