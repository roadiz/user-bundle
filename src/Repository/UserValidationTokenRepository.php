<?php

declare(strict_types=1);

namespace RZ\Roadiz\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserValidationTokenRepository extends EntityRepository
{
    public function deleteAllExpired(): int
    {
        $qb = $this->createQueryBuilder('t');
        $qb->delete()
            ->andWhere($qb->expr()->lt('t.tokenValidUntil', ':now'))
            ->setParameter(':now', new \DateTime());

        return $qb->getQuery()->getResult() ?? 0;
    }
}
