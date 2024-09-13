<?php

namespace App\Tests;

use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class CharacterTest extends WebTestCase
{
    private CharacterRepository $characterRepository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient(); 

        self::bootKernel();
        $container = static::getContainer();

        $this->characterRepository = $container->get(CharacterRepository::class);
    }

    public function testHomePage(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful(); // Smoke test
        $this->assertSelectorTextContains('h1', 'Character index');
    }

    public function testHomePageContent(): void
    {

        $expectedCharacter = $this->characterRepository->findOneBy([]);

        $crawler = $this->client->request('GET', '/');

        $characterNames = $crawler->filter('.character_name')->each(function (Crawler $node, $i): string {
            return $node->text();
        });

        $this->assertContains($expectedCharacter->getName(), $characterNames);
    }

    public function testNewCharacterPage(): void
    {
        $crawler = $this->client->request('GET', '/character/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create new Character');
    }

    public function testCharacterShow(): void
    {
        //Arrange
        $character = $this->characterRepository->findOneBy([]);

        //Act
        $crawler = $this->client->request('GET', '/character/' . $character->getId());

        //Assert
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Character');

        $nameDisplayed = $crawler->filter('#char_name')->text();

        $this->assertEquals($character->getName() , $nameDisplayed);
    }

    public function testCharacterEdit(): void
    {
        //Arrange
        $character = $this->characterRepository->findOneBy([]);

        //Act
        $crawler = $this->client->request('GET', '/character/' . $character->getId() . '/edit');

        //Assert
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Edit Character');
    }
}
