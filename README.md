# bluelyte/imdb-client

A scraper for IMDB based on Symfony components.

DISCLAIMER: This project is not endorsed by, affiliated with, or intended to infringe upon IMDB and is meant for non-commercial purposes (i.e. personal use) only.

# Install

The recommended method of installation is [through composer](http://getcomposer.org/).

```JSON
{
    "require": {
        "bluelyte/imdb-client": "1.0.0"
    }
}
```

# Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \Bluelyte\IMDB\Client\Client();

// Numb3rs - http://www.imdb.com/title/tt0433309/
$id = 'tt0433309';

$showInfo = $client->getShowInfo($id);
$episodes = $client->getSeasonEpisodes($id, $showInfo['lastSeason']);
var_dump($episodes);

/*
Output:
array(16) {
  [1] =>
  array(3) {
    'title' =>
    string(7) "Hangman"
    'airdate' =>
    string(10) "2009-09-25"
    'description' =>
    string(126) "The team tries to protect an activist from a sniper, while Charlie and Amita try to keep his proposal and her answer a secret."
  }
  [2] =>
  array(3) {
    'title' =>
    string(13) "Friendly Fire"
    'airdate' =>
    string(10) "2009-10-02"
    'description' =>
    string(156) "Charlie and the team investigate a shootout involving a bank robber, but when the science doesn't match the stories suspicion falls on one of Don's mentors."
  }
  ...
}
*/
```

## License

Released under the BSD License. See `LICENSE`.
