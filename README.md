# A Chrome Headless wrapper for PHP

![](https://img.shields.io/github/tag/milivojsa/chrome-php.svg?style=flat)[![Build Status](https://travis-ci.org/milivojsa/chrome-php.svg?branch=master)](https://travis-ci.org/milivojsa/chrome-php) [![StyleCI](https://github.styleci.io/repos/168714310/shield?branch=master)](https://github.styleci.io/repos/168714310)

Get the DOM of any webpage by using headless Chrome. Inspired by [Browsershot](https://github.com/spatie/browsershot).

## Requirements

This package requires the [Puppeteer Chrome Headless Node library](https://github.com/GoogleChrome/puppeteer).
If you want to install it on Ubuntu 16.04 you can do it like this:
```bash
sudo apt-get update
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
sudo apt-get install -y nodejs gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget
sudo npm install --global --unsafe-perm puppeteer
sudo chmod -R o+rx /usr/lib/node_modules/puppeteer/.local-chromium
```
## Installation

To add this package to your project, you can install it via composer by running

```bash
composer require milivojsa/chrome-php
```

## Usage

Here is a quick example how to use this package:

```php
use ChromeHeadless\ChromeHeadless;

$html = ChromeHeadless::url('https://example.com')->getHtml();
```

Instead of getting the DOM as a string, you can also use the`getDOMCrawler()` method, which will return a `Symfony\Component\DomCrawler\Crawler` instance.

```php
use ChromeHeadless\ChromeHeadless;

$dom = ChromeHeadless::url('https://example.com')->getDOMCrawler();
    
$title = $dom->filter('title')->text();
```

This makes it easy to filter the DOM for specific elements. Check the full documentation [here](https://symfony.com/doc/current/components/dom_crawler.html).

### Timeout

You can specify a timeout after which the process will be killed. The timeout should be given in seconds.

````````````php
ChromeHeadless::url('https://example.com')
                ->setTimeout(10)
                ->getDOMCrawler();
````````````

If the process runs out of time a `Symfony\Component\Process\Exception\ProcessTimedOutException` will be thrown.

### Custom Chrome Path

You can specify a custom path to your Chrome installation.

```php
ChromeHeadless::url('https://example.com')
                ->setChromePath('/path/to/chrome')
                ->getDOMCrawler();
```

### Custom User Agent

You can specify a custom user agent. By default the standard Chrome Headless user agent will be used.

```php
ChromeHeadless::url('https://example.com')
                ->setUserAgent('nice-user-agent')
                ->getDOMCrawler();
```

### Custom Headers

You can specify custom headers which will be used for the request. 

```php
ChromeHeadless::url('https://example.com')
                ->setHeaders([
                    'DNT' => 1 // DO NOT TRACK
                ])
                ->getDOMCrawler();
```

### Blacklist

You can specify a list of regular expressions for files that should not be loaded when you request a website. These expressions will be checked against the url of the file. Default behaviour of the method `setBlacklist(array $blacklist, $clean = false)` is to merge array passed as `$blacklist` with current `blacklist` property. If you want to override this default behaviour then you can set parameter `$clean` to be `true`.

```php
ChromeHeadless::url('https://example.com')
                ->setBlacklist([
                    'www.example.com'
                ])
                ->setBlacklist([
                    'www.google-analytics.com',
                    'analytics.js'
                ]) // property blacklist now will have www.example.com and those two
                ->getDOMCrawler();
```

```php
ChromeHeadless::url('https://example.com')
                ->setBlacklist([
                    'www.google-analytics.com',
                    'analytics.js'
                ])
                ->setBlacklist([
                    'www.example.com'
                ], true) // property blacklist now will only have www.example.com 
                ->getDOMCrawler();
```

### Excluded

You can specify a list of resource types  that should not be loaded when you request a website. These resource types will be checked against the resource type of the file. You can pass values: `document, stylesheet, image, media, font and script.` Default behaviour of the method `setExcluded(array $excluded, $clean = false)` is to merge array passed as `$excluded` with current `excluded` property. If you want to override this default behaviour then you can set parameter `$clean` to be `true`.

```php
ChromeHeadless::url('https://example.com')
                ->setExcluded([
                    'document'
                ])
                ->setExcluded([
                    'stylesheet',
                    'image'
                ]) // property excluded now will only have document and those two
                ->getDOMCrawler();
```

```php
ChromeHeadless::url('https://example.com')
                ->setExcluded([
                    'stylesheet'
                    'image'
                ]) 
                ->setExcluded([
                    'document'
                ], true) // property excluded now will only have only document
                ->getDOMCrawler();
```

### Viewport

You can specify a custom viewport that will be used when you make a request. By default the Chrome Headless standard of 800x600px will be used.

```php
ChromeHeadless::url('https://example.com')
                ->setViewport([
                    'width' => 1920,
                    'height' => 1080
                ])
                ->getDOMCrawler();
```

## Testing

You can run the tests by using

```bash
composer test
```
