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
        // Cria o cliente do goutte
        $goutteClient = new Client();

        // Cria o cliente do Guzzle
        $guzzleClient = new GuzzleClient(['timeout' => 3,]);

        // Informa ao cliente do goutte que utilizaremos o guzzle
        $goutteClient->setClient($guzzleClient);

        // Define a url a qual iremos fazer o scraping
        $url = "http://cnpj.info/1110000";

        // Seta o filtro que iremos buscar na página
        $cnpj_filter = '#content > ul > li > a:nth-child(1)';
        $crawler = $goutteClient->request('GET', $url);

        // Pega o dado, e salva o mesmo
        $crawler->filter($cnpj_filter)->each(function ($node) {
            $cnpj = new CNPJ;
            $cnpj->cnpj = $node->text();
            $cnpj->save();
        });

        \sleep(4);
    }
}
