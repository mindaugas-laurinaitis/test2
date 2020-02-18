<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Subscriber;
use App\Repository\SubscriberRepository;
use PHPUnit\Framework\TestCase;

class SubscriberRepositoryTest extends TestCase
{
    public function testInsert()
    {
        $subscriberRepo = new SubscriberRepository();

        $subscriber = (new Subscriber())
            ->setName('testName')
            ->setEmail('testEmail@email.com')
            ->setCategories(['someRandomCategory']);

        $subscriberRepo->insert($subscriber);

        $subscriberFromRepo = $subscriberRepo->find($subscriber->getId());

        $this->assertEquals($subscriber->getName(), $subscriberFromRepo->getName());
        $this->assertEquals($subscriber->getEmail(), $subscriberFromRepo->getEmail());
        $this->assertEquals($subscriber->getCategories(), $subscriberFromRepo->getCategories());
        $this->assertEquals($subscriber->getCreatedAt()->format('Y-m-d h:m:s'), $subscriberFromRepo->getCreatedAt()->format('Y-m-d h:m:s'));
    }
}
