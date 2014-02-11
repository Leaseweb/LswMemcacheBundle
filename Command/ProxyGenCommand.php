<?php
namespace Lsw\MemcacheBundle\Command;

use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateProxyCommand
 * @package Lsw\MemcacheBundle\Command
 */
class ProxyGenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('memcache:proxygen')
            ->setDescription('Updates the proxy-classes. WARNING: Only run if you know what you\'re doing!');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $this->update($input, $output);
    }

    private function update(InputInterface $input, OutputInterface $output)
    {
        $class = new ReflectionClass('\Memcached');
        $methods = $class->getMethods();
        $implementation = '';
        $interface = '';
        foreach ($methods as $method) {
            if ($method->isConstructor() || !$method->isPublic()) {
                continue;
            }
            $methodName = $method->getName();
            $parameters = $method->getParameters();
            $implementation .= '    public function ';
            $interface .= '    public function ';
            if ($method->returnsReference()) {
                $implementation .= '&';
                $interface .= '&';
            }
            $implementation .= $methodName.'(';
            $interface .= $methodName.'(';
            $arguments = '';
            foreach ($parameters as $i => $parameter) {
                if ($i > 0) {
                    $implementation .= ', ';
                    $interface .= ', ';
                    $arguments .= ', ';
                }
                if ($parameter->isArray()) {
                    $implementation .= 'array ';
                    $interface .= 'array ';
                }
                if ($parameter->isPassedByReference()) {
                    $implementation .= '&';
                    $interface .= '&';
                }
                $implementation .= '$'.$parameter->getName();
                $interface .= '$'.$parameter->getName();
                $arguments .= '$'.$parameter->getName();
                if ($parameter->isOptional()) {
                    if ($parameter->isDefaultValueAvailable()) {
                        $implementation .= ' = '.$parameter->getDefaultValue();
                        $interface .= ' = '.$parameter->getDefaultValue();
                    } else {
                        $implementation .= ' = null';
                        $interface .= ' = null';
                    }
                }
            }
            $implementation .= ")\n";
            $interface .= ");\n\n";
            $initialize = '';
            $call = 'parent::'.$methodName.'('.$arguments.')';
            if (in_array($methodName, array('setOption', 'setOptions', 'addServer', 'addServers'))) {
                $initialize = 'if (!$this->initialize) return;';
            }

            $implementation .= "    {   {$initialize}";
            $implementation .= "        if (!\$this->logging) return {$call};";
            $implementation .= "        \$start = microtime(true);";
            $implementation .= "        \$name = '{$methodName}';";
            $implementation .= "        \$result = {$call};";
            $implementation .= "        \$arguments = array({$arguments});";
            $implementation .= "        \$time = microtime(true) - \$start;";
            $implementation .= "        \$this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');";
            $implementation .= "        return \$result;";
            $implementation .= "    }";

            $implementation .= "\n\n";
        }

        $template = __DIR__ . '/../Resources/codegen/';
        $target = __DIR__ . '/../Cache/';

        $code = file_get_contents($template . 'LoggingMemcacheTemplate.php.tpl');
        $code = str_replace('// INSERT FUNCTIONS HERE', trim($implementation), $code);
        if (!file_put_contents($target . 'LoggingMemcache.php', $code)) {
            throw new \RuntimeException("failed to write {$target}LoggingMemcache.php");
        }

        $code = file_get_contents($template . 'MemcacheInterfaceTemplate.php.tpl');
        $code = str_replace('// INSERT FUNCTIONS HERE', trim($interface), $code);

        if (!file_put_contents($target . 'MemcacheInterface.php', $code)) {
            throw new \RuntimeException("failed to write {$target}MemcacheInterface.php");
        }

        $output->writeln("<info>ok</info>");
    }
}
