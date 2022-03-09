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
        // Fazendo por linhas
        $start = 40000;
        $end = 59000;

//        for ($i = $start; $i <= $end; $i += $increment) {
//            dump(\str_pad($i, 7, 0, \STR_PAD_LEFT));
//        }

        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(['timeout' => 2,]);
        $goutteClient->setClient($guzzleClient);

        for ($i = $start; $i <= $end; $i += $increment) {
            $url = \sprintf("http://cnpj.info/%s", \str_pad($i, 7, 0, \STR_PAD_LEFT));
            $crawler = $goutteClient->request('GET', $url);
            dump($url);
            $crawler->filter('#content > ul > li > a:nth-child(1)')->each(function ($node) {
                $cnpj = new CNPJ;
                $cnpj->cnpj = $node->text();
                $cnpj->save();
//                dump($cnpj, $node->text());
            });
            \sleep(4);
        }
    }
}
