#Bickers en Backers

Small demo app created during the Hacakalod 2018 to visualize the family relations of the 17th century Amsterdam families of Bickers and Backers and the portraits that were made of them.

The portraits are fetched through the Sparql endpoint of AdamNet where data from several cultural institutions and museums is brought together and published as Linked Open Data (lod).

Online demo: http://lab.adamlink.nl/bickers-en-backers/index.php 

## Installation

1. git clone this repository to a directory
1. In a terminal: move into your directory
1. Download Composer ```curl -sS https://getcomposer.org/installer | php```
1. Run php ```composer.phar install```

### Run scripts with built in PHP web server
Run `php -S 0.0.0.0:8888 -t index.php`. The site will be available under http://localhost:8888