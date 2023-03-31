<?php

namespace App\Test\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AlbumRepository $repository;
    private string $path = '/album/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Album::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Album index');

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
            'album[nom]' => 'Testing',
            'album[pochette]' => 'Testing',
            'album[entryId]' => 'Testing',
            'album[utilisateur]' => 'Testing',
            'album[dateSortie]' => 'Testing',
            'album[genre]' => 'Testing',
            'album[artiste]' => 'Testing',
        ]);

        self::assertResponseRedirects('/album/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Album();
        $fixture->setNom('My Title');
        $fixture->setPochette('My Title');
        $fixture->setEntryId('My Title');
        $fixture->setUtilisateur('My Title');
        $fixture->setDateSortie('My Title');
        $fixture->setGenre('My Title');
        $fixture->setArtiste('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Album');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Album();
        $fixture->setNom('My Title');
        $fixture->setPochette('My Title');
        $fixture->setEntryId('My Title');
        $fixture->setUtilisateur('My Title');
        $fixture->setDateSortie('My Title');
        $fixture->setGenre('My Title');
        $fixture->setArtiste('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'album[nom]' => 'Something New',
            'album[pochette]' => 'Something New',
            'album[entryId]' => 'Something New',
            'album[utilisateur]' => 'Something New',
            'album[dateSortie]' => 'Something New',
            'album[genre]' => 'Something New',
            'album[artiste]' => 'Something New',
        ]);

        self::assertResponseRedirects('/album/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPochette());
        self::assertSame('Something New', $fixture[0]->getEntryId());
        self::assertSame('Something New', $fixture[0]->getUtilisateur());
        self::assertSame('Something New', $fixture[0]->getDateSortie());
        self::assertSame('Something New', $fixture[0]->getGenre());
        self::assertSame('Something New', $fixture[0]->getArtiste());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Album();
        $fixture->setNom('My Title');
        $fixture->setPochette('My Title');
        $fixture->setEntryId('My Title');
        $fixture->setUtilisateur('My Title');
        $fixture->setDateSortie('My Title');
        $fixture->setGenre('My Title');
        $fixture->setArtiste('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/album/');
    }
}
