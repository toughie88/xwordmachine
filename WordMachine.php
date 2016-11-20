<?php

class WordMachine
{
    const WRONG_TEXT_THRESHOLD = 100;

    private $string;
    private $language;
    private $stringLength;

    private $learning;

    public function __construct()
    {
        $this->learning = new Learning();
    }

    /**
     * @return int
     */
    public function rate()
    {
        $sum = 0;

        $this->setStringLength($this->string);
        $arr      = $this->getWords($this->string);
        $arrCount = array_count_values($arr);
        $this->learning->setLanguage($this->language);
        $this->learning->setString($this->string);
        $vocabulary = $this->learning->getWords();
        foreach($arrCount as $k => $v)
        {
            if(empty($vocabulary[$k]) === false)
            {// if the word found in db then just divide count on db word count
                $sum += $v / $vocabulary[$k];
            }
            else
            { // if couldn't find the word in db just sum count of that word from string
                $sum += $this->getCountNotFound($k, $v);
            }
        }

        return (int) $sum;
    }

    private function getCountNotFound($word, $cnt)
    {
        $wordLen   = mb_strlen($word, Learning::UTF_8);
        $subFactor = $this->stringLength / (($wordLen >= 1) ? $wordLen : 1);
        if($subFactor > Learning::FACTOR)
        {
            return $cnt * $wordLen * $subFactor;
        }
        else
        {
            // worst case 1 * 1 pow of 2.72 - when word length and frequency = 1
            return pow($cnt * $wordLen, Learning::POWER);
        }
    }

    private function getWords($str)
    {
        $learning = new Learning();

        return array_map(
            function ($v) use ($learning)
            {
                return $learning->cleanWord($v);
            }, explode(' ', $str)
        );
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param mixed $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    /**
     * @param mixed $stringLength
     */
    public function setStringLength($stringLength)
    {
        $this->stringLength = mb_strlen($stringLength, Learning::UTF_8);;
    }
}