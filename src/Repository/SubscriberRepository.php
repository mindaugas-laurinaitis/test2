<?php

namespace App\Repository;


use App\Entity\Subscriber;

class SubscriberRepository extends AbstractRepository
{

    protected function getTargetEntity(): string
    {
        return Subscriber::class;
    }
}
