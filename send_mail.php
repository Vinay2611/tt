<?php

function send_mail( $to , $from , $subject, $body )
{
    if(empty($from))
    {
        $from = "jaiswal_vinay@dsvinfosolutions.com";
    }
    if(empty($to))
    {
        $to = "jaiswal_vinay@dsvinfosolutions.com";
    }
    $header = "From: ".$from."\r\n";
    $header .= 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    //send mail
    if(mail( $to, $subject, $body, $header))
    {
        return 1;
    }
    else
    {
        return 0;
    }

}