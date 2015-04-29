<?php

//	cron run command
// php /var/www/html/ls2xero.vi/public_html/cron.php cron/dailyCron


    /**
     * @author       Asim Zeeshan
     * @web         http://www.asim.pk/
     * @date     13th May, 2009
     * @copyright    No Copyrights, but please link back in any way
     *
     * @url     http://www.asim.pk/2009/05/14/creating-and-installing-crontabs-using-codeigniter/
     */

    /*
    |---------------------------------------------------------------
    | CASTING argc AND argv INTO LOCAL VARIABLES
    |---------------------------------------------------------------
    |
    */
    $argc = $_SERVER['argc'];
    $argv = $_SERVER['argv'];

// INTERPRETTING INPUT
    if ($argc > 1 && isset($argv[1])) {

        $_SERVER['PATH_INFO']   = $argv[1];
        $_SERVER['REQUEST_URI'] = $argv[1];

    } else {

        $_SERVER['PATH_INFO']   = '/cron/dailyCron';
        $_SERVER['REQUEST_URI'] = '/cron/dailyCron';

    }

    /*
    |---------------------------------------------------------------
    | PHP SCRIPT EXECUTION TIME ('0' means Unlimited)
    |---------------------------------------------------------------
    |
    */
    set_time_limit(0);

    require_once('index.php');

    /* End of file test.php */