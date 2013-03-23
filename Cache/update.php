<?php
$newClassName = 'LoggingMemcache';
$className = 'Memcached';
$class = new ReflectionClass($className);
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
    $call = 'parent::'.$methodName.'(';
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
    $call .= $arguments.')';
    if (in_array($methodName, array('setOption', 'setOptions', 'addServer', 'addServers'))) {
        $intialize = 'if (!\$this->initialize) return;';
    } else {
        $initialize = '';
    }
    $implementation .= <<<END_OF_CODE
    {   $initialize
        if (!\$this->logging) return $call;
        \$start = microtime(true);
        \$name = '$methodName';
        \$result = $call;
        \$arguments = array($arguments);
        \$time = microtime(true) - \$start;
        \$this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
        return \$result;
    }
END_OF_CODE;
    $implementation .= "\n\n";
}

$code = file_get_contents('LoggingMemcacheTemplate.php');
$code = str_replace('// INSERT FUNCTIONS HERE',trim($implementation),$code);
if (!file_put_contents('LoggingMemcache.php',$code)) die('failed to write LoggingMemcache.php');
$code = file_get_contents('MemcacheInterfaceTemplate.php');
$code = str_replace('// INSERT FUNCTIONS HERE',trim($interface),$code);
if (!file_put_contents('MemcacheInterface.php',$code)) die('failed to write MemcacheInterface.php');
echo "ok\n";