<?php


namespace Lsw\MemcacheBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class InteractHelper
{
    private $questionText = 'Please give the pool';
    private $exceptionMessage = 'pool can not be empty';
    private $defaultPool = 'default';

    private function askForPoolQuestion(QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $question = new Question("$this->questionText ($this->defaultPool)", $this->defaultPool);
        $question->setValidator(function($pool) {
            if (empty($pool)) {
                throw new \Exception($this->exceptionMessage);
            }
            return $pool;
        });

        return $questionHelper->ask(
            $input,
            $output,
            $question
        );
    }

    private function askForPoolDialog(DialogHelper $dialogHelper, $output)
    {
        $pool = $dialogHelper->askAndValidate(
            $output,
            $this->questionText,
            function($pool)
            {
                if (empty($pool)) {
                    throw new \Exception($this->exceptionMessage);
                }

                return $pool;
            }
        );
        return $pool;
    }

    public function askForPool(Command $command, InputInterface $input, OutputInterface $output)
    {
        if ($command->getHelperSet()->has('question')) {
            return self::askForPoolQuestion($command->getHelper('question'), $input, $output);
        } else {
            return self::askForPoolDialog($command->getHelper('dialog'), $output);
        }
    }
}
