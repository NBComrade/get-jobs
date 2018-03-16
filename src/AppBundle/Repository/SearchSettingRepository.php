<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SearchSettingRepository extends EntityRepository
{
    public function getById($id)
    {
        return $this->createQueryBuilder('ss')
        ->andWhere('ss.id = :id')
        ->setParameter(':id', $id)
        ->getQuery()
        ->getOneOrNullResult();
    }
    public function getDomainWithQuery($id)
    {
        $setting = $this->getById($id);
        if (empty($setting)) {
            throw new \DomainException("There are not enabled parsing-settings!");
        }
        return $setting->getDomain() . $setting->getPattern();
    }
}
