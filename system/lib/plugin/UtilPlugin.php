<?php

use Phalcon\Mvc\User\Plugin;

/**
 * Plugin with utilites
 */
class UtilPlugin extends Plugin {

    public $db;

    public function __construct() {
        $this->db = $this->getDi()->getShared('db');
    }

    public function format_size($size) {
        $filesizename = array('Бт', 'Кб', 'Мб', 'Гб', 'Тб');
        if ($size == 0) {
            return '0 кб';
        }
        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $filesizename[$i];
    }

    public function dbSize() {
        $q = 'SHOW TABLE STATUS';
        $stmt = $this->db->query($q);
        $stmt->execute();
        $dbsize = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dbsize += $row['Data_length'] + $row['Index_length'];
        }
        return $dbsize;
    }

    public function getSqlVersion() {
        $q = 'SHOW VARIABLES LIKE \'version\'';
        $stmt = $this->db->query($q);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row['Value'] ? $row['Value'] : 'undefined');
    }

    public function getServerInfo() {
        $dt = disk_total_space($_SERVER['DOCUMENT_ROOT']);
        $df = disk_free_space($_SERVER['DOCUMENT_ROOT']);
        $du = $dt - $df;
        $dp = sprintf('%.2f', ($du / $dt) * 100);
        return array(
            'dbSize' => $this->format_size($this->dbSize()),
            'sqlVersion' => $this->getSqlVersion(),
            'arch' => php_uname('m'),
            'phpVersion' => phpversion(),
            'apacheVersion' => apache_get_version(),
            'OSName' => php_uname('s'),
            'cacheSize' => $this->format_size($this->dirSize($_SERVER['DOCUMENT_ROOT'] . '/system/cache')),
            'disk' => array(
                'used' => $this->format_size($du),
                'total' => $this->format_size($dt),
                'percent' => $dp
            )
        );
    }

    public function dirsize($dir) {
        $dh = opendir($dir);
        $size = 0;
        while ($file = readdir($dh)) {
            if ($file != "." and $file != "..") {
                $path = $dir . "/" . $file;
                if (is_dir($path)) {
                    $size += $this->dirsize($path);
                } elseif (is_file($path)) {
                    $size += filesize($path);
                }
            }
        }
        closedir($dh);
        return $size;
    }

    /**
     * Удаляет папку рекурсивно
     * @param string $dir
     */
    public function rmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            array_pop($files);
            array_pop($files);

            foreach ($files as $file) {
                $file = $dir . '/' . $file;
                if (is_dir($file)) {
                    $this->rmdir($file);
                    if (is_dir($file)) {
                        rmdir($file);
                    }
                } else {
                    unlink($file);
                }
            }
            rmdir($dir);
        }
        return false;
    }

    public function copyright($year) {
        if ($year < date('Y')) {
            return $year . '-' . date('Y');
        }
        return $year;
    }

}
