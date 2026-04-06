<?php
namespace Tests\Browser;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

class SeleniumGeneralTest extends TestCase
{
    /** @var RemoteWebDriver|null */
    protected $driver;

    public function setUp(): void
    {
        $host = getenv('SELENIUM_HOST') ?: 'http://localhost:4444/wd/hub';
        $capabilities = DesiredCapabilities::chrome();
        $this->driver = RemoteWebDriver::create($host, $capabilities, 5000);
    }

    public function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }

    public function testHomePageLoadsAndHasContent()
    {
        $base = rtrim((getenv('APP_URL') ?: 'http://localhost'), '/');
        $this->driver->get($base . '/');
        $source = $this->driver->getPageSource();
        $this->assertGreaterThan(100, strlen($source), 'Home page should return HTML content');

        // Check there are at least some links on the page
        $links = $this->driver->findElements(WebDriverBy::cssSelector('a'));
        $this->assertGreaterThanOrEqual(3, count($links), 'Expected at least 3 links on the home page');
    }

    public function testBrowseFewImportantPages()
    {
        $base = rtrim((getenv('APP_URL') ?: 'http://localhost'), '/');
        $paths = [ '/', '/login', '/catalogo', '/contacto' ];

        foreach ($paths as $p) {
            $url = $base . ($p === '/' ? '/' : $p);
            $this->driver->get($url);
            $source = $this->driver->getPageSource();
            $this->assertGreaterThan(50, strlen($source), "{$url} should return content");
            usleep(150000);
        }
    }
}
