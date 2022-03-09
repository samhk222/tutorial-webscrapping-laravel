<?php

namespace App\Http\Controllers;

use App\CNPJ;
use Illuminate\Http\Request;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class GoutteController extends Controller
{
    public function doWebScraping()
    {
        $increment = 1000;
        $start = 0;
//        $end = 9999000;
        $end = 3000;

        #for ($i = $start; $i <= $end; $i += $increment) {
        #    dump(\str_pad($i, 7, 0, \STR_PAD_LEFT));
        #}


        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'verify' => false
        ));
        $goutteClient->setClient($guzzleClient);


        for ($i = $start; $i <= $end; $i += $increment) {
            $url = \sprintf("http://cnpj.info/%s", \str_pad($i, 7, 0, \STR_PAD_LEFT));
            $crawler = $goutteClient->request('GET', $url);
            dump($url);
            $crawler->filter('#content > ul > li > a:nth-child(1)')->each(function ($node) {
                $cnpj = new CNPJ;
                $cnpj->cnpj = $node->text();
                $cnpj->save();
            });
            \sleep(4);
        }
    }
}
