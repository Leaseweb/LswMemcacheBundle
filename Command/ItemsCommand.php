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
 * Provides a command-line interface for dumping memcache keys
 */
class ItemsCommand extends ContainerAwareCommand
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
            ->setName('memcache:items')
            ->setDescription('Lists Memcache items')
            ->setDefinition(array(
                    new InputArgument('client', InputArgument::REQUIRED, 'The client'),
                ))
            ->addOption('prefix', null, InputOption::VALUE_REQUIRED, 'Only lists items with specific prefix')
            ->addOption('regex', null, InputOption::VALUE_REQUIRED, 'Only lists items matching the expression');
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
        $prefix = $input->getOption('prefix');
        $regex = $input->getOption('regex');

        if(!empty($prefix) && !empty($regex)) {
            throw new \InvalidArgumentException('you cannot filter by prefix and regex');
        }

        if(!empty($prefix)) {
            $regex = '^'.$prefix.'(.*)';
        }

        try {
            $this->memcache = $this->getContainer()->get('memcache.'.$client);
            // reset prefix
            $this->memcache->setOption(\Memcached::OPT_PREFIX_KEY, '');

            // load keys
            if(empty($regex)) {
                $keys = $this->getAllKeys();
            } else {
                $keys = $this->getKeysByRegex($regex);
            }

            $output->writeln("<info>".count($keys)." items found</info>");

            foreach ($keys as $key) {
                // check if key has valid data
                if($this->memcache->get($key)) {
                    $state = '<info>valid</info>';
                } else {
                    $state = '<comment>invalid</comment>';
                }
                $output->writeln($key.' ['.$state.']');
            }

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

    /**
     * load all keys
     *
     * @return array
     */
    private function getAllKeys()
    {
        $keys = $this->memcache->getAllKeys();
        return $keys ? $keys : array();
    }

    /**
     * load keys filtered by regex
     *
     * @return array
     */
    private function getKeysByRegex($regex)
    {
        $keys = $this->getAllKeys();
        return preg_grep('@'.$regex.'@', $keys);
    }

}
