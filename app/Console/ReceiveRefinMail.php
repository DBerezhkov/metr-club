<?php
namespace App\Console;

use Webklex\IMAP\Facades\Client;

class ReceiveRefinMail
{
    public function __invoke()
    {
        $oClient = Client::account('ipoteka');
        $oClient->connect();
        $folders = $oClient->getFolders();
        logger($folders);
    }

}
