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
class ClearCommand extends ContainerAwareCommand
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
            new InputArgument('client', InputArgument::REQUIRED, 'The client'),
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
        $client = $input->getArgument('client');
        try {
            $memcache = $this->getContainer()->get('memcache.'.$client);
            $output->writeln($memcache->flush()?'<info>OK</info>':'<error>ERROR</error>');
        } catch (ServiceNotFoundException $e) {
            $output->writeln("<error>client '$client' is not found</error>");
        }
   }

   /**
    * Choose the client
    *
    * @param InputInterface  $input  Input interface
    * @param OutputInterface $output Output interface
    *
    * @see Command
    * @return mixed
    */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('client')) {
            $client = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please give the client:',
                function($client)
                {
                   if (empty($client)) {
                       throw new \Exception('client can not be empty');
                   }

                   return $client;
                }
            );
            $input->setArgument('client', $client);
        }
    }

}
