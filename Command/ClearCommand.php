<?php

namespace Lsw\MemcacheBundle\Command;

use Lsw\MemcacheBundle\Cache\AntiDogPileMemcache;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Provides a command-line interface for flushing memcache content
 */
class ClearCommand extends ContainerAwareCommand
{
    /**
     * @var AntiDogPileMemcache
     */
    private $memcache;

   /**
    * Configure the CLI task
    *
    * @return void
    */
   protected function configure()
   {
      $this
        ->setName('memcache:clear')
        ->setDescription('Invalidate all Memcache items')
        ->setDefinition(array(
            new InputArgument('pool', InputArgument::REQUIRED, 'The pool'),
        ));
   }

   /**
    * Execute the CLI task
    *
    * @param InputInterface  $input  Command input
    * @param OutputInterface $output Command output
    *
    * @return void
    */
   protected function execute(InputInterface $input, OutputInterface $output)
   {
        $pool = $input->getArgument('pool');

        try {
            $this->memcache = $this->getContainer()->get('memcache.'.$pool);

            $output->writeln($this->memcache->flush()?'<info>OK</info>':'<error>ERROR</error>');
        } catch (ServiceNotFoundException $e) {
            $output->writeln("<error>pool '$pool' is not found</error>");
        }
   }

   /**
    * Choose the pool
    *
    * @param InputInterface  $input  Input interface
    * @param OutputInterface $output Output interface
    *
    * @see Command
    * @return mixed
    */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('pool')) {
            $pool = (new InteractHelper())->askForPool($this, $input, $output);
            $input->setArgument('pool', $pool);
        }
    }

}
