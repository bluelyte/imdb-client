<?php

namespace Bluelyte\IMDB\Client;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\DomCrawler\Crawler;

class Client extends \Goutte\Client
{
    protected $baseUrl = 'http://www.imdb.com';

    /**
     * Returns information for a specified TV show.
     *
     * @param string $id ID as contained in the URL for the TV show of the 
     *        form http://www.imdb.com/title/ID/
     * @return array Associative array of metadata about the TV show
     */
    public function getShowInfo($id)
    {
        $crawler = $this->request('GET', $this->baseUrl . '/title/' . $id . '/');
        $title = $crawler->filterXPath('//h1/span[@itemprop="name"]')->text();
        $latestSeason = $crawler->filterXPath('//div[@id="titleTVSeries"]//h4[text()="Season:"]/../span[1]/a[1]')->text();
        $showInfo = array(
            'title' => $title,
            'latestSeason' => $latestSeason,
        );
        return $showInfo;
    }

    /**
     * Returns a list of episodes for a specified season of a TV show.
     *
     * @param string $id ID as contained in the URL for the TV show of the 
     *        form http://www.imdb.com/title/ID/
     * @param string $season Season for which to return episodes
     * @return array Associative array indexed by episode number of 
     *         associative arrays each containing data for an individual 
     *         episode within the season
     */
    public function getSeasonEpisodes($id, $season)
    {
        $crawler = $this->request('GET', $this->baseUrl . '/title/' . $id . '/episodes?season=' . $season);
        $divs = $crawler->filterXPath('//div[contains(@class, "eplist")]/div[contains(@class, "list_item")]/div[@class="info"]');
        $episodes = array();
        foreach ($divs as $div) {
            $div = new Crawler($div);
            $number = $div->filterXPath('//meta[@itemprop="episodeNumber"]')->attr('content');
            $title = $div->filterXPath('//strong/a[@itemprop="name"]')->text();
            $airdate = $div->filterXPath('//div[@class="airdate"]')->text();
            $description = $div->filterXPath('//div[@class="item_description"]')->text();
            $episodes[$number] = array_map('trim', array(
                'title' => $title,
                'airdate' => $airdate,
                'description' => $description,
            ));
        }
        return $episodes;
    }
}
