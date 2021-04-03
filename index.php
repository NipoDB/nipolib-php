#!/usr/bin/php
<?php

// TODO: design and include autoloader
require_once 'Nipo/Client.php';
require_once 'Nipo/Shell.php';

$socket = new \Nipo\Client('127.0.0.1', 2323);
