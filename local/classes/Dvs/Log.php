<?php

namespace Dvs;

/*
 * Logging the results of methods
 */

class Log {
    /*
     * Default log dir
     * @var string
     */

    const PATH = '/local/DvsLogs/';
    /*
     * Path to .htaccess
     * @var string
     */
    const HTACCESS = '/local/DvsLogs/.htaccess';

    /*
     * The main method, tries to write data to the log
     * @param string|array $data
     * @param string $method Must be a value of constant __METHOD__
     * @return bool|int Bool or the number of bytes that were written to the file
     */

    public static function add($data, $method) {
        if (!static::isMethodExists($method)) {
            return false;
        }
        [$class, $methodName] = explode('::', $method);
        if (($path = static::createPathIfNotExists(static::prepareClassPath($class)))) {
            static::checkHtaccess();
            $data = array_merge(['class_method' => $methodName], ['log_data' => $data]);
            return static::put_contents($data, $path . date('Y_m_d') . '.log');
        }
        return false;
    }

    /*
     * If the directory does not exist, the method tries to create it
     * @param string $classPath
     * @return string|bool file path or false;
     */

    protected static function createPathIfNotExists($classPath) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . self::PATH . "$classPath";
        if (!is_dir($path) && !mkdir($path, 0777, true)) {
            return false;
        }
        return $path . '/';
    }

    /*
     * Prepares path from class name,
     * if class namespace contains Dvs, removes it
     * @param string $class
     * @return string $path
     */

    protected static function prepareClassPath($class) {
        $path = str_replace('\\', '/', trim($class, '\\'));
        return str_replace('Dvs/', '', $path);
    }

    /*
     * Checking if method exists
     * @param $method the value of constant __METHOD__
     * @return bool
     */

    protected function isMethodExists($method) {
        [$class, $methodName] = explode('::', $method);
        return method_exists($class, $methodName);
    }

    /*
     * Processes and puts data into a file
     * @param string|array|object $data
     * @param string $file
     * @return bool|int Bool or the number of bytes that were written to the file
     */

    protected static function put_contents($data, $file) {
        $line = '=======================';
        $header = "|$line" . date('d.m.Y H:i:s') . "$line|" . PHP_EOL;
        $footer = preg_replace('/[^=|' . PHP_EOL . ']/', '=', $header);
        $content = $header . var_export($data, true) . PHP_EOL . $footer;
        return file_put_contents($file, $content, FILE_APPEND);
    }

    /*
     * Checks if .htaccess exists in the log directory, if not creates it,
     * with "deny from all" instruction
     */

    protected static function checkHtaccess() {
        $file = $_SERVER['DOCUMENT_ROOT'] . self::HTACCESS;
        if (!file_exists($file)) {
            return file_put_contents($file, 'order deny,allow' . PHP_EOL . 'deny from all');
        }
        return true;
    }

    /*
     * Method tries get data from the log. Should be used with caution because,
     * the method uses the eval function on the log data, which may be damaged.
     * @param stirng $className
     * @return array
     */

    public function getData($class) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . self::PATH . static::prepareClassPath($class);
        if (!is_dir($path))
            return false;
        $arFiles = scandir($path);
        unset($arFiles[0], $arFiles[1]);
        foreach ($arFiles as $file) {
            $content .= file_get_contents("$path/$file");
        }
        if ($content) {
            foreach (preg_split('/\|=*\|/', $content) as $log) {
                if (empty(trim($log)))
                    continue;
                preg_match('/\|=*([^=]*)=*\|/', trim($log), $matches);
                $log = trim(preg_replace('/\|=*[^=]*=*\|/', '', $log)) . ';';
                $arResult[] = array_merge(['log_time' => $matches[1]],
                        static::var_import_to_array($log));
            }
        }
        return $arResult ?? [];
    }

    /*
     * Method imports the result of var_export function to array
     * @param stirng $strValue  Must be the result of var_export function
     * @return array
     */

    private static function var_import_to_array($strValue) {
        eval("\$var = $strValue");
        if (gettype($var) == 'array') {
            return $var;
        }
        return ['data' => $var];
    }

}
