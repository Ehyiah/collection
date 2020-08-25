<?php

namespace App\Helper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;

final class UuidGenerator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity): string
    {
        return Uuid::v4();
    }
}
