<?php

namespace App\Helpers;

class NumberToWords
{
    private static $words = [
        '0' => '', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', 
        '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', 
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', 
        '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen', 
        '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty', 
        '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy', 
        '80' => 'Eighty', '90' => 'Ninety'
    ];

    private static $levels = ['', 'Thousand', 'Million', 'Billion'];

    public static function convert($number)
    {
        $number = str_replace(',', '', $number); // Remove commas
        if (strpos($number, '.') !== false) {
            list($integerPart, $decimalPart) = explode('.', $number);
            $integerPart = (int)$integerPart;
            $decimalPart = (int)substr($decimalPart, 0, 2); // Considering only two decimal places
        } else {
            $integerPart = (int)$number;
            $decimalPart = 0;
        }

        $words = self::convertIntegerPart($integerPart);
        if ($decimalPart > 0) {
            $words .= ' and ' . self::convertIntegerPart($decimalPart) . ' Cents';
        }

        return $words;
    }

    private static function convertIntegerPart($number)
    {
        if ($number == 0) {
            return 'Zero';
        }

        $numberStr = (string)$number;
        $length = strlen($numberStr);
        $chunks = str_split(str_pad($numberStr, ceil($length / 3) * 3, '0', STR_PAD_LEFT), 3);

        $wordArray = [];

        foreach ($chunks as $index => $chunk) {
            $chunkInt = (int)$chunk;
            if ($chunkInt > 0) {
                $chunkWords = [];
                if ($chunkInt >= 100) {
                    $chunkWords[] = self::$words[$chunk[0]] . ' Hundred';
                    $chunkInt %= 100;
                }
                if ($chunkInt > 0) {
                    if ($chunkInt < 20) {
                        $chunkWords[] = self::$words[$chunkInt];
                    } else {
                        $chunkWords[] = self::$words[(int)($chunkInt / 10) * 10];
                        if ($chunkInt % 10 > 0) {
                            $chunkWords[] = self::$words[$chunkInt % 10];
                        }
                    }
                }
                $wordArray[] = implode(' ', $chunkWords) . ' ' . self::$levels[count($chunks) - $index - 1];
            }
        }

        return implode(', ', $wordArray);
    }
}
