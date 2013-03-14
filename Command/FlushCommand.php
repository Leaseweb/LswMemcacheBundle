<?php

namespace Lsw\MemcacheBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Provides a command-line interface for flushing memcache content
 */
class FlushCommand extends ContainerAwareCommand
{

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
            new InputArgument('instance', InputArgument::REQUIRED, 'The instance'),
        ));
   }

   /**
    * Execute the CLI task
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @return void
    */
   protected function execute(InputInterface $input, OutputInterface $output)
   {
     $instance = $input->getArgument('instance');
     try {
         $memcache = $this->getContainer()->get('memcache.'.$instance);
         $output->writeln($memcache->flush()?'<info>OK</info>':'<error>ERROR</error>');
     } catch(ServiceNotFoundException $e) {
         $output->writeln("<error>Instance '$instance' is not found</error>");
     }
   }

   /**
    * Choose the instance
    *
    * @param InputInterface  $input  Input interface
    * @param OutputInterface $output Output interface
    *
    * @see Command
    * @return mixed
    */
   protected function interact(InputInterface $input, OutputInterface $output)
   {
       if (!$input->getArgument('instance')) {
           $instance = $this->getHelper('dialog')->askAndValidate(
                   $output,
                   'Please give the instance:',
                   function($instance)
                   {
                       if (empty($instance)) {
                           throw new \Exception('Instance can not be empty');
                       }

                       return $instance;
                   }
                   );
                   $input->setArgument('instance', $instance);
       }
   }

}
