<?php
/**
 * Created by PhpStorm.
 * User: Chasovnikov
 * Date: 21.04.2018
 * Time: 13:19
 */

namespace App\libraries;

class GenerateText
{
    static private $arrayCharRus = [
        'а',
        'б',
        'в',
        'г',
        'д',
        'е',
        'ё',
        'ж',
        'з',
        'и',
        'й',
        'к',
        'л',
        'м',
        'н',
        'п',
        'р',
        'с',
        'т',
        'о',
        'у',
        'ф',
        'х',
        'ц',
        'ч',
        'ш',
        'щ',
        'ь',
        'ъ',
        'э',
        'ю',
        'я',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '0'
    ];

    /**
     * Выбирает случайные слова из донорского текста (огр. по кол-ву символов)
     *
     * @param int $countWords
     *
     * @return mixed
     */
    static public function wordFromDonorText($countWords = 100)
    {
        $arText = explode(' ', config('generate_text.donor_text'));

        $text = null;
        foreach (array_rand($arText, $countWords) as $item) {
            $text .= $arText[$item] . ' ';
        }

        return $text;
    }

    /**
     * Генерирует слово из случайных символов
     *
     * @param int $minChar
     * @param int $maxChar
     *
     * @return null|string
     */
    static public function wordFromRandChar($minChar = 2, $maxChar = 20)
    {
        $word = null;
        $min = $minChar < 2 ? 2 : $minChar;
        foreach (array_rand(self::$arrayCharRus, rand($min, $maxChar)) as $item) {
            $word .= self::$arrayCharRus[$item];
        }

        return $word;
    }

    /**
     * Генерирует текст из слов, состоящих из случайных символов
     *
     * @param int $countWords
     *
     * @return string
     */
    static public function textFromRandChar($countWords = 150)
    {
        $title = null;
        for ($j = 0; $j < $countWords; $j++) {
            $title .= self::wordFromRandChar() . ' ';
        }

        return $title;
    }

}