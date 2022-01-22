<?php

declare(strict_types=1);

namespace App\Domain\Helper;

class DocumentValidator
{
    public static function cpf(string $document): bool
    {
        // Extrai os números
        $document = preg_replace('/[^0-9]/is', '', $document);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($document) !== 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $document)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $document[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($document[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public static function cnpj(string $document): bool
    {
        // Extrai os números
        $document = preg_replace('/[^0-9]/is', '', $document);

        // Valida tamanho
        if (strlen($document) !== 14) {
            return false;
        }

        // Verifica sequência de digitos repetidos. Ex: 11.111.111/111-11
        if (preg_match('/(\d)\1{13}/', $document)) {
            return false;
        }

        // Valida dígitos verificadores
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $m = ($t - 7), $i = 0; $i < $t; $i++) {
                $d += $document[$i] * $m;
                $m = ($m == 2 ? 9 : --$m);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($document[$i] != $d) {
                return false;
            }
        }

        return true;
    }
}