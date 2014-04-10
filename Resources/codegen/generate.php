<?php
$dirs = array_filter(scandir('.'),function($f){ return preg_match('/^memcached-/', $f);});
foreach (array(true,false) as $interface) {
  ob_start();
  echo "<?php\nnamespace Lsw\MemcacheBundle\Cache;\n\n\$extension = new \\ReflectionExtension('memcached');\n";
  foreach ($dirs as $dir) {
    if (!preg_match('/^memcached-(.*)$/', $dir, $matches)) continue;
    $version = $matches[1];
    echo "if (\$extension->getVersion()=='$version') {\n";  
    $lines = file($dir.DIRECTORY_SEPARATOR.'memcached-api.php');
    $class = 0;
    if ($interface) echo "    interface MemcacheInterface {\n";
    else echo "    class LoggingMemcache extends \\Memcached implements MemcacheInterface, LoggingMemcacheInterface {\n";
    foreach ($lines as $line) {
      if (preg_match('/^\s*class/', $line)) $class++;
      if ($class != 1) continue;
      if (!preg_match('/^\s*public function/', $line)) continue;
      $line = preg_replace('/^\s*/', '        ', $line);
      preg_match('/public function ([^\(]*)\(/', $line, $matches);
      $function = $matches[1];
      if ($interface) {
      	if ($function != '__construct') {
      		echo str_replace(' {}', ';', $line);
      	}
      }
      else {
        $line = str_replace(' {}', ' {', $line);
        if ($function == '__construct') $php = <<<END_OF_PHP
        public function __construct(\$logging, \$persistentId = '') {
            \$this->calls = array();
            \$this->logging = \$logging;
            if (\$persistentId) {
                \$this->initialize = count(\$this->getServerList())==0;
            } else {
                \$this->initialize = true;
            }
            \$arguments = func_get_args();
            array_shift(\$arguments);
            forward_static_call_array("parent::__construct", \$arguments);
        }
        private \$calls;
        private \$initialize;
        private \$logging;
        public function getLoggedCalls() {
            return \$this->calls;
        }
        private function logCall(\$start, \$result) {
            \$time = microtime(true) - \$start;
            \$this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return \$result;
        }

END_OF_PHP;
        else $php = $line.<<<END_OF_PHP
            if (!\$this->logging) return forward_static_call_array('parent::$function', func_get_args());
            \$start = microtime(true);
            \$name = '$function';
            \$arguments = func_get_args();
            \$result = forward_static_call_array("parent::\$name", \$arguments);
            \$time = microtime(true) - \$start;
            \$this->calls[] = (object) compact('start', 'time', 'name', 'arguments', 'result');
            return \$result;
        }

END_OF_PHP;
        echo $php;
      }
    }
    echo "    }\n";
    echo "} else ";
  }
  echo "{\n    throw new \\Exception('LswMemcacheBundle does not support version '.\$extension->getVersion().' of the memcached extension.');\n}\n";
  if ($interface) file_put_contents('../../Cache/MemcacheInterface.php',ob_get_clean());
  else file_put_contents('../../Cache/LoggingMemcache.php',ob_get_clean());
}