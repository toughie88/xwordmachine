<?php

use learning\db\Model;

class Learning extends Model
{
    const UTF_8  = 'utf-8';
    const FACTOR = 1.62; // golden ratio
    const POWER  = 2.72; // exponent

    private $string;
    private $language;
    private $trimmer = '.,-_';

    // associate language to number of letters
    public static $languages = [
        'ru' => 2
    ];

    public function __construct()
    {
        parent::__construct(LearningDb::getConnection());
    }

    public function save()
    {
        $arr      = explode(' ', $this->string);
        $arrCount = array_count_values($arr);

        foreach($arrCount as $word => $cnt)
        {// save to db each key=>val pair
            $trimmedWord = $this->cleanWord($word);
            if(empty($trimmedWord) === false &&
               mb_strlen($trimmedWord, self::UTF_8) >= self::$languages[$this->language]
            )
            {
                $sql = 'INSERT INTO vocabulary SET `word` = ?, `count` = ?, `lang` = ?';
                $this->executeQuery(
                    $sql, [
                        $trimmedWord,
                        $cnt,
                        $this->language,
                    ]
                );
            }
        }
    }

    public function getWords()
    {
        $sql = 'SELECT `word`, `count` FROM vocabulary WHERE `lang` = ?';

        return array_column($this->queryAll($sql, [$this->language]), 'count', 'word');
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
     * @return string
     */
    public function getTrimmer()
    {
        return $this->trimmer;
    }

    public function cleanWord($word)
    {
        return mb_strtolower(trim($word, $this->getTrimmer()), Learning::UTF_8);
    }
}