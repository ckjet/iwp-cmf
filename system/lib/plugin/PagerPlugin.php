<?php

use Phalcon\Mvc\User\Plugin;

/**
 * Plugin for pager
 */
class PagerPlugin extends Plugin {

    public function __construct($pager, $pages) {
        $this->left = $pages / 2;
        $this->right = $pages / 2 - 1;
        $this->current = $pager->current;
        $this->last = $pager->last;
        $this->total_pages = $pager->total_pages;
        $this->total_items = $pager->total_items;
        $this->next = $pager->next;
        $this->before = $pager->before;
        $this->items = $pager->items;
    }

    public function getLinks() {
        $out = array();
        if ($this->current > $this->left && $this->current < ($this->last - $this->right)) {
            for ($i = $this->current - $this->left; $i <= $this->current + $this->right; $i++) {
                $out[] = $i;
            }
        } elseif ($this->current <= $this->left && $this->left < $this->last) {
            $iSlice = 1 + $this->left - $this->current;
            for ($i = 1; $i <= $this->current + ($this->right + $iSlice); $i++) {
                $out[] = $i;
            }
        } elseif ($this->current > 1) {
            $iSlice = $this->right - ($this->last - $this->current);
            for ($i = $this->current - ($this->left + $iSlice); $i <= $this->last; $i++) {
                if ($i > 0) {
                    $out[] = $i;
                }
            }
        }
        return $out;
    }

}
