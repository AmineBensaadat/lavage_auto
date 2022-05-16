<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PdmOilsDistributorVolume
 *
 * @ORM\Table(name="pdm_oils_distributor_volume")
 * @ORM\Entity(repositoryClass="App\Repository\PdmOilsDistributorVolumeRepository")
 */
class PdmOilsDistributorVolume
{
        const TYPE_NAME = 'OILS';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="price_liter", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceLiter;

    /**
     * @var float
     *
     * @ORM\Column(name="price_ht", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceHt;

        /**
     * @var float
     *
     * @ORM\Column(name="price_import", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceImport;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @var string
     *
     * @ORM\Column(name="distributor_code", type="string", length=50, nullable=true)
     */
    private $distributorCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="created_by", type="string", length=50, nullable=true)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_by", type="string", length=50, nullable=true)
     */
    private $updatedBy;

    /**
     * @var bool
     *
     * @ORM\Column(name="update_es", type="boolean", nullable=true, options={"default": true})
     */
    private $updateEs = 1;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return PdmOilsDistributorVolume
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return PdmOilsDistributor
     */
    public function getPdmOilsDistributor()
    {
        return $this->pdmOilsDistributor;
    }
    /**
     * @return OilsVolume
     */
    public function getPdmOilsVolume()
    {
        return $this->pdmOilsVolume;
    }

    /**
     * @return float
     */
    public function getPriceLiter()
    {
        return $this->priceLiter;
    }

    /**
     * @param float $priceLiter
     *
     * @return PdmOilsDistributorVolume
     */
    public function setPriceLiter($priceLiter)
    {
        $this->priceLiter = $priceLiter;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceHt()
    {
        return $this->priceHt;
    }

    /**
     * @param float $priceHt
     *
     * @return PdmOilsDistributorVolume
     */
    public function setPriceHt($priceHt)
    {
        $this->priceHt = $priceHt;

        return $this;
    }


    /**
     * @return float
     */
    public function getPriceImport()
    {
        return $this->priceImport;
    }

    /**
     * @param float $priceImport
     * @return PdmOilsDistributorVolume
     */
    public function setPriceImport($priceImport)
    {
        $this->priceImport = $priceImport;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return PdmOilsDistributorVolume
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     *
     * @return PdmOilsDistributorVolume
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistributorCode()
    {
        return $this->distributorCode;
    }

    /**
     * @param string $distributorCode
     *
     * @return PdmOilsDistributorVolume
     */
    public function setDistributorCode($distributorCode)
    {
        $this->distributorCode = $distributorCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return PdmOilsDistributorVolume
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return PdmOilsDistributorVolume
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     *
     * @return PdmOilsDistributorVolume
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return PdmOilsDistributorVolume
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param string $updatedBy
     *
     * @return PdmOilsDistributorVolume
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUpdateEs(): bool
    {
        return $this->updateEs;
    }

    /**
     * @param bool $updateEs
     *
     * @return PdmOilsDistributorVolume
     */
    public function setUpdateEs(bool $updateEs): PdmOilsDistributorVolume
    {
        $this->updateEs = $updateEs;

        return $this;
    }

    /**
     * Get Distributor by PdmOilsDistributor
     * @return mixed Distributor|null
     */
    public function getDistributor()
    {
        return $this->pdmOilsDistributor->getDistributor();
    }

    /**
     * Get pdm oils product by PdmOilsDistributor
     * @return PdmOilsProduct
     */
    public function getProduct()
    {
        return $this->pdmOilsDistributor->getProduct();
    }
}
