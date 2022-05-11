<?php

namespace App\Controller;

use App\Service\MyFinderInterface;
use Elastica\Query\Terms;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdvancedSearchingExample extends AbstractController
{
    
    private $finder;

    public function __construct(MyFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    #[Route('/AdvancedSearchingExample', name: 'app_AdvancedSearchingExample')]
    public function index(Request $request): Response
    {
        // Option 1. Returns all users who have example.net in any of their mapped fields
        $results = $this->finder->find('p');

        dump($results);die;
        $finder = $this->finder; //$this->container->get('fos_elastica.finder.app.distributor');
        // dump($finder);
        // die;
        $boolQuery = new \Elastica\Query\BoolQuery();

        $fieldQuery = new \Elastica\Query\MatchQuery();
        $fieldQuery->setFieldQuery('designation', 'p');
        $fieldQuery->setFieldParam('designation', 'analyzer', 'my_analyzer');
        $boolQuery->addShould($fieldQuery);

        // $tagsQuery = new \Elastica\Query\Terms('tags', ['tag1', 'tag2']);
        // $boolQuery->addShould($tagsQuery);

        // $categoryQuery = new \Elastica\Query\Terms('categoryIds', ['1', '2', '3']);
        // $boolQuery->addMust($categoryQuery);
        // dump($boolQuery);
        // die;
        $data = $finder->find($boolQuery);
        dump($data);
        die;
    }
}
