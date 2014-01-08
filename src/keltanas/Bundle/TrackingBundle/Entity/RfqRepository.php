<?php
/**
 *
 * @author: Nikolay Ermin <keltanas@gmail.com>
 */

namespace keltanas\Bundle\TrackingBundle\Entity;


use Doctrine\ORM\EntityRepository;

class RfqRepository extends EntityRepository
{
    public function getFindAllQuery()
    {
        $qb = $this->createQueryBuilder('r');
        return $qb->getQuery();
    }
}
