<?php

namespace App\Controller;

use App\Service\MyFinderInterface;
use FOS\ElasticaBundle\Finder\FinderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
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
}
