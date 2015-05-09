<?php

class BaseTask extends \Phalcon\CLI\Task {

    private $foreground_colors = array();
    private $background_colors = array();
    public $root;
    public $app_root;

    protected function initialize() {
        $this->foreground_colors = array(
            'black' => '0;30',
            'black:bold' => '1;30',
            'blue' => '0;34',
            'blue:bold' => '1;34',
            'green' => '0;32',
            'green:bold' => '1;32',
            'cyan' => '0;36',
            'cyan:bold' => '1;36',
            'red' => '0;31',
            'red:bold' => '1;31',
            'purple' => '0;35',
            'purple:bold' => '1;35',
            'brown' => '0;33',
            'brown:bold' => '1;33',
            'gray' => '0;37',
            'gray:bold' => '1;37'
        );

        $this->app_root = realpath('./system');
        $this->root = realpath('.');
        
        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    public function textColor($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

    protected function show_status($done, $total, $size = 30) {
        if ($done > $total) {
            return null;
        }
        if (!$this->start_time) {
            $this->start_time = time();
        }
        $now = time();
        $perc = (double) ($done / $total);
        $bar = floor($perc * $size);
        $status_bar = "\r[";
        $status_bar .= str_repeat("=", $bar);
        if ($bar < $size) {
            $status_bar .= ">";
            $status_bar .= str_repeat(" ", $size - $bar);
        } else {
            $status_bar .= "=";
        }
        $disp = number_format($perc * 100, 0);
        $status_bar .= "] $disp%  $done/$total";
        $rate = ($now - $this->start_time) / $done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);
        $elapsed = $now - $this->start_time;
        $status_bar .= " осталось: " . number_format($eta) . " сек.  затрачено: " . number_format($elapsed) . " сек.";
        echo "$status_bar  ";
        flush();
        if ($done == $total) {
            echo "\n";
        }
    }

}
