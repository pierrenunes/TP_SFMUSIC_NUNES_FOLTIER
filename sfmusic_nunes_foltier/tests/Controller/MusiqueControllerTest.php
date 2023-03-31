<?php

namespace App\Test\Controller;

use App\Entity\Musique;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MusiqueControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MusiqueRepository $repository;
    private string $path = '/musique/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Musique::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Musique index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'musique[Nom]' => 'Testing',
            'musique[Genre]' => 'Testing',
            'musique[dateSortie]' => 'Testing',
            'musique[genre]' => 'Testing',
            'musique[artiste]' => 'Testing',
            'musique[playlists]' => 'Testing',
        ]);

        self::assertResponseRedirects('/musique/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Musique();
        $fixture->setNom('My Title');
        $fixture->setGenre('My Title');
        $fixture->setDateSortie('My Title');
        $fixture->setGenre('My Title');
        $fixture->setArtiste('My Title');
        $fixture->setPlaylists('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Musique');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Musique();
        $fixture->setNom('My Title');
        $fixture->setGenre('My Title');
        $fixture->setDateSortie('My Title');
        $fixture->setGenre('My Title');
        $fixture->setArtiste('My Title');
        $fixture->setPlaylists('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'musique[Nom]' => 'Something New',
            'musique[Genre]' => 'Something New',
            'musique[dateSortie]' => 'Something New',
            'musique[genre]' => 'Something New',
            'musique[artiste]' => 'Something New',
            'musique[playlists]' => 'Something New',
        ]);

        self::assertResponseRedirects('/musique/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getGenre());
        self::assertSame('Something New', $fixture[0]->getDateSortie());
        self::assertSame('Something New', $fixture[0]->getGenre());
        self::assertSame('Something New', $fixture[0]->getArtiste());
        self::assertSame('Something New', $fixture[0]->getPlaylists());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Musique();
        $fixture->setNom('My Title');
        $fixture->setGenre('My Title');
        $fixture->setDateSortie('My Title');
        $fixture->setGenre('My Title');
        $fixture->setArtiste('My Title');
        $fixture->setPlaylists('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/musique/');
    }
}
