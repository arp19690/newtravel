<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Config for the CodeIgniter Redis library
 *
 * @see ../libraries/Redis.php
 */
// Default connection group for redis
require_once './constants.php';
$config['redis_default']['host'] = REDIS_HOST;  // IP address or host
$config['redis_default']['port'] = REDIS_PORT;   // Default Redis port is 6379
$config['redis_default']['password'] = REDIS_PASSWORD;   // Can be left empty when the server does not require AUTH

$config['redis_slave']['host'] = '';
$config['redis_slave']['port'] = '6379';
$config['redis_slave']['password'] = '';
