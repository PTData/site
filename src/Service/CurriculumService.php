<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;

class CurriculumService 
{

	public function __construct
	(
		protected EntityManagerInterface $entityManager
	) {}

	public function get() :array
	{
		$all = $this->entityManager->getRepository(Client::class)->getAll();

		foreach ($all as $key => $value) {
			
			if(isset($value['tech']) === true) {
				$term = explode(',',$value['tech']);
				$all[$key]['technologies']['term'] = $term;
				
			}

			if(isset($value['icon']) === true) {
				$all[$key]['technologies']['awsome'] = explode(',',$value['icon']);
			}
		}

		// put techs in an array
		return $all;
	}
	
}
