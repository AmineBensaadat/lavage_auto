<?php

namespace App\Controller;

use App\Service\MyFinderInterface;
use Elastica\Util;
use FOS\ElasticaBundle\Finder\FinderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchingwithFinder extends AbstractController
{
    private $finder;

    public function __construct(MyFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    #[Route('/SearchingwithFinder', name: 'app_test')]
    public function index(Request $request): Response
    {
        // Option 1. Returns all users who have example.net in any of their mapped fields
        $results = $this->finder->find('example.net');
        dump($results);
        echo "test";
        die;
    }

    #[Route('/TransformedFinder ', name: 'app_TransformedFinder')]
    public function TransformedFinder (TransformedFinder $oilsDistributorVolumeFinder)
    {
        $search = Util::escapeTerm("75");
        
        $result = $oilsDistributorVolumeFinder->findHybrid($search, 30);
        
        dump($result);
        die;
    }

    
    #[Route('/myFindTest ', name: 'app_myFindTest')]
    public function myFindTest (TransformedFinder $oilsDistributorVolumeFinder)
    {
        $finder = $oilsDistributorVolumeFinder;
        $boolQuery = new \Elastica\Query\BoolQuery();

        $fieldQuery = new \Elastica\Query\MatchQuery();
        $fieldQuery->setFieldQuery('target', '75');
        //$fieldQuery->setFieldParam('quantity', 'analyzer', 'my_analyzer');
        $boolQuery->addShould($fieldQuery);

        // $tagsQuery = new \Elastica\Query\Terms('tags', ['tag1', 'tag2']);
        // $boolQuery->addShould($tagsQuery);

        // $categoryQuery = new \Elastica\Query\Terms('categoryIds', ['1', '2', '3']);
        // $boolQuery->addMust($categoryQuery);

        $data = $finder->find($boolQuery);
        dump($data);
        die;
    }

    
}
