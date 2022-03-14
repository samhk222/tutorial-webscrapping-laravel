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
        $config = \App\Configs::all()->first();

        $increment = $config->increment;
        // Fazendo por linhas
        $start = $config->start;
        $end = $start + $config->step;

        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(['timeout' => 2,]);
        $goutteClient->setClient($guzzleClient);

        for ($i = $start; $i <= $end; $i += $increment) {
            $current_url_param = \str_pad($i, 7, 0, \STR_PAD_LEFT);
            $url = \sprintf("http://cnpj.info/%s", $current_url_param);
            $crawler = $goutteClient->request('GET', $url);
            $crawler->filter('#content > ul > li > a:nth-child(1)')->each(function ($node) use (
                $start,
                $end,
                $current_url_param
            ) {
                $cnpj = new CNPJ;
                $cnpj->cnpj = $node->text();
                $cnpj->save();
                info('lendo agora', [$node->text(), 'start' => $start, 'end' => $end, 'current' => $current_url_param]);
            });
            \sleep(4);
        }

        info("Dados pós processamento",
            ['start' => $start, 'end' => $end, 'increment' => $increment, 'config' => $config->toArray()]);

        $config->update([
            'start' => $end
        ]);
    }
}
