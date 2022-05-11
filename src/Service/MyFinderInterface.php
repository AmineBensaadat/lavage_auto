<?php

namespace App\Service;

use FOS\ElasticaBundle\Finder\FinderInterface;

class MyFinderInterface implements FinderInterface
{

    public function find($query, ?int $limit = null, array $options = []){}
}