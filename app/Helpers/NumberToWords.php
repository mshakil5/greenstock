<?php

namespace App\Helpers;

class NumberToWords
{
    public static function convert($number)
    {
        $words = [
            '0' => '', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', 
            '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', 
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', 
            '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen', 
            '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty', 
            '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy', 
            '80' => 'Eighty', '90' => 'Ninety'
        ];
        
        $levels = ['', 'Thousand', 'Million', 'Billion'];

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
                    $chunkWords[] = $words[$chunk[0]] . ' Hundred';
                    $chunkInt %= 100;
                }
                if ($chunkInt > 0) {
                    if ($chunkInt < 20) {
                        $chunkWords[] = $words[$chunkInt];
                    } else {
                        $chunkWords[] = $words[(int)($chunkInt / 10) * 10];
                        if ($chunkInt % 10 > 0) {
                            $chunkWords[] = $words[$chunkInt % 10];
                        }
                    }
                }
                $wordArray[] = implode(' ', $chunkWords) . ' ' . $levels[count($chunks) - $index - 1];
            }
        }

        return implode(', ', $wordArray);
    }
}
