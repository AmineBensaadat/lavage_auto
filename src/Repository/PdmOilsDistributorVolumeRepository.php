<?php

namespace App\Repository;

// use BackZr\DBBundle\Entity\{
//     PdmOilsProductDocumentation, PdmOilsProductVolume
// };
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
//use Zr\SearchBundle\Service\Oil\OilParams;

/**
 *
 */
class PdmOilsDistributorVolumeRepository extends EntityRepository
{

    /**
     * search oils by filters
     *
     * @param array $aFilters
     *
     * @return \Doctrine\ORM\Query
     * @throws ORMException
     */
    public function searchOilsByFilters($aFilters = [], $isDistributor = false)
    {
        $parameters = [];
        $aWhere = [];
        $dql = <<<DQL
        SELECT
            o.id as id,
            p.id as productId,
            p.designation as designation,
            MIN(o.priceLiter) as priceLiter,
            o.quantity as quantity,
            o.priceHt as priceHt,
            d.id as distributorId,
            d.company as distributorCompany,
            d.commercialName as commercialName,
            d.premium as distributorPremium,
            d.oilsThresholdAmountHt as distributorOilsThresholdAmountHt,
            cnt.name as DisrtibutorCountryName,
            cnt.isoCode as DisrtibutorCountryIsoCode,
            pb.id as brandId,
            pb.name as brandName,
            pcat.id as categoryId,
            pcat.traductionKey as categoryTranslationKey,
            pscat.id as subCategoryId,
            pscat.traductionKey as subCategoryTranslationKey,
            pvis.id as viscosityId,
            pvis.name as viscosityName,
            pov.label as libelleVolume,
            norm.id as normId,
            norm.name as normName,
            SUM(o.quantity) as totalQuantity,
            COUNT(DISTINCT d.id) as totalDistributor
        FROM BackZrDBBundle:PdmOilsDistributorVolume o
            LEFT JOIN o.pdmOilsDistributor pod
            LEFT JOIN o.pdmOilsVolume pov
            LEFT JOIN pod.product p
            LEFT JOIN pod.distributor d
            LEFT JOIN p.pdmOilsViscosity pvis
            LEFT JOIN p.pdmOilsCategorySub pscat
            LEFT JOIN pscat.oilsCategory pcat
            LEFT JOIN p.brand pb
            LEFT JOIN d.address addr
            LEFT JOIN addr.country cnt
            LEFT JOIN d.paymentModeMain dpm
            LEFT JOIN d.paymentModeSecondary dps
            LEFT JOIN d.paymentModeOther dpo
            LEFT JOIN p.oilsNorm norm
        WHERE pcat.status = 1
            AND pscat.status = 1
            AND o.enabled = 1
            AND o.priceHt > 0
            AND o.priceLiter > 0
            AND pb.status = 1
            AND pvis.status = 1
            AND pov.status = 1
            AND pod.enabled = 1
            AND p.status = 1
            AND d.target = :country
            AND (pod.deleted != 1 OR pod.deleted IS NULL)
            AND (o.deleted != 1 OR o.deleted IS NULL)
            AND o.quantity > 0
            AND (SELECT COUNT(opv.id) FROM BackZrDBBundle:PdmOilsProductVolume opv WHERE opv.pdmOilsProduct=p AND opv.pdmOilsVolume=pov AND opv.status=1) > 0
            AND (SELECT COUNT(cc.id) FROM BackZrDBBundle:OilsCategoryCountry cc WHERE cc.country = :isoCode AND cc.isActivate = 1 AND cc.oilsCategory = pcat )>0
            AND (SELECT COUNT(csc.id) FROM BackZrDBBundle:OilsCategorySubCountry csc WHERE csc.country = :isoCode AND csc.isActivate = 1 AND csc.oilsCategorySub = pscat)>0 
            AND d.id IN (:idsDistributorByZipcode)
            AND (dpm.id > 0 OR dps.id > 0 OR dpo.id > 0)
DQL;
        $parameters["country"] = $aFilters[OilParams::KEY_TARGET];
        $parameters["isoCode"] = $aFilters[OilParams::KEY_ISOCODE];

        if ($aFilters['isCustomerAtRisk'] || ($aFilters['isNewCustomer'])) {
            $aWhere[] = " d.id IN (:distributorIdForPaymentRisk) ";
            $parameters["distributorIdForPaymentRisk"] = $aFilters[OilParams::KEY_DIST_PAYMENT_RISK];
        }

        $parameters["idsDistributorByZipcode"] = $aFilters[OilParams::KEY_DIST_BY_ZIPCODE] ?: 0;

        if ($aFilters['isNtvaFilterInvalid']) {
            $aWhere[] = "cnt.id = :country";
        }
        if (!empty($aFilters[OilParams::KEY_SUB_CATEGORY]) && $aFilters[OilParams::KEY_SUB_CATEGORY] != 'null') {
            $aWhere[] = "pscat.id = :subCategory";
            $parameters["subCategory"] = $aFilters["subCategory"];
        }
        if (!empty($aFilters[OilParams::KEY_CATEGORY]) && $aFilters[OilParams::KEY_CATEGORY] != 'null') {
            $aWhere[] = "pcat.id = :category";
            $parameters["category"] = $aFilters[OilParams::KEY_CATEGORY];
        }
        if (!empty($aFilters[OilParams::KEY_BRAND_ID]) && $aFilters[OilParams::KEY_BRAND_ID] != 'null') {
            $aWhere[] = "pb.id IN (:brands)";
            $parameters["brands"] = $aFilters[OilParams::KEY_BRAND_ID];
        }
        if (!empty($aFilters["viscosity"]) && !in_array($aFilters["viscosity"], ['null', 'undefined'])) {
            if (!is_array($aFilters['viscosity'])) {
                $aViscosity = explode("__", $aFilters["viscosity"]);
            } else {
                $aViscosity = $aFilters['viscosity'];
            }
            $aWhere[] = "pvis.id IN (:viscosity)";
            $parameters["viscosity"] = $aViscosity;
        }
        if (array_key_exists("productId", $aFilters)) {
            $aWhere[] = "p.id = :productId";
            $parameters["productId"] = $aFilters["productId"];
        }

        if (array_key_exists("norm", $aFilters)
            && !empty($aFilters["norm"]) && $aFilters["norm"] != "null" && $aFilters['norm'] != 'undefined') {
            if (!is_array($aFilters['norm'])) {
                $aNorms = explode("__", $aFilters["norm"]);
            } else {
                $aNorms = $aFilters['norm'];
            }
            $aWhere[] = "norm.id IN (:normids)";
            $parameters["normids"] = $aNorms;
        }

        if (!empty($aWhere)) {
            $dql .= ' AND '.implode(' AND ', $aWhere);
        }
        if (!$isDistributor) {

            $dql .= ' GROUP BY p.id';
        } else {
            $dql .= ' GROUP BY d.id';
        }
        if (array_key_exists("sortByPriceLiter", $aFilters) && $aFilters["sortByPriceLiter"] == "DESC") {
            $dql .= ' ORDER BY priceLiter DESC';
        } else {
            $dql .= ' ORDER BY priceLiter ASC';
        }

        return $this->_em->createQuery($dql)->setParameters($parameters);
    }

    public function getListOfOils(string $term, int $distributorId)
    {
        if ($term == 'all') {
            $dql = <<<DQL
            SELECT p.id, p.designation as name
            FROM BackZrDBBundle:PdmOilsDistributorVolume as odv
              JOIN odv.pdmOilsDistributor od
              JOIN od.distributor as d
              JOIN od.product as p
            WHERE d.id = :distributor
DQL;

            $products = $this->_em->createQuery($dql)
                ->setParameter('distributor', $distributorId)
                ->setMaxResults(5)
                ->getResult();
        } else {
            $dql = <<<DQL
            SELECT p.id, p.designation as name
            FROM BackZrDBBundle:PdmOilsDistributorVolume as odv
              JOIN odv.pdmOilsDistributor as od
              JOIN od.distributor as d
              JOIN od.product as p
            WHERE odv.enabled = 1
              AND od.enabled=1
              AND p.status=1
              AND p.designation LIKE :term
              AND d.id = :distributor
DQL;

            $products = $this->_em->createQuery($dql)
                ->setParameter('term', '%' . $term . '%')
                ->setParameter('distributor', $distributorId)
                ->setMaxResults(5)
                ->getResult();
        }

        return $products;
    }

    public function getOilsVolumeByDistributor($aIdDistributors, $productId)
    {
        return $this->createQueryBuilder('o')
            ->select(
                [
                    'o.id as id',
                    'distributor.id as idfrs',
                    "$productId as productId",
                    'oils_volume.label as libelleVolume',
                    'o.priceLiter as priceLiter',
                    'o.priceHt as priceHt',
                ]
            )
            ->innerJoin('o.pdmOilsDistributor', 'pdm_oils_distributor')
            ->innerJoin('pdm_oils_distributor.distributor', 'distributor')
            ->innerJoin(
                PdmOilsProductVolume::class,
                'pdm_oils_product_volume',
                Join::WITH,
                'pdm_oils_product_volume.pdmOilsProduct = pdm_oils_distributor.product'
            )
            ->innerJoin('pdm_oils_product_volume.pdmOilsVolume', 'oils_volume')
            ->where('distributor.id IN (:distributorIds)')
            ->andWhere('pdm_oils_distributor.product = :productId')
            ->andWhere('o.enabled = 1')
            ->andWhere('o.deleted = 0')
            ->andWhere('o.quantity > 0')
            ->andWhere('o.priceHt > 0')
            ->andWhere('o.priceLiter > 0')
            ->andWhere('pdm_oils_distributor.enabled = 1')
            ->andWhere('pdm_oils_distributor.deleted = 0')
            ->andWhere('pdm_oils_product_volume.status = 1')
            ->groupBy('o.id')
            ->setParameters(['productId' => $productId, 'distributorIds' => $aIdDistributors])
            ->getQuery()
            ->getResult();
    }

    /**
     * Update the volume of the products distributor volume
     * @param $oldVolume
     * @param $newVolume
     * @param $pdmOilsProduct
     */
     public function updateAllPdmOilsDistributorVolume($oldVolume,$newVolume,$pdmOilsProduct)
     {
         $sql = <<<SQL
          UPDATE pdm_oils_distributor_volume 
          SET oils_volume_id =:oilsvolumeid
          WHERE oils_volume_id =:oldoilsvolumeid
          AND pdm_oils_distributor_id 
          IN (
            SELECT id FROM pdm_oils_distributor pod
            WHERE pod.pdm_oils_product_id = :oilsproductid
          )
SQL;

         $con = $this->_em->getConnection();
         $stmt = $con->prepare($sql);
         $stmt->bindValue('oilsvolumeid', $newVolume->getId());
         $stmt->bindValue('oldoilsvolumeid', $oldVolume->getId());
         $stmt->bindValue('oilsproductid', $pdmOilsProduct->getId());
         $stmt->execute();
     }

    /**
     * search result lubricant by norm
     *
     * @param array $data
     * @param array $normIds
     * @return array
     */
    public function searchIntoResultByNorm(array $data, array $normIds = [])
    {
        $res = [];
        foreach ($data as $value) {
            $dql = <<<DQL
            SELECT o.name
            FROM BackZrDBBundle:OilsNorm o
            WHERE o.pdmOilsProduct =:id
            AND o.name IN (:norm)
DQL;
            $params = array('id' => $value["productId"], 'norm' => $this->getNormById($normIds));
            $query = $this->_em->createQuery($dql)->setParameters($params);
            $result = $query->getResult();
            $strNorm = "";
            foreach ($result as $name) {
                $strNorm = $strNorm.$name["name"]." ";
            }
            if (count($result) > 0) {
                $value["norm"] = $strNorm;
                array_push($res, $value);
            }
        }
        return $res;
    }

    public function getNormById($id)
    {
        $dql = <<<DQL
            SELECT o.name
            FROM BackZrDBBundle:OilsNorm o
            WHERE o.id IN(:id)
DQL;
        $query = $this->_em->createQuery($dql)->setParameter('id', $id);
        $result = $query->getResult();
        $formatResult = [];
        foreach ($result as $value) {
            array_push($formatResult, $value["name"]);
        }
        return $formatResult;
    }

    /**
     * @param int    $id
     * @param string $isoCode
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCorrespondenceItemZoho(int $id)
    {
        return $this->createQueryBuilder('pdm_oils_distributor_volume')
            ->select(
                [
                    'CONCAT(
                        IF(brand.name IS NULL, \'\', brand.name),
                        \' \',
                        IF(pdm_oils_product_documentation.label IS NULL, \'\', pdm_oils_product_documentation.label),
                        \'_\',
                        pdm_oils_distributor_volume.id
                    ) AS name',
                    'pdm_oils_distributor_volume.priceHt AS rate',
                    'pdm_oils_volume.label AS description',
                    'CONCAT(\'OIL_\',pdm_oils_distributor_volume.id) AS sku',
                    'CONCAT(
                        product.id,
                        \'_\',
                        IF(
                            pdm_oils_distributor_volume.distributorCode IS NULL,
                            \'\', 
                            pdm_oils_distributor_volume.distributorCode
                        )
                    ) AS purchase_description',
                    'distributor.id AS vendor_id'
                ]
            )
            ->innerJoin('pdm_oils_distributor_volume.pdmOilsDistributor', 'pdm_oils_distributor')
            ->innerJoin('pdm_oils_distributor_volume.pdmOilsVolume', 'pdm_oils_volume')
            ->innerJoin('pdm_oils_distributor.distributor', 'distributor')
            ->innerJoin('distributor.target', 'target')
            ->innerJoin('pdm_oils_distributor.product', 'product')
            ->innerJoin('product.brand', 'brand')
            ->leftJoin(
                PdmOilsProductDocumentation::class,
                'pdm_oils_product_documentation',
                Join::WITH,
                'pdm_oils_product_documentation.productId = pdm_oils_distributor.product 
                AND LOWER(target.isoCode) = LOWER(pdm_oils_product_documentation.local)'
            )
            ->where('pdm_oils_distributor_volume.id = :id')
            ->setParameters(['id' => $id])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
