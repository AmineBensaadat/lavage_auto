<?php

/**
 *  This file is part of the DBB Bundle.
 *
 * @copyright Copyright (c) 2012 - 2013
 */

namespace App\FrontZr\DBBundle\Entity;

use Doctrine\Common\Collections\{
    Collection, ArrayCollection
};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * App\FrontZr\DBBundle\Entity\Distributor
 *
 * @ORM\Table(name="distributor")
 * @ORM\Entity(repositoryClass="App\FrontZr\DBBundle\Repository\DistributorRepository")
 */
class Distributor implements UserInterface, \Serializable
{
    /* -----battery sale conditions status----- */
    const FIVE_CONDITION = 1;
    const CART_THRESHOLD = 2;
    const MIN_QUANTITY = 3;

    /* ---------------------------------------- */
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var boolean $deleted
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @var string $company
     * @Assert\NotBlank()
     * @ORM\Column(name="company", type="string", length=128, nullable=true)
     */
    private $company;

    /**
     * @var string $companyInvoicingName
     * @Assert\NotBlank(groups={"edit"})
     * @ORM\Column(name="company_invoicing_name", type="string", length=128, nullable=false)
     */
    private $companyInvoicingName;

    /**
     * @var integer $parentId
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var integer $parentId
     *
     * @ORM\Column(name="accept_deal", type="boolean", nullable=true)
     */
    private $acceptDeal;

    /**
     * @var integer $billParentId
     *
     * @ORM\Column(name="bill_parent_id", type="integer",length=11, nullable=true)
     */
    private $billParentId;

    /**
     * @var string $ftpLogin
     * @ORM\Column(name="ftp_login", type="string", length=64, nullable=true)
     */
    private $ftpLogin;

    /**
     * @var string $password
     * @Assert\NotBlank(groups={"password"})
     * @ORM\Column(name="password", type="string", length=128, nullable=true)
     */
    private $password;

    /**
     * @var string $description
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @var string $juridicalForm
     * @ORM\Column(name="juridical_form", type="string", length=64, nullable=true)
     */
    private $juridicalForm;

    /**
     * @var string $siretNumber
     * @Assert\NotBlank()
     * @ORM\Column(name="siret_number", type="string", length=45, nullable=true)
     */
    private $siretNumber;

    /**
     * @var string $tvaNumber
     * @Assert\NotBlank()
     * @ORM\Column(name="tva_number", type="string", length=45, nullable=true)
     */
    private $tvaNumber;

    /**
     * @var integer $maxContact
     *
     * @ORM\Column(name="max_contact", type="integer", nullable=true)
     */
    private $maxContact;

    /**
     * Id of Markup Spare Part Type
     * @ORM\Column(name="markup_sparepart_type", type="integer", nullable=true)
     */
    private $markupSparepartType;

    /**
     * @var string $language1
     *
     * @ORM\Column(name="language1", type="string", length=2, nullable=true)
     */
    private $language1;

    /**
     * @var string $language2
     *
     * @ORM\Column(name="language2", type="string", length=2, nullable=true)
     */
    private $language2;

    /**
     * @var string $language3
     *
     * @ORM\Column(name="language3", type="string", length=2, nullable=true)
     */
    private $language3;

    /**
     * @var integer $increaseType
     *
     * @ORM\Column(name="increase_type", type="integer", nullable=true)
     */
    private $increaseType;

    /**
     * @var Country
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="target", referencedColumnName="id")
     * })
     */
    private $target;

    /**
     * @var DistributorGroup
     * @ORM\ManyToOne(targetEntity="DistributorGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="distributor_group_id", referencedColumnName="id")
     * })
     */
    private $distributorGroup;

    /**
     * @var string $paymentDelay ;
     *
     * @ORM\Column(name="payment_delay", type="integer", nullable=true)
     */
    private $paymentDelay;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_mode_main", referencedColumnName="id")
     * })
     */
    private $paymentModeMain;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_mode_secondary", referencedColumnName="id")
     * })
     */
    private $paymentModeSecondary;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_mode_other", referencedColumnName="id")
     * })
     */
    private $paymentModeOther;

    /**
     * @var boolean $allowChangeDeliveryAddress
     *
     * @ORM\Column(name="allow_change_delivery_address", type="boolean", nullable=true)
     */
    private $allowChangeDeliveryAddress;

    /**
     * @var boolean $allowDeleteStock
     *
     * @ORM\Column(name="allow_delete_stock", type="boolean", nullable=true)
     */
    private $allowDeleteStock;

    /**
     * @var boolean $finical
     *
     * @ORM\Column(name="finical", type="boolean", nullable=true)
     */
    private $finical;

    /**
     * @var boolean $payCollect
     *
     * @ORM\Column(name="pay_collect", type="boolean", nullable=true)
     */
    private $payCollect;

    /**
     * @var integer $minToCollect
     *
     * @ORM\Column(name="min_to_collect", type="integer", nullable=true)
     */
    private $minToCollect;

    /**
     * @var Concurrence[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="Concurrence", inversedBy="distributor")
     * @ORM\JoinTable(name="distributor_concurrence",
     *   joinColumns={
     *     @ORM\JoinColumn(name="distributor_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="concurrence_id", referencedColumnName="id")
     *   }
     * )
     */
    private $concurrence;

    /**
     * @var Plateform[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="Plateform", inversedBy="distributor")
     * @ORM\JoinTable(name="distributor_plateform",
     *   joinColumns={
     *     @ORM\JoinColumn(name="distributor_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="plateform_id", referencedColumnName="id")
     *   }
     * )
     */
    private $plateform;

    /**
     * @var Category[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="distributor")
     * @ORM\JoinTable(name="category_distributor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="distributor_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_category", referencedColumnName="id")
     *   }
     * )
     */
    private $category;

    /**
     * @var Market[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="Market", inversedBy="distributor")
     * @ORM\JoinTable(name="distributor_market",
     *   joinColumns={
     *     @ORM\JoinColumn(name="distributor_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="market_id", referencedColumnName="id")
     *   }
     * )
     */
    private $market;

    /**
     * @var integer $billingAmountIndex
     *
     * @ORM\Column(name="billing_amount_index", type="integer", nullable=true)
     */
    private $billingAmountIndex;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string $createdBy
     *
     * @ORM\Column(name="created_by", type="string", length=64, nullable=true)
     */
    private $createdBy;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string $updatedBy
     *
     * @ORM\Column(name="updated_by", type="string", length=64, nullable=true)
     */
    private $updatedBy;

    /**
     * @var float $billingAmount
     *
     * @ORM\Column(name="billing_amount", type="float", nullable=true)
     */
    private $billingAmount;

    /**
     * @var \DateTime $lastConnexion
     *
     * @ORM\Column(name="last_connexion", type="datetime", nullable=true)
     */
    private $lastConnexion;

    /**
     * @var Collection|Orders[]
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="distributor")
     */
    private $orders;

    /**
     * @var ProductDistributor[]|Collection
     * @ORM\OneToMany(targetEntity="ProductDistributor", mappedBy="distributor")
     */
    private $productdistributor;

    /**
     * @var Cutoff[]|Collection
     * @ORM\OneToMany(targetEntity="Cutoff", mappedBy="distributor")
     */
    private $cutOff;

    /**
     * @var Collector
     *
     * @ORM\ManyToOne(targetEntity="Collector")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="collector_id", referencedColumnName="id")
     * })
     */
    private $collector;

    /**
     * @var Stock[]|Collection
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="distributor")
     */
    private $stocks;

    /**
     * @var Prospect[]|Collection
     *
     * @ORM\ManyToMany(targetEntity="Prospect", mappedBy="distributor")
     */
    private $prospect;

    /**
     * @var Distributor
     *
     * @ORM\ManyToOne(targetEntity="Distributor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var Agent
     *
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     * })
     */
    private $agent;

    /**
     * @ORM\OneToOne(targetEntity="Address", mappedBy="distributor", cascade={"persist"})
     * @Assert\Type(type="App\FrontZr\DBBundle\Entity\Address")
     */
    private $address;

    /**
     * @var ContactDistributor[]|Collection
     * @ORM\OneToMany(targetEntity="ContactDistributor", mappedBy="distributor")
     */
    private $contactDistributor;

    /**
     * @ORM\OneToOne(targetEntity="ContactDistributor", mappedBy="distributor", cascade={"persist"})
     * @Assert\Type(type="App\FrontZr\DBBundle\Entity\ContactDistributor")
     */
    private $contact;

    /**
     * @var Bank[]|Collection
     * @ORM\OneToMany(targetEntity="Bank", mappedBy="distributor")
     */
    protected $bank;

    /**
     * @var DelayRecyclage[]|Collection
     * @ORM\OneToMany(targetEntity="DelayRecyclage", mappedBy="distributor")
     */
    private $delayRecyclage;

    /**
     *
     * @var type
     */
    private $nbrOrdersToValidate;

    /**
     *
     * @var type
     */
    private $nbrOrdersValidated;

    /**
     *
     * @var type
     */
    private $nbrOrdersCanceled;

    /**
     *
     * @var type
     */
    private $nbrOrdersBlocked;

    /**
     *
     * @var type
     */
    private $nbrProducts;

    /**
     * @var boolean $recyclageFr
     *
     * @ORM\Column(name="recyclage_fr", type="boolean", nullable=true)
     */
    private $recyclageFr;

    /**
     * @var boolean $recyclageEs
     *
     * @ORM\Column(name="recyclage_es", type="boolean", nullable=true)
     */
    private $recyclageEs;

    /**
     * @var boolean $recyclageIt
     *
     * @ORM\Column(name="recyclage_it", type="boolean", nullable=true)
     */
    private $recyclageIt;
    private $companyId;

    /**
     * @var boolean $size
     *
     * @ORM\Column(name="size", type="string", nullable=true)
     */
    private $size;

    /**
     * @var integer $nbrDeposit
     *
     * @ORM\Column(name="nbr_deposit", type="integer", nullable=true)
     */
    private $nbrDeposit;

    /**
     * @var string $m2TotalDeposit
     *
     * @ORM\Column(name="m2_total_deposit", type="string", length=128, nullable=true)
     */
    private $m2TotalDeposit;

    /**
     * @var string $caPreviousYear
     *
     * @ORM\Column(name="ca_previous_year", type="string", length=128, nullable=true)
     */
    private $caPreviousYear;

    /**
     * @var string $caNextYear
     *
     * @ORM\Column(name="ca_next_year", type="string", length=128, nullable=true)
     */
    private $caNextYear;

    /**
     * @var string $ca
     *
     * @ORM\Column(name="ca", type="string", length=128, nullable=true)
     */
    private $ca;

    /**
     * @var integer $volAnnualTyre
     *
     * @ORM\Column(name="vol_annual_tyre", type="integer", nullable=true)
     */
    private $volAnnualTyre;

    /**
     * @var string $plRate
     *
     * @ORM\Column(name="pl_rate", type="string", nullable=true)
     */
    private $plRate;

    /**
     * @var string $snowTourimeRate
     *
     * @ORM\Column(name="snow_tourime_rate", type="string", nullable=true)
     */
    private $snowTourimeRate;

    /**
     * @var boolean $independente
     *
     * @ORM\Column(name="independente", type="boolean", nullable=true)
     */
    private $independente;

    /**
     * @var boolean $distributionNetwork
     *
     * @ORM\Column(name="distribution_network", type="boolean", nullable=true)
     */
    private $distributionNetwork;

    /**
     * @var string $distributionNetworkName
     *
     * @ORM\Column(name="distribution_network_name", type="string", nullable=true)
     */
    private $distributionNetworkName;

    /**
     * @var boolean $distributionNetwork
     *
     * @ORM\Column(name="private_brand", type="boolean", nullable=true)
     */
    private $privateBrand;

    /**
     * @var string $distributionNetworkName
     *
     * @ORM\Column(name="private_brand_name", type="string", nullable=true)
     */
    private $privateBrandName;

    /**
     * @var string $mainBrand1
     *
     * @ORM\Column(name="main_brand_1", type="string", nullable=true)
     */
    private $mainBrand1;

    /**
     * @var string $mainBrand2
     *
     * @ORM\Column(name="main_brand_2", type="string", nullable=true)
     */
    private $mainBrand2;

    /**
     * @var string $mainBrand3
     *
     * @ORM\Column(name="main_brand_3", type="string", nullable=true)
     */
    private $mainBrand3;

    /**
     * @var boolean $saleRetreadedTourism ;
     *
     * @ORM\Column(name="sale_retreaded_tourism", type="boolean", nullable=true)
     */
    private $saleRetreadedTourism;

    /**
     * @var boolean $retreadedPl ;
     *
     * @ORM\Column(name="retreaded_pl", type="boolean", nullable=true)
     */
    private $retreadedPl;

    /**
     * @var boolean $demountedTyre ;
     *
     * @ORM\Column(name="demounted_tyre", type="boolean", nullable=true)
     */
    private $demountedTyre;

    /**
     * @var boolean $gcSigned ;
     *
     * @ORM\Column(name="gc_signed", type="boolean", nullable=true)
     */
    private $gcSigned;

    /**
     * @var boolean $qualityCharterSigned ;
     *
     * @ORM\Column(name="quality_charter_signed", type="boolean", nullable=true)
     */
    private $qualityCharterSigned;

    /**
     * @var boolean $tracking ;
     *
     * @ORM\Column(name="tracking", type="boolean", nullable=true)
     */
    private $tracking;

    /**
     * @var boolean $invoiceOnLine ;
     *
     * @ORM\Column(name="invoice_on_line", type="boolean", nullable=true)
     */
    private $invoiceOnLine;

    /**
     * @var boolean $ifValidatedOrders ;
     *
     * @ORM\Column(name="if_validated_orders", type="boolean", nullable=true)
     */
    private $ifValidatedOrders;

    /**
     * @var boolean $ifCanceledOrders ;
     *
     * @ORM\Column(name="if_canceled_orders", type="boolean", nullable=true)
     */
    private $ifCanceledOrders;

    /**
     * @var boolean $ifUnpaidReported ;
     *
     * @ORM\Column(name="if_unpaid_reported", type="boolean", nullable=true)
     */
    private $ifUnpaidReported;

    /**
     * @var boolean $ifChangedRib ;
     *
     * @ORM\Column(name="if_changed_rib", type="boolean", nullable=true)
     */
    private $ifChangedRib;

    /**
     * @var boolean $dotManagement ;
     *
     * @ORM\Column(name="dot_management", type="boolean", nullable=true)
     */
    private $dotManagement;

    /**
     * @var boolean $dotLimit ;
     *
     * @ORM\Column(name="dot_limit", type="boolean", nullable=true)
     */
    private $dotLimit;

    /**
     * @var string $xmlVersion
     *
     * @ORM\Column(name="xml_version", type="string", nullable=true)
     */
    private $xmlVersion;
    

    /**
     * @var string $xmlTypeCode
     * @ORM\Column(name="xml_type_code", type="string", nullable=true)
     */
    private $xmlTypeCode;

    /**
     * @var integer $premium
     *
     * @ORM\Column(name="premium", type="boolean", nullable=true)
     */
    private $premium;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var acceptCard
     * @ORM\Column(name="accept_card", type="integer", nullable=false)
     */
    private $acceptCard;

    /**
     * @var acceptLcr
     *
     * @ORM\Column(name="accept_lcr", type="boolean", nullable=false)
     */
    private $acceptLcr;

    /**
     * @var tpeNumber
     *
     * @ORM\Column(name="tpe_number", type="string", length=32, nullable=false)
     */
    private $tpeNumber;

    /**
     * @var cicKey
     *
     * @ORM\Column(name="cic_key", type="string", length=64, nullable=false)
     */
    private $cicKey;

    /**
     * @var companyCode
     *
     * @ORM\Column(name="company_code", type="string", length=64, nullable=false)
     */
    private $companyCode;

    /**
     * FMT-221 - ajout plateforme
     * @var plateforme
     *
     * @ORM\Column(name="plateforme", type="string", length=64, nullable=false)
     */
    private $plateforme;

    /**
     * @ORM\OneToMany(targetEntity="OrderStatisticDistributor", mappedBy="distributor")
     */
    private $orderStatisticDistributor;

    /**
     * @var boolean
     * @Assert\NotBlank(groups={"useHipay"})
     * @ORM\Column(name="use_hipay_cb", type="boolean", options={"default" = false})
     */
    private $useHipayCb;

    /**
     * @var boolean
     * @Assert\NotBlank(groups={"useHipay"})
     * @ORM\Column(name="use_hipay_sepa", type="boolean", options={"default" = false})
     */
    private $useHipaySepa;

    /**
     * @var boolean
     * @Assert\NotBlank(groups={"useCheckout"})
     * @ORM\Column(name="use_checkout_cb", type="boolean", options={"default" = false})
     */
    protected $useCheckoutCb = false;

    /**
     * @var boolean
     * @Assert\NotBlank(groups={"useCheckout"})
     * @ORM\Column(name="use_checkout_sepa", type="boolean", options={"default" = false})
     */
    protected $useCheckoutSepa = false;

    /**
     * (pour avoir company-id)
     * @var string
     */
    private $companyAndId;

    /**
     * @var QuotationCart[]|Collection
     * @ORM\OneToMany(targetEntity="QuotationCart", mappedBy="distributor")
     */
    private $quotationCarts;

    /**
     *
     * @var Agent
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dbm_id", referencedColumnName="id")
     * })
     */
    private $dbm;

    /**
     * @ORM\Column(name="sale_oils", type="boolean", options={"default" = false}, nullable=true)
     */
    private $saleOils;

    /**
     * @ORM\Column(name="sale_battery", type="boolean", options={"default" = false}, nullable=true)
     */
    private $saleBattery;

    /**
     * @ORM\Column(name="sale_pdm_sparepart", type="boolean", options={"default" = false}, nullable=true)
     */
    private $salePdmSparepart;

    /**
     * @ORM\Column(name="sale_pdm_sparepart_activation_date", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $salePdmSparepartActivationDate;

    /**
     * @Assert\NotBlank(groups={"oils"})
     * @Assert\Length(
     *  max=255,
     *  maxMessage="This field cannot be longer than {{ limit }} characters",
     *  groups={"oils"}
     * )
     * @ORM\Column(name="sale_oils_motif", type="string", length=255, nullable=true)
     */
    private $saleOilsMotif;

    /**
     * @Assert\NotBlank(groups={"battery"})
     * @Assert\Length(
     *  max=255,
     *  maxMessage="This field cannot be longer than {{ limit }} characters",
     *  groups={"battery"}
     * )
     * @ORM\Column(name="sale_battery_motif", type="string", length=255, nullable=true)
     */
    private $saleBatteryMotif;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var boolean $solvencyEnabled
     *
     * @ORM\Column(name="solvency_enabled", type="boolean", options={"default" = false})
     */
    private $solvencyEnabled;

    /**
     * @var integer $updateEs
     *
     * @ORM\Column(name="update_es", type="integer", nullable=false)
     */
    private $updateEs = 1;

    /**
     * @var HipayAccountInfo
     * @ORM\ManyToOne(targetEntity="HipayAccountInfo")
     * @ORM\JoinColumn(name="hipay_account_info_id", referencedColumnName="id")
     */
    private $hipayAccountInfo;

    /**
     * @var string $commercialName
     * @ORM\Column(name="commercial_name", type="string", length=255, nullable=true)
     */
    private $commercialName;

    /**
     * @var integer centralizedBillingDistributor
     *
     * @ORM\Column(name="centralized_billing_distributor", type="integer", nullable=true)
     */
    private $centralizedBillingDistributor;

    /**
     * @var Distributor
     *
     * @ORM\ManyToOne(targetEntity="Distributor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="centralized_billing_distributor", referencedColumnName="id")
     * })
     */
    protected $centralizedBillingDistributorCustomer;

    /**
     * @var Distributor
     *
     * @ORM\ManyToOne(targetEntity="Distributor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="centralized_billing_frs", referencedColumnName="id")
     * })
     */
    protected $centralizedBillingDistributorDistributor;

    /**
     * @var int
     *
     * @ORM\Column(name="centralized_billing_frs", type="integer", nullable=true)
     */
    private $centralizedBillingFrs;

    /**
     * @var boolean additionalMarkup
     *
     * @ORM\Column(name="additional_markup", type="integer", nullable=true)
     */
    private $additionalMarkup;

    /**
     * @var float additionalMarkupValue
     *
     * @ORM\Column(name="additional_markup_value", type="float", nullable=true)
     */
    private $additionalMarkupValue;

    /**
     * @var int $batterySaleCondition
     *
     * @ORM\Column(name="battery_sale_condition", type="integer", nullable=true)
     */
    private $batterySaleCondition = 1;

    /**
     * @var float oilsThresholdAmountHt
     *
     * @ORM\Column(name="oils_threshold_amount_ht", type="float", nullable=true)
     */
    private $oilsThresholdAmountHt;

    /**
     * @var float oilsDeliveryFee
     *
     * @ORM\Column(name="oils_delivery_fee", type="float", nullable=true)
     */
    private $oilsDeliveryFee;

    /**
     * @var float tgapEnabled
     *
     * @ORM\Column(name="tgap_enabled", type="boolean", nullable=true)
     */
    private $tgapEnabled;

    /**
     * @var string rankingversion
     *
     * @ORM\Column(name="ranking_version", type="string", nullable=true)
     */
    private $ranking_version;

    /**
     * @var float acceptFinancialRisk
     *
     * @ORM\Column(name="accept_financial_risk", type="boolean", nullable=true)
     */
    private $acceptFinancialRisk;

    /**
     * @var float lubricantDeliveryType
     *
     * @ORM\Column(name="lubricant_delivery_type", type="string", length=64)
     */
    private $lubricantDeliveryType;

    /**
     * @var float oilsThresholdAmountLitre
     *
     * @ORM\Column(name="oils_threshold_amount_litre", type="float", nullable=true)
     */
    private $oilsThresholdAmountLitre;

    /**
     * @ORM\OneToOne(targetEntity="GeneralCondition", mappedBy="distributor")
     */
    private $generalCondition;

    /**
     * @ORM\OneToOne(targetEntity="DistributorConfigCheckout", mappedBy="distributor", cascade={"persist"})
     * @Assert\Type(type="App\FrontZr\DBBundle\Entity\DistributorConfigCheckout")
     */
    private $configCheckout;

    /**
     * true if this distributor is Distri2b
     * @ORM\Column(name="distri2b", type="integer", nullable=true)
     */
    private $distri2b;

    /**
     * Id of Markup Tyres Type
     * @ORM\Column(name="markup_tyre_type", type="integer", nullable=true)
     */
    private $markupTyreType;

    public function __construct()
    {
        $this->prospect = new \Doctrine\Common\Collections\ArrayCollection();
        $this->quotationCarts = new ArrayCollection();
        $this->acceptCard = 0;
        $this->acceptLcr = 1;
    }

    /**
     * Set contact
     *
     * @param App\FrontZr\DBBundle\Entity\ContactDistributor $contact
     */
    public function setContact(ContactDistributor $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get contact
     *
     * @return App\FrontZr\DBBundle\Entity\ContactDistributor
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set delayRecyclage
     *
     * @param App\FrontZr\DBBundle\Entity\DelayRecyclage $delayRecyclage
     */
    public function setDelayRecyclage(DelayRecyclage $delayRecyclage)
    {
        $this->delayRecyclage = $delayRecyclage;
    }

    /**
     * Get delayRecyclage
     *
     * @return App\FrontZr\DBBundle\Entity\DelayRecyclage
     */
    public function getDelayRecyclage()
    {
        return $this->delayRecyclage;
    }

    /**
     * Set customer
     *
     * @param App\FrontZr\DBBundle\Entity\Customer $customer
     */
    public function setCustomer(\App\FrontZr\DBBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;
    }

    /**
     * Get customer
     *
     * @return App\FrontZr\DBBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Get bank
     * @return Bank[]
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     *
     * @param Bank $bank
     */
    public function setBank(Bank $bank)
    {
        $this->bank = $bank;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Gets companyInvoicingName property value
     *
     * @return string
     */
    public function getCompanyInvoicingName()
    {
        return $this->companyInvoicingName;
    }

    /**
     * Sets companyInvoicingName property value
     * @param string $sCompanyInvoicingName
     * @return \App\FrontZr\DBBundle\Entity\Distributor
     */
    public function setCompanyInvoicingName($sCompanyInvoicingName)
    {
        $this->companyInvoicingName = $sCompanyInvoicingName;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Get company shortname
     *
     * @return string
     */
    public function getCompanyShortName($len = 18)
    {
        $str = mb_substr($this->company, 0, $len);
        $str .= mb_strlen($this->company) > $len ? '...' : '';

        return $str;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set billParentId
     *
     * @param integer $billParentId
     */
    public function setBillParentId($billParentId)
    {
        $this->billParentId = $billParentId;
    }

    /**
     * Get billParentId
     *
     * @return integer
     */
    public function getBillParentId()
    {
        return $this->billParentId;
    }

    /**
     * Set ftpLogin
     *
     * @param string $ftpLogin
     */
    public function setFtpLogin($ftpLogin)
    {
        $this->ftpLogin = $ftpLogin;
    }

    /**
     * Get ftpLogin
     *
     * @return string
     */
    public function getFtpLogin()
    {
        return $this->ftpLogin;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set juridicalForm
     *
     * @param string $juridicalForm
     */
    public function setJuridicalForm($juridicalForm)
    {
        $this->juridicalForm = $juridicalForm;
    }

    /**
     * Get juridicalForm
     *
     * @return string
     */
    public function getJuridicalForm()
    {
        return $this->juridicalForm;
    }

    /**
     * Set siretNumber
     *
     * @param string $siretNumber
     */
    public function setSiretNumber($siretNumber)
    {
        $this->siretNumber = $siretNumber;
    }

    /**
     * Get siretNumber
     *
     * @return string
     */
    public function getSiretNumber()
    {
        return $this->siretNumber;
    }

    /**
     * Set tvaNumber
     *
     * @param string $tvaNumber
     */
    public function setTvaNumber($tvaNumber)
    {
        $this->tvaNumber = $tvaNumber;
    }

    /**
     * Get tvaNumber
     *
     * @return string
     */
    public function getTvaNumber()
    {
        return $this->tvaNumber;
    }

    /**
     * Set maxContact
     *
     * @param integer $maxContact
     */
    public function setMaxContact($maxContact)
    {
        $this->maxContact = $maxContact;
    }

    /**
     * Get maxContact
     *
     * @return integer
     */
    public function getMaxContact()
    {
        return $this->maxContact;
    }

    /**
     * Set language1
     *
     * @param string $language1
     * @return Distributor
     */
    public function setLanguage1($language1)
    {
        $this->language1 = $language1;
    }

    /**
     * Get language1
     *
     * @return string
     */
    public function getLanguage1()
    {
        return $this->language1;
    }

    /**
     * Set language2
     *
     * @param string $language2
     * @return Distributor
     */
    public function setLanguage2($language2)
    {
        $this->language2 = $language2;
    }

    /**
     * Get language2
     *
     * @return string
     */
    public function getLanguage2()
    {
        return $this->language2;
    }

    /**
     * Set language3
     *
     * @param string $language3
     * @return Distributor
     */
    public function setLanguage3($language3)
    {
        $this->language3 = $language3;
    }

    /**
     * Get language3
     *
     * @return string
     */
    public function getLanguage3()
    {
        return $this->language3;
    }

    /**
     * Set increaseType
     *
     * @param integer $increaseType
     * @return Distributor
     */
    public function setIncreaseType($increaseType)
    {
        $this->increaseType = $increaseType;
    }

    /**
     * Get increaseType
     *
     * @return integer
     */
    public function getIncreaseType()
    {
        return $this->increaseType;
    }

    /**
     *
     * @return Country
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     *
     * @param Country $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Set finical
     *
     * @param boolean $finical
     * @return Distributor
     */
    public function setFinical($finical)
    {
        $this->finical = $finical;
    }

    /**
     * Get finical
     *
     * @return boolean
     */
    public function getFinical()
    {
        return $this->finical;
    }

    public function getAllowChangeDeliveryAddress()
    {
        return $this->allowChangeDeliveryAddress;
    }

    public function setAllowChangeDeliveryAddress($allowChangeDeliveryAddress)
    {
        $this->allowChangeDeliveryAddress = $allowChangeDeliveryAddress;
    }

    public function getAllowDeleteStock()
    {
        return $this->allowDeleteStock;
    }

    public function setAllowDeleteStock($allowDeleteStock)
    {
        $this->allowDeleteStock = $allowDeleteStock;
    }

    /**
     * Set payCollect
     *
     * @param boolean $payCollect
     * @return Distributor
     */
    public function setPayCollect($payCollect)
    {
        $this->payCollect = $payCollect;
    }

    /**
     * Get payCollect
     *
     * @return boolean
     */
    public function getPayCollect()
    {
        return $this->payCollect;
    }

    public function getPaymentDelay()
    {
        return $this->paymentDelay;
    }

    public function setPaymentDelay($paymentDelay)
    {
        $this->paymentDelay = $paymentDelay;
    }

    /**
     * @return PaymentType
     */
    public function getPaymentModeMain()
    {
        return $this->paymentModeMain;
    }

    public function setPaymentModeMain($paymentModeMain)
    {
        $this->paymentModeMain = $paymentModeMain;
    }

    /**
     * @return PaymentType
     */
    public function getPaymentModeSecondary()
    {
        return $this->paymentModeSecondary;
    }

    public function setPaymentModeSecondary($paymentModeSecondary)
    {
        $this->paymentModeSecondary = $paymentModeSecondary;
    }

    /**
     * @return PaymentType
     */
    public function getPaymentModeOther()
    {
        return $this->paymentModeOther;
    }

    public function setPaymentModeOther($paymentModeOther)
    {
        $this->paymentModeOther = $paymentModeOther;
    }

    /**
     * Set minToCollect
     *
     * @param integer $minToCollect
     */
    public function setMinToCollect($minToCollect)
    {
        $this->minToCollect = $minToCollect;
    }

    /**
     * Get minToCollect
     *
     * @return integer
     */
    public function getMinToCollect()
    {
        return $this->minToCollect;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     *
     * @param float $billingAmount
     */
    public function setBillingAmount($billingAmount)
    {
        $this->billingAmount = $billingAmount;
    }

    /**
     *
     * @return float
     */
    public function getBillingAmount()
    {
        return $this->billingAmount;
    }

    /**
     * Set lastConnexion
     *
     * @param datetime $lastConnexion
     */
    public function setLastConnexion($lastConnexion)
    {
        $this->lastConnexion = $lastConnexion;
    }

    /**
     * Get lastConnexion
     *
     * @return datetime
     */
    public function getLastConnexion()
    {
        return $this->lastConnexion;
    }

    /**
     * Add prospect
     *
     * @param App\FrontZr\DBBundle\Entity\Prospect $prospect
     */
    public function addProspect(Prospect $prospect)
    {
        $this->prospect[] = $prospect;
    }

    /**
     * Get prospect
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getProspect()
    {
        return $this->prospect;
    }

    /**
     * Set parent
     *
     * @param App\FrontZr\DBBundle\Entity\Distributor $parent
     */
    public function setParent(\App\FrontZr\DBBundle\Entity\Distributor $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return App\FrontZr\DBBundle\Entity\Distributor
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set agent
     *
     * @param App\FrontZr\DBBundle\Entity\Agent $agent
     * @return Distributor
     */
    public function setAgent(Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return App\FrontZr\DBBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Add stock
     *
     * @param App\FrontZr\DBBundle\Entity\Stock $stock
     */
    public function addStock(Stock $stock)
    {
        $this->stocks[] = $stock;
    }

    /**
     * Get stocks
     * @return Doctrine\Common\Collections\Collection
     */
    public function getStocks()
    {
        return $this->stocks;
    }

    /**
     *
     * @return type
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     *
     * @param type $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Get contactDistributor
     * @return type
     */
    public function getContactDistributor()
    {
        return $this->contactDistributor;
    }

    /**
     * Set contactDistributor
     *
     * @param type $contactDistributor
     */
    public function setContactDistributor($contactDistributor)
    {
        $this->contactDistributor = $contactDistributor;
    }

    /**
     * Get cutoff
     *
     * @return App\FrontZr\DBBundle\Entity\Cutoff
     */
    public function getCutOff()
    {
        return $this->cutOff;
    }

    /**
     * setCutOff
     * @param type $cutOff
     */
    public function setCutOff($cutOff)
    {
        $this->cutOff = $cutOff;
    }

    /**
     * Add Address
     *
     * @param App\FrontZr\DBBundle\Entity\Address $address
     */
    public function addAddress(\App\FrontZr\DBBundle\Entity\Address $address)
    {
        $this->address = $address;
    }

    /**
     * Set address
     *
     * @param App\FrontZr\DBBundle\Entity\Address $address
     */
    public function setAddress(\App\FrontZr\DBBundle\Entity\Address $address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return App\FrontZr\DBBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set collector
     *
     * @param App\FrontZr\DBBundle\Entity\Collector $collector
     */
    public function setCollector(\App\FrontZr\DBBundle\Entity\Collector $collector = null)
    {
        $this->collector = $collector;
    }

    /**
     * Get collector
     *
     * @return App\FrontZr\DBBundle\Entity\Collector
     */
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * Get username
     * @return string
     */
    public function getUsername()
    {
        return $this->getFtpLogin();
    }

    /**
     * get roles
     * @return array
     */
    public function getRoles():array
    {
        return array($this->getProfile()->getRole());
    }

    /**
     * set salt
     * @return string
     */
    public function getSalt()
    {
        return mb_substr(sha1($this->getUsername()), 3, 3);
    }

    /**
     * equals
     * @param UserInterface $account
     * @return boolean
     */
    public function equals(UserInterface $account)
    {
        if ($account->getUsername() != $this->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * eraseCredentials
     * @return boolean
     */
    public function eraseCredentials()
    {
        return false;
    }

    /**
     * serialize
     *
     * @return string
     */
    public function serialize()
    {
        return serialize($this->ftpLogin);
    }

    /**
     * unserialize
     *
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->ftpLogin = unserialize($data);
    }

    /**
     * s
     * @return ProductDistributor[]
     */
    public function getProductdistributor()
    {
        return $this->productdistributor;
    }

    /**
     *
     * @param type $productdistributor
     */
    public function setProductdistributor($productdistributor)
    {
        $this->productdistributor = $productdistributor;
    }

    /**
     * Set recyclageFr
     *
     * @param boolean $recyclageFr
     */
    public function setRecyclageFr($recyclageFr)
    {
        $this->recyclageFr = $recyclageFr;
    }

    /**
     * Get recyclageFr
     *
     * @return boolean
     */
    public function getRecyclageFr()
    {
        return $this->recyclageFr;
    }

    /**
     * Set recyclageEs
     *
     * @param boolean $recyclageEs
     */
    public function setRecyclageEs($recyclageEs)
    {
        $this->recyclageEs = $recyclageEs;
    }

    /**
     * Get recyclageEs
     *
     * @return boolean
     */
    public function getRecyclageEs()
    {
        return $this->recyclageEs;
    }

    /**
     * Set recyclageIt
     *
     * @param boolean $recyclageIt
     */
    public function setRecyclageIt($recyclageIt)
    {
        $this->recyclageIt = $recyclageIt;
    }

    /**
     * Get recyclageIt
     *
     * @return boolean
     */
    public function getRecyclageIt()
    {
        return $this->recyclageIt;
    }

    /**
     *
     * @return type
     */
    public function getNbrProducts()
    {
        $nbr_tires = 0;
        foreach ($this->getOrders() as $order) {
            $nbr_tires += $order->getNbrOfTires();
            $nbr_tires += 1;
        }

        $this->nbrProducts = $nbr_tires;

        return $this->nbrProducts;
    }

    /**
     * Get Number of orders to validate
     * @return integer
     */
    public function getNbrOrdersToValidate()
    {
        $nbr_orders_to_validate = 0;
        foreach ($this->getOrders() as $Order) {
            if ($Order->getLastStatus() == 'To validate') {
                $nbr_orders_to_validate += 1;
            }
        }

        $this->nbrOrdersToValidate = $nbr_orders_to_validate;

        return $this->nbrOrdersToValidate;
    }

    /**
     * Get Number of orders validated
     *
     * @return integer
     */
    public function getNbrOrdersValidated()
    {
        $nbr_orders_validated = 0;
        foreach ($this->getOrders() as $Order) {
            if ($Order->getLastStatus() == 'Validated') {
                $nbr_orders_validated += 1;
            }
        }

        $this->nbrOrdersValidated = $nbr_orders_validated;

        return $this->nbrOrdersValidated;
    }

    /**
     * Get Number of orders canceled
     * @return integer
     */
    public function getNbrOrdersCanceled()
    {
        $nbr_orders_canceled = 0;
        foreach ($this->getOrders() as $Order) {
            if ($Order->getLastStatus() == 'Canceled') {
                $nbr_orders_canceled += 1;
            }
        }

        $this->nbrOrdersCanceled = $nbr_orders_canceled;

        return $this->nbrOrdersCanceled;
    }

    /**
     * Get Number of orders blocked
     * @return integer
     */
    public function getNbrOrdersBlocked()
    {
        $nbr_orders_blocked = 0;
        foreach ($this->getOrders() as $Order) {
            if ($Order->getLastStatus() == 'Blocked') {
                $nbr_orders_blocked += 1;
            }
        }

        $this->nbrOrdersBlocked = $nbr_orders_blocked;

        return $this->nbrOrdersBlocked;
    }

    /**
     *
     */
    public function getContactByProfile($contactProfile)
    {
        foreach ($this->getContactDistributor() as $contact) {
            $profile = $contact->getProfile();

            if ($profile and $profile->getRole() == $contactProfile) {
                return $contact;
            }
        }

        return null;
    }

    /**
     *
     */
    public function getMainContact()
    {
        $contact = $this->getContactByProfile('ROLE_DISTRIBUTOR_MAIN');

        if (!$contact) {
            foreach ($this->getContactDistributor() as $c) {
                if ($c->getIsMainContact()) {
                    return $c;
                }
            }
        }

        return $contact;
    }

    /**
     *
     * @param array $options
     */
    public function getContactsByOptions($options = array())
    {
        $contacts = array();
        foreach ($this->getContactDistributor() as $contact) {
            foreach ($options as $option) {
                $val = call_user_func(array($contact, 'get'.ucfirst($option)));
                if ($val == 1) {
                    $contacts[] = $contact;
                }
            }
        }

        return $contacts;
    }

    /**
     * __toString
     *
     * @return type
     */
    public function __toString()
    {
        return $this->getId()." - ".$this->company;
    }

    /**
     * Add orders
     *
     * @param App\FrontZr\DBBundle\Entity\Orders $orders
     */
    public function addOrders(Orders $orders)
    {
        $this->orders[] = $orders;
    }

    /**
     * Add productdistributor
     *
     * @param App\FrontZr\DBBundle\Entity\ProductDistributor $productdistributor
     */
    public function addProductDistributor(ProductDistributor $productdistributor)
    {
        $this->productdistributor[] = $productdistributor;
    }

    /**
     * Add contactDistributor
     *
     * @param App\FrontZr\DBBundle\Entity\ContactDistributor $contactDistributor
     */
    public function addContactDistributor(ContactDistributor $contactDistributor)
    {
        $this->contactDistributor[] = $contactDistributor;
    }

    /**
     * Add bank
     *
     * @param App\FrontZr\DBBundle\Entity\Bank $bank
     */
    public function addBank(Bank $bank)
    {
        $this->bank[] = $bank;
    }

    /**
     * Add delayRecyclage
     *
     * @param App\FrontZr\DBBundle\Entity\DelayRecyclage $delayRecyclage
     */
    public function addDelayRecyclage(DelayRecyclage $delayRecyclage)
    {
        $this->delayRecyclage[] = $delayRecyclage;
    }

    /**
     *
     */
    public function isParent()
    {
        return $this->getId() == $this->getParent()->getId();
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    public function getCompanyId()
    {
        return $this->id.'  - '.$this->company;
    }

    public function getBillingAmountIndex()
    {
        return $this->billingAmountIndex;
    }

    public function setBillingAmountIndex($billingAmountIndex)
    {
        $this->billingAmountIndex = $billingAmountIndex;
    }

    /**
     * Get concurrence
     *
     * @return Collection|Concurrence[]
     */
    public function getConcurrence()
    {
        return $this->concurrence;
    }

    /**
     * Get plateform
     *
     * @return Collection|Plateform[]
     */
    public function getPlateform()
    {
        return $this->plateform;
    }

    /**
     * Get market
     *
     * @return Collection|Market[]
     */
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * Get category
     *
     * @return Collection|Category[]
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add concurrence
     *
     * @param Concurrence $concurrence
     */
    public function addConcurrence(Concurrence $concurrence)
    {
        $this->concurrence[] = $concurrence;
    }

    /**
     * Add plateform
     * @param Plateform $plateform
     */
    public function addPlateform(Plateform $plateform)
    {
        $this->plateform[] = $plateform;
    }

    /**
     * Add market
     *
     * @param Market $market
     */
    public function addMarket(Market $market)
    {
        $this->market[] = $market;
    }

    /**
     * Add category
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->category[] = $category;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getCaPreviousYear()
    {
        return $this->caPreviousYear;
    }

    public function setCaPreviousYear($caPreviousYear)
    {
        $this->caPreviousYear = $caPreviousYear;
    }

    public function getCaNextYear()
    {
        return $this->caNextYear;
    }

    public function setCaNextYear($caNextYear)
    {
        $this->caNextYear = $caNextYear;
    }

    public function getCa()
    {
        return $this->ca;
    }

    public function setCa($ca)
    {
        $this->ca = $ca;
    }

    public function getNbrDeposit()
    {
        return $this->nbrDeposit;
    }

    public function setNbrDeposit($nbrDeposit)
    {
        $this->nbrDeposit = $nbrDeposit;
    }

    public function getM2TotalDeposit()
    {
        return $this->m2TotalDeposit;
    }

    public function setM2TotalDeposit($m2TotalDeposit)
    {
        $this->m2TotalDeposit = $m2TotalDeposit;
    }

    public function getVolAnnualTyre()
    {
        return $this->volAnnualTyre;
    }

    public function setVolAnnualTyre($volAnnualTyre)
    {
        $this->volAnnualTyre = $volAnnualTyre;
    }

    public function getPlRate()
    {
        return $this->plRate;
    }

    public function setPlRate($plRate)
    {
        $this->plRate = $plRate;
    }

    public function getSnowTourimeRate()
    {
        return $this->snowTourimeRate;
    }

    public function setSnowTourimeRate($snowTourimeRate)
    {
        $this->snowTourimeRate = $snowTourimeRate;
    }

    public function getIndependente()
    {
        return $this->independente;
    }

    public function setIndependente($independente)
    {
        $this->independente = $independente;
    }

    public function getDistributionNetwork()
    {
        return $this->distributionNetwork;
    }

    public function setDistributionNetwork($distributionNetwork)
    {
        $this->distributionNetwork = $distributionNetwork;
    }

    public function getDistributionNetworkName()
    {
        return $this->distributionNetworkName;
    }

    public function setDistributionNetworkName($distributionNetworkName)
    {
        $this->distributionNetworkName = $distributionNetworkName;
    }

    public function getMainBrand1()
    {
        return $this->mainBrand1;
    }

    public function setMainBrand1($mainBrand1)
    {
        $this->mainBrand1 = $mainBrand1;
    }

    public function getMainBrand2()
    {
        return $this->mainBrand2;
    }

    public function setMainBrand2($mainBrand2)
    {
        $this->mainBrand2 = $mainBrand2;
    }

    public function getMainBrand3()
    {
        return $this->mainBrand3;
    }

    public function setMainBrand3($mainBrand3)
    {
        $this->mainBrand3 = $mainBrand3;
    }

    public function getPrivateBrand()
    {
        return $this->privateBrand;
    }

    public function setPrivateBrand($privateBrand)
    {
        $this->privateBrand = $privateBrand;
    }

    public function getPrivateBrandName()
    {
        return $this->privateBrandName;
    }

    public function setPrivateBrandName($privateBrandName)
    {
        $this->privateBrandName = $privateBrandName;
    }

    public function getSaleRetreadedTourism()
    {
        return $this->saleRetreadedTourism;
    }

    public function setSaleRetreadedTourism($saleRetreadedTourism)
    {
        $this->saleRetreadedTourism = $saleRetreadedTourism;
    }

    public function getRetreadedPl()
    {
        return $this->retreadedPl;
    }

    public function setRetreadedPl($retreadedPl)
    {
        $this->retreadedPl = $retreadedPl;
    }

    public function getDemountedTyre()
    {
        return $this->demountedTyre;
    }

    public function setDemountedTyre($demountedTyre)
    {
        $this->demountedTyre = $demountedTyre;
    }

    public function getGcSigned()
    {
        return $this->gcSigned;
    }

    public function setGcSigned($gcSigned)
    {
        $this->gcSigned = $gcSigned;
    }

    public function getQualityCharterSigned()
    {
        return $this->qualityCharterSigned;
    }

    public function setQualityCharterSigned($qualityCharterSigned)
    {
        $this->qualityCharterSigned = $qualityCharterSigned;
    }

    public function getTracking()
    {
        return $this->tracking;
    }

    public function setTracking($tracking)
    {
        $this->tracking = $tracking;
    }

    public function getInvoiceOnLine()
    {
        return $this->invoiceOnLine;
    }

    public function setInvoiceOnLine($invoiceOnLine)
    {
        $this->invoiceOnLine = $invoiceOnLine;
    }

    public function getIfValidatedOrders()
    {
        return $this->ifValidatedOrders;
    }

    public function setIfValidatedOrders($ifValidatedOrders)
    {
        $this->ifValidatedOrders = $ifValidatedOrders;
    }

    public function getIfCanceledOrders()
    {
        return $this->ifCanceledOrders;
    }

    public function setIfCanceledOrders($ifCanceledOrders)
    {
        $this->ifCanceledOrders = $ifCanceledOrders;
    }

    public function getIfUnpaidReported()
    {
        return $this->ifUnpaidReported;
    }

    public function setIfUnpaidReported($ifUnpaidReported)
    {
        $this->ifUnpaidReported = $ifUnpaidReported;
    }

    public function getIfChangedRib()
    {
        return $this->ifChangedRib;
    }

    public function setIfChangedRib($ifChangedRib)
    {
        $this->ifChangedRib = $ifChangedRib;
    }

    public function getDotManagement()
    {
        return $this->dotManagement;
    }

    public function setDotManagement($dotManagement)
    {
        $this->dotManagement = $dotManagement;
    }

    public function getDotLimit()
    {
        return $this->dotLimit;
    }

    public function setDotLimit($dotLimit)
    {
        $this->dotLimit = $dotLimit;
    }

    public function getXmlVersion()
    {
        return $this->xmlVersion;
    }

    public function getXmlTypeCode()
    {
        return $this->xmlTypeCode;
    }

    public function setXmlTypeCode($xmlTypeCode)
    {
        $this->xmlTypeCode = $xmlTypeCode;
        return $this;
    }


    public function setXmlVersion($xmlVersion)
    {
        $this->xmlVersion = $xmlVersion;

        return $this;
    }

    public function getPremium()
    {
        return $this->premium;
    }

    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    public function getAcceptLcr()
    {
        return $this->acceptLcr;
    }

    public function setAcceptLcr($acceptLcr)
    {
        $this->acceptLcr = $acceptLcr;

        return $this;
    }

    public function getAcceptCard()
    {
        return $this->acceptCard;
    }

    public function setAcceptCard($acceptCard)
    {
        $this->acceptCard = $acceptCard;

        return $this;
    }

    public function isAcceptSepa()
    {
        $isSepa = false;
        foreach ($this->getBank() as $bank) {
            $isSepa = $isSepa || $bank->getSepa();
        }

        return $isSepa;
    }

    public function getTpeNumber()
    {
        return $this->tpeNumber;
    }

    public function setTpeNumber($tpeNumber)
    {
        $this->tpeNumber = $tpeNumber;

        return $this;
    }

    public function getCicKey()
    {
        return $this->cicKey;
    }

    public function setCicKey($cicKey)
    {
        $this->cicKey = $cicKey;

        return $this;
    }

    public function getCompanyCode()
    {
        return $this->companyCode;
    }

    public function setCompanyCode($companyCode)
    {
        $this->companyCode = $companyCode;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getFormatedname()
    {
        return sprintf('%s - %s', $this->getId(), $this->getCompany());
    }

    /**
     *
     * @return DistributorGroup
     */
    public function getDistributorGroup()
    {
        return $this->distributorGroup;
    }

    /**
     *
     * @param DistributorGroup $distributorGroup
     */
    public function setDistributorGroup($distributorGroup)
    {
        $this->distributorGroup = $distributorGroup;
    }

    /**
     *
     * @return string
     */
    public function getCompanyAndId()
    {
        return $this->getCompany().'-'.$this->getId();
    }

    /**
     * Add cutOff
     *
     * @param Cutoff $cutOff
     * @return Distributor
     */
    public function addCutoff(Cutoff $cutOff)
    {
        $this->cutOff[] = $cutOff;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlateforme()
    {
        return $this->plateforme;
    }

    /**
     * @param string $plateforme
     */
    public function setPlateforme($plateforme)
    {
        $this->plateforme = $plateforme;
    }

    /**
     * Add orderStatisticDistributor
     *
     * @param OrderStatisticDistributor $orderStatisticDistributor
     * @return Distributor
     */
    public function addOrderStatisticDistributor(OrderStatisticDistributor $orderStatisticDistributor)
    {
        $this->orderStatisticDistributor[] = $orderStatisticDistributor;

        return $this;
    }

    /**
     * Get orderStatisticDistributor
     *
     * @return Collection
     */
    public function getOrderStatisticDistributor()
    {
        return $this->orderStatisticDistributor;
    }

    /**
     * Set useHipayCb
     *
     * @param boolean $useHipayCb
     * @return Distributor
     */
    public function setUseHipayCb($useHipayCb)
    {
        $this->useHipayCb = $useHipayCb;

        return $this;
    }

    /**
     * Get useHipayCb
     *
     * @return boolean
     */
    public function getUseHipayCb()
    {
        return $this->useHipayCb;
    }

    /**
     * Get useHipaySepa
     *
     * @return boolean
     */
    public function getUseHipaySepa()
    {
        return $this->useHipaySepa;
    }

    /**
     * Set useHipaySepa
     *
     * @param boolean $useHipaySepa
     * @return Distributor
     */
    public function setUseHipaySepa($useHipaySepa)
    {
        $this->useHipaySepa = $useHipaySepa;

        return $this;
    }

    /**
     * Add orderStatisticDistributor
     *
     * @param QuotationCart $quotationCart
     * @return Distributor
     */
    public function addQuotationCarts(QuotationCart $quotationCart)
    {
        $this->quotationCarts[] = $quotationCart;
        $quotationCart->setDistributor($this);

        return $this;
    }

    /**
     * Get orderStatisticDistributor
     *
     * @return Collection|QuotationCart[]
     */
    public function getQuotationCarts()
    {
        return $this->quotationCarts;
    }

    /**
     * Remove concurrence
     *
     * @param Concurrence $concurrence
     */
    public function removeConcurrence(Concurrence $concurrence)
    {
        $this->concurrence->removeElement($concurrence);
    }

    /**
     * Remove plateform
     *
     * @param Plateform $plateform
     */
    public function removePlateform(Plateform $plateform)
    {
        $this->plateform->removeElement($plateform);
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Remove market
     *
     * @param Market $market
     */
    public function removeMarket(Market $market)
    {
        $this->market->removeElement($market);
    }

    /**
     * Add orders
     *
     * @param Orders $orders
     * @return Distributor
     */
    public function addOrder(Orders $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param Orders $orders
     */
    public function removeOrder(Orders $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Remove productdistributor
     * @param ProductDistributor $productdistributor
     */
    public function removeProductdistributor(ProductDistributor $productdistributor)
    {
        $this->productdistributor->removeElement($productdistributor);
    }

    /**
     * Remove cutOff
     *
     * @param Cutoff $cutOff
     */
    public function removeCutOff(Cutoff $cutOff)
    {
        $this->cutOff->removeElement($cutOff);
    }

    /**
     * Remove stocks
     *
     * @param Stock $stocks
     */
    public function removeStock(Stock $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Remove prospect
     *
     * @param Prospect $prospect
     */
    public function removeProspect(Prospect $prospect)
    {
        $this->prospect->removeElement($prospect);
    }

    /**
     * Remove contactDistributor
     *
     * @param ContactDistributor $contactDistributor
     */
    public function removeContactDistributor(ContactDistributor $contactDistributor)
    {
        $this->contactDistributor->removeElement($contactDistributor);
    }

    /**
     * Remove bank
     *
     * @param Bank $bank
     */
    public function removeBank(Bank $bank)
    {
        $this->bank->removeElement($bank);
    }

    /**
     * Remove delayRecyclage
     *
     * @param DelayRecyclage $delayRecyclage
     */
    public function removeDelayRecyclage(DelayRecyclage $delayRecyclage)
    {
        $this->delayRecyclage->removeElement($delayRecyclage);
    }

    /**
     * Remove orderStatisticDistributor
     *
     * @param OrderStatisticDistributor $orderStatisticDistributor
     */
    public function removeOrderStatisticDistributor(OrderStatisticDistributor $orderStatisticDistributor) {
        $this->orderStatisticDistributor->removeElement($orderStatisticDistributor);
    }

    /**
     * Add quotationCarts
     *
     * @param QuotationCart $quotationCarts
     * @return Distributor
     */
    public function addQuotationCart(QuotationCart $quotationCarts)
    {
        $this->quotationCarts[] = $quotationCarts;

        return $this;
    }

    /**
     * Remove quotationCarts
     *
     * @param QuotationCart $quotationCarts
     */
    public function removeQuotationCart(QuotationCart $quotationCarts)
    {
        $this->quotationCarts->removeElement($quotationCarts);
    }

    /**
     * Set dbm
     *
     * @param Agent $dbm
     * @return Distributor
     */
    public function setDbm(Agent $dbm = null)
    {
        $this->dbm = $dbm;

        return $this;
    }

    /**
     * Get dbm
     *
     * @return Agent
     */
    public function getDbm()
    {
        return $this->dbm;
    }

    /**
     * Set acceptDeal
     *
     * @param boolean $acceptDeal
     *
     * @return Distributor
     */
    public function setAcceptDeal($acceptDeal)
    {
        $this->acceptDeal = $acceptDeal;

        return $this;
    }

    /**
     * Get acceptDeal
     *
     * @return boolean
     */
    public function getAcceptDeal()
    {
        return $this->acceptDeal;
    }

    public function setSaleOils($saleOils)
    {
        $this->saleOils = $saleOils;

        return $this;
    }

    public function getSaleOils()
    {
        return $this->saleOils;
    }

    public function setSaleOilsMotif($saleOilsMotif)
    {
        $this->saleOilsMotif = $saleOilsMotif;

        return $this;
    }

    public function getSaleOilsMotif()
    {
        return $this->saleOilsMotif;
    }

    public function setSaleBattery($saleBattery)
    {
        $this->saleBattery = $saleBattery;

        return $this;
    }

    public function getSaleBattery()
    {
        return $this->saleBattery;
    }

    public function setSaleBatteryMotif($saleBatteryMotif)
    {
        $this->saleBatteryMotif = $saleBatteryMotif;

        return $this;
    }

    public function getSaleBatteryMotif()
    {
        return $this->saleBatteryMotif;
    }

    /**
     * Set country
     *
     * @param Country $country
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param integer $updateEs
     */
    public function setUpdateEs($updateEs)
    {
        $this->updateEs = $updateEs;
    }

    /**
     * @return integer
     */
    public function getUpdateEs()
    {
        return $this->updateEs;
    }

    /**
     *
     * @return HipayAccountInfo
     */
    public function getHipayAccountInfo()
    {
        return $this->hipayAccountInfo;
    }

    /**
     *
     * @param HipayAccountInfo $hipayAccountInfo
     * @return Distributor
     */
    public function setHipayAccountInfo(HipayAccountInfo $hipayAccountInfo = null)
    {
        $this->hipayAccountInfo = $hipayAccountInfo;

        return $this;
    }

    /**
     * Set enabled
     *
     * @param boolean $solvencyEnabled
     */
    public function setSolvencyEnabled($solvencyEnabled)
    {
        $this->solvencyEnabled = $solvencyEnabled;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getSolvencyEnabled()
    {
        return $this->solvencyEnabled;
    }

    public function getSalePdmSparepart()
    {
        return $this->salePdmSparepart;
    }

    public function setSalePdmSparepart($salePdmSparepart)
    {
        $this->salePdmSparepart = $salePdmSparepart;

        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getSalePdmSparepartActivationDate()
    {
        return $this->salePdmSparepartActivationDate;
    }

    /**
     *
     * @param \DateTime $salePdmSparepartActivationDate
     * @return Distributor
     */
    public function setSalePdmSparepartActivationDate(\DateTime $salePdmSparepartActivationDate)
    {
        $this->salePdmSparepartActivationDate = $salePdmSparepartActivationDate;

        return $this;
    }

    public function getCommercialName()
    {
        return $this->commercialName ? $this->commercialName : $this->getCompany();
    }

    public function setCommercialName($commercialName)
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    /**
     * Set centralized billing distributor
     * @param integer $centralizedBillingDistributor
     * @return Distributor $this
     */
    public function setCentralizedBillingDistributor($centralizedBillingDistributor)
    {
        $this->centralizedBillingDistributor = $centralizedBillingDistributor;

        return $this;
    }

    /**
     * Get centralized billing distributor
     * @return integer
     */
    public function getCentralizedBillingDistributor()
    {
        return $this->centralizedBillingDistributor;
    }

    /**
     *  Set additional markup
     * @param boolean $additionalMarkup
     * @return Distributor $this
     */
    public function setAdditionalMarkup($additionalMarkup)
    {
        $this->additionalMarkup = $additionalMarkup;

        return $this;
    }

    /**
     * Get additional markup
     * @return boolean
     */
    public function getAdditionalMarkup()
    {
        return $this->additionalMarkup;
    }

    /**
     * Set additional markup value
     * @param float $additionalMarkupValue
     * @return Distributor $this
     */
    public function setAdditionalMarkupValue($additionalMarkupValue)
    {
        $this->additionalMarkupValue = round(floatval(str_replace(',', '.', $additionalMarkupValue)) * 1000) / 1000;

        return $this;
    }

    /**
     * Get additional markup value
     * @return float
     */
    public function getAdditionalMarkupValue()
    {
        return $this->additionalMarkupValue;
    }

    /**
     * @return int
     */
    public function getBatterySaleCondition()
    {
        return $this->batterySaleCondition;
    }

    /**
     * @param int $batterySaleCondition
     */
    public function setBatterySaleCondition($batterySaleCondition)
    {
        $this->batterySaleCondition = $batterySaleCondition;
    }

    /**
     * Get threshold amount HT used to calculate oils delivery fee
     * @return float
     */
    public function getOilsThresholdAmountHt()
    {
        return $this->oilsThresholdAmountHt;
    }

    /**
     * Set threshold amount HT used to calculate oils delivery fee
     * @param float $oilsThresholdAmountHt
     */
    public function setOilsThresholdAmountHt($oilsThresholdAmountHt)
    {
        $this->oilsThresholdAmountHt = $oilsThresholdAmountHt;
    }

    /**
     * Get threshold amount Liter used to calculate oils delivery fee
     * @return float
     */
    public function getOilsThresholdAmountLitre()
    {
        return $this->oilsThresholdAmountLitre;
    }

    /**
     * Set threshold amount Litre used to calculate oils delivery fee
     * @param float $oilsThresholdAmountLiter
     */
    public function setOilsThresholdAmountLitre($oilsThresholdAmountLitre)
    {
        $this->oilsThresholdAmountLitre = $oilsThresholdAmountLitre;
    }

    /**
     * Get oils delivery fee to apply if order amount HT is less than oils threshold amount HT
     * @return float
     */
    public function getOilsDeliveryFee()
    {
        return $this->oilsDeliveryFee;
    }

    /**
     * Set oils delivery fee to apply if order amount HT is less than oils threshold amount HT
     * @param float $oilsDeliveryFee oils delivery fee HT
     */
    public function setOilsDeliveryFee($oilsDeliveryFee)
    {
        $this->oilsDeliveryFee = $oilsDeliveryFee;
    }

    /**
     * Get tgap enabled
     * @return boolean true if tgap is enabled, false otherwise
     */
    public function getTgapEnabled()
    {
        return $this->tgapEnabled;
    }

    /**
     * Set tgap enabled
     * @param boolean $tgapEnabled true or false depending on whether it is enabled or not
     */
    public function setTgapEnabled($tgapEnabled)
    {
        $this->tgapEnabled = $tgapEnabled;
    }

    /**
     * Get acceptFinancialRisk enabled
     * @return boolean true if acceptFinancialRisk is enabled, false otherwise
     */
    public function isAcceptFinancialRisk()
    {
        return $this->acceptFinancialRisk;
    }

    /**
     * Set acceptFinancialRisk enabled
     * @param boolean acceptFinancialRisk true or false depending on whether it is enabled or not
     */
    public function setAcceptFinancialRisk($acceptFinancialRisk)
    {
        $this->acceptFinancialRisk = $acceptFinancialRisk;
    }


    /**
     * @return string
     */
    public function getlubricantDeliveryType()
    {
        return $this->lubricantDeliveryType;
    }

    /**
     * @param $lubricantDeliveryType
     */
    public function setLubricantDeliveryType($lubricantDeliveryType)
    {
        $this->lubricantDeliveryType = $lubricantDeliveryType;
    }

    /**
     * @return int
     */
    public function getCentralizedBillingFrs(): ?int
    {
        return $this->centralizedBillingFrs;
    }

    /**
     * @param int $centralizedBillingFrs
     * @return Distributor
     */
    public function setCentralizedBillingFrs(?int $centralizedBillingFrs): Distributor
    {
        $this->centralizedBillingFrs = $centralizedBillingFrs;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUseCheckoutCb(): bool
    {
        return $this->useCheckoutCb;
    }

    /**
     * @return int
     */
    public function getMarkupSparePartType(): int
    {
        return $this->markupSparepartType ? $this->markupSparepartType : 0;
    }

    /**
     * @param bool $useCheckoutCb
     * @return Distributor
     */
    public function setUseCheckoutCb(bool $useCheckoutCb)
    {
        $this->useCheckoutCb = $useCheckoutCb;
        return $this;
    }

    /**
     * @return bool
     */
    public function getUseCheckoutSepa(): bool
    {
        return $this->useCheckoutSepa;
    }

    /**
     * @param bool $useCheckoutSepa
     * @return Distributor
     */
    public function setUseCheckoutSepa(bool $useCheckoutSepa): Distributor
    {
        $this->useCheckoutSepa = $useCheckoutSepa;
        return $this;
    }

    /**
     * @return Distributor|null
     */
    public function getCentralizedBillingDistributorCustomer(): ?Distributor
    {
        return $this->centralizedBillingDistributorCustomer;
    }

    /**
     * @param Distributor|null $centralizedBillingDistributorCustomer
     * @return Distributor
     */
    public function setCentralizedBillingDistributorCustomer(?Distributor $centralizedBillingDistributorCustomer
    ): Distributor {
        $this->centralizedBillingDistributorCustomer = $centralizedBillingDistributorCustomer;
        return $this;
    }

    /**
     * @return Distributor|null
     */
    public function getCentralizedBillingDistributorDistributor(): ?Distributor
    {
        return $this->centralizedBillingDistributorDistributor;
    }

    /**
     * @param Distributor|null $centralizedBillingDistributorDistributor
     * @return Distributor
     */
    public function setCentralizedBillingDistributorDistributor(?Distributor $centralizedBillingDistributorDistributor
    ): Distributor {
        $this->centralizedBillingDistributorDistributor = $centralizedBillingDistributorDistributor;

        return $this;
    }

    public function getDistributorToUseForCustomerBilling(){

        return $this->centralizedBillingDistributorCustomer instanceof Distributor
            ? $this->centralizedBillingDistributorCustomer : $this;
    }

    /**
     * Set ranking_version
     *
     * @param string $ranking_version
     */
    public function setRankingVersion(string $ranking_version)
    {
        $this->ranking_version = $ranking_version;
    }

    /**
     * Get ranking_version
     *
     * @return string
     */
    public function getRankingVersion()
    {
        return $this->ranking_version;
    }
    
    /**
     * @return mixed
     */
    public function getConfigCheckout()
    {
        return $this->configCheckout;
    }

    /**
     * @param mixed $configCheckout
     */
    public function setConfigCheckout($configCheckout): void
    {
        $this->configCheckout = $configCheckout;
    }



    public function getGeneralCondition()
    {
        return $this->generalCondition;
    }
    public function setGeneralCondition($general)
    {
        return $this->generalCondition = $general;
    }

    /**
     * @return int
     */
    public function getDistri2b(): int
    {
        return $this->distri2b ? $this->distri2b : 0;
    }

    /**
     * Set distri2b enabled
     * @param int distri2b true or false depending on whether it is enabled or not
     */
    public function setDistri2b($distri2b)
    {
        $this->distri2b = $distri2b;
    }

    /**
     * @return int
     */
    public function getMarkupTyreType(): int
    {
        return $this->markupTyreType ? $this->markupTyreType : 0;
    }


    /**
     * Set Markup Tyre Type
     * @param int markupTyreType
     */
    public function setMarkupTyreType($markupTyreType)
    {
        $this->markupTyreType = $markupTyreType;
    }

      /**
     * Set Markup Tyre Type
     * @param int markupSparepartType
     */
    public function setMarkupSparepartype($markupSparepartType)
    {
        $this->markupSparepartType = $markupSparepartType;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }
}
