<?php

namespace Lsw\MemcacheBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

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
        ->setDescription('Invalidate all Memcache items');
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
     $memcache = $this->getContainer()->get('memcache');
     $output->writeln($memcache->flush()?'<info>OK</info>':'<error>ERROR</error>');
     $output->writeln($this->formatStats($memcache->getStats()));
   }

}
