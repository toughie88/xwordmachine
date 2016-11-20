<?php
require_once 'Model.php';
require_once 'LearningDb.php';
require_once 'Learning.php';
require_once 'WordMachine.php';

$wordMachine = new WordMachine();
//$wordMachine->setString('kjvnsdfjv vsfvsdfvdfvdvkjsndfjvdfvjksndfvkjdfsvdkflsnvdjkvnsjfjnfvjfvjjknvksdfjn');
//$wordMachine->setString('на него упал кирпич и он ошалел');
$wordMachine->setString('f млдыоватам авмывамва вамвы мывамва амвы мыв f f это f f f ему f f f f f f f ');
//$wordMachine->setString('то он');
$wordMachine->setLanguage('ru');

$rate = $wordMachine->rate();
if ($rate > WordMachine::WRONG_TEXT_THRESHOLD) {
    echo "\033[31m " . $wordMachine->rate() . "\033[0m hey :-( this text seems incorrect \n";
} else {
    echo "\033[32m " . $wordMachine->rate() . "\033[0m text is correct in many forms \n";
}
