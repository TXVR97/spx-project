<?php

namespace App\Test\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartnerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PartnerRepository $repository;
    private string $path = '/partner/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Partner::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Partner index');

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
            'partner[name]' => 'Testing',
            'partner[Status]' => 'Testing',
            'partner[description]' => 'Testing',
            'partner[ComContact]' => 'Testing',
            'partner[website]' => 'Testing',
            'partner[ManageContact]' => 'Testing',
            'partner[City]' => 'Testing',
            'partner[image]' => 'Testing',
            'partner[CreatedAt]' => 'Testing',
            'partner[slug]' => 'Testing',
        ]);

        self::assertResponseRedirects('/partner/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Partner();
        $fixture->setName('My Title');
        $fixture->setStatus('My Title');
        $fixture->setDescription('My Title');
        $fixture->setComContact('My Title');
        $fixture->setWebsite('My Title');
        $fixture->setManageContact('My Title');
        $fixture->setCity('My Title');
        $fixture->setImage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSlug('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Partner');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Partner();
        $fixture->setName('My Title');
        $fixture->setStatus('My Title');
        $fixture->setDescription('My Title');
        $fixture->setComContact('My Title');
        $fixture->setWebsite('My Title');
        $fixture->setManageContact('My Title');
        $fixture->setCity('My Title');
        $fixture->setImage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSlug('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'partner[name]' => 'Something New',
            'partner[Status]' => 'Something New',
            'partner[description]' => 'Something New',
            'partner[ComContact]' => 'Something New',
            'partner[website]' => 'Something New',
            'partner[ManageContact]' => 'Something New',
            'partner[City]' => 'Something New',
            'partner[image]' => 'Something New',
            'partner[CreatedAt]' => 'Something New',
            'partner[slug]' => 'Something New',
        ]);

        self::assertResponseRedirects('/partner/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getComContact());
        self::assertSame('Something New', $fixture[0]->getWebsite());
        self::assertSame('Something New', $fixture[0]->getManageContact());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Partner();
        $fixture->setName('My Title');
        $fixture->setStatus('My Title');
        $fixture->setDescription('My Title');
        $fixture->setComContact('My Title');
        $fixture->setWebsite('My Title');
        $fixture->setManageContact('My Title');
        $fixture->setCity('My Title');
        $fixture->setImage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSlug('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/partner/');
    }
}
