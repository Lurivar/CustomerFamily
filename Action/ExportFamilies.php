<?php

namespace CustomerFamily\Action;


use CustomerFamily\Model\CustomerCustomerFamilyQuery;
use CustomerFamily\Model\Map\CustomerCustomerFamilyTableMap;
use CustomerFamily\Model\Map\CustomerFamilyTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\ExportEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Serializer\Serializer\CSVSerializer;
use Thelia\ImportExport\Export\AbstractExport;
use Thelia\Model\Lang;
use Thelia\Model\Map\CustomerTableMap;
use Thelia\Model\Product;

class ExportFamilies extends AbstractExport implements EventSubscriberInterface
{

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::EXPORT_BEGIN => [
                ['setDelimiter', 128]
            ]
        ];
    }

    public function setDelimiter(ExportEvent $exportEvent)
    {
        if (get_class($exportEvent->getExport()) === __CLASS__
            && $exportEvent->getSerializer() instanceof CSVSerializer
        ) {
            /** @var CSVSerializer $serializer */
            $serializer = $exportEvent->getSerializer();
            $serializer->setDelimiter(';');
            $exportEvent->setSerializer($serializer);
        }
    }

    /**
     * @return array|\Propel\Runtime\ActiveQuery\ModelCriteria
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getData()
    {
        return $this->getQuery()->find()->toArray();
    }

    public function getQuery()
    {
        $a_join = new Join(CustomerCustomerFamilyTableMap::CUSTOMER_ID,CustomerTableMap::ID,Criteria::INNER_JOIN);
        $b_join = new Join(CustomerCustomerFamilyTableMap::CUSTOMER_FAMILY_ID,CustomerFamilyTableMap::ID,Criteria::INNER_JOIN);

        $query = CustomerCustomerFamilyQuery::create()
            ->addJoinObject($a_join, "a_join")
            ->addJoinObject($b_join, "b_join")

            ->select([
            "customer_firstname",
            "customer_lastname",
            "customer_mail",
            "customer_family_code"
        ])

            ->addAsColumn("customer_firstname", CustomerTableMap::FIRSTNAME)
            ->addAsColumn("customer_lastname", CustomerTableMap::LASTNAME)
            ->addAsColumn("customer_mail", CustomerTableMap::EMAIL)
            ->addAsColumn("customer_family_code", CustomerFamilyTableMap::CODE)
            ;

        return $query;
    }
}