<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchingTheEntireIndex extends AbstractController
{

    public $finder;

    public function __construct(\App\Service\MyFinderInterface $finderInterface)
    {
        $this->finder = $finderInterface;
    }

    #[Route('/testEntireIndex', name: 'app_testEntireIndex')]
    public function testEntireIndex(Request $request): Response
    {

        dump($this->finder->find('bob'));die;
        /** var FOS\ElasticaBundle\Finder\MappedFinder */
        // $finder = $this->container->get('fos_elastica.finder.app');

        // // Returns a mixed array of any objects mapped
        // $results = $finder->find('bob');
        // dump($results);
        // die;
    }
}
