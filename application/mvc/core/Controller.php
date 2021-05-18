<?php
    abstract class Controller {
        protected $MODEL;

        abstract protected function run($subactions = null);
    }
?>