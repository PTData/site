<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Car;
use App\Entity\Image;
use App\Entity\Value;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CarrosController extends AbstractController
{
	public function __construct(
		protected EntityManagerInterface $entityManager
	) {
		#phpinfo();
	}
	
	public function index()
	{
		$cars = $this->entityManager->getRepository(Car::class)->getAll();
#		dd($cars);
        return $this->render('car/list.html.twig', [
			'title' => 'All Cars',
			'cars' => $cars,
			'navegation' => $this->setNavegation(),
			'imageFolder' => '../upload/images',
		]);
	}

	private function setNavegation() :array
	{
		return [
			'add' => $this->generateUrl('carro_add'),
			'cars' => $this->generateUrl('cars')
		];
	}
	
	public function edit(int $id, Request $request)
	{
		$car = $this->entityManager->getRepository(Car::class)->find($id);

		$form = $this->createFormBuilder()
		#$form = $this->createFormBuilder($car)
			->add('brand', TextType::class, ['label' => 'Brand', 'attr' => ['value' => $car->getBrand()]])
		    ->add('model', TextType::class, ['label' => 'Model', 'attr' => ['value' => $car->getModel()]])
			->add('fuel', TextType::class, ['label' => 'Fuel', 'attr' => ['value' => $car->getFuel()]])
			->add('cc', IntegerType::class, ['label' => 'CC', 'attr' => ['value' => $car->getCc()]])
			->add('co2', IntegerType::class, ['label' => 'Co2', 'attr' => ['value' => $car->getCo2()]])
			->add('consume', NumberType::class, ['label' => 'Consumo', 'attr' => ['value' => $car->getConsume()]])
			->add('notes', TextareaType::class, ['label' => 'Notas', 'data' => $car->getNotes()])
			->add('attachment', FileType::class, [
                'label' => 'Car Image',
				'required' => false,
            ])
			
			->add('save', SubmitType::class, ['label' => 'Add Car'])
		    ->getForm();

		    $this->hasSubmited($form, $request, $car);


        return $this->render('car/edit.html.twig', [
			'title' => 'Edit Car',
			'form' => $form,
			'navegation' => $this->setNavegation()
		]);
	}

	private function hasSubmited($form, Request $request, ?Car $car)
	{
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

			$data = $form->getData();
			$file = $form['attachment']->getData();
        	#$file->move($directory, $someNewFilename);
        	#dump($file);
        	#dump($form['attachment']);

			$car = (null !== $car) ? $car : new Car;
			$car->setBrand($data['brand']);
			$car->setModel($data['model']);
			$car->setFuel($data['fuel']);
			$car->setCc($data['cc']);
			$car->setCo2($data['co2']);
			$car->setConsume($data['consume']);

			$this->entityManager->persist($car);
			$this->entityManager->flush();

			if(isset($file) === true) {

				$originalFilename = pathinfo($file->getPath(), PATHINFO_FILENAME);
                
                $newFilename = uniqid().'.'.$file->guessExtension();

				$image = new Image;
				$image->setCar($car);
				$image->setUrl($newFilename);
				$image->setDescription('Something here');
				$this->entityManager->persist($image);   
                $this->entityManager->flush();

                try {

                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                    
                } catch (FileException $e) {
                	dd($e->getMessage());
                    // ... handle exception if something happens during file upload
                }
			}

		    return new Response('Car added successfuly.');
		}
	}
	
	public function show(int $id)
	{
		$car = $this->entityManager->getRepository(Car::class)->find($id);
		$images = $this->entityManager->getRepository(Image::class)->findByCarField($id);
		$values = $this->entityManager->getRepository(Value::class)->findByCarField($id);

        return $this->render('car/show.html.twig', [
			'title' => 'show Car',
			'car' => $car,
			'values' => $values,
			'navegation' => $this->setNavegation(),
			'imageFolder' => '../../../upload/images',
			'images' => $images
		]);
	}
	
	public function add(EntityManagerInterface $entityManager, Request $request)
	{
		$car = new Car();
		
		$form = $this->createFormBuilder($car)
			->add('brand', TextType::class, ['label' => 'Brand', 'label_attr' => [
        		'class' => '',
    		]])
		    ->add('model', TextType::class, ['label' => 'Model'])
			->add('fuel', TextType::class, ['label' => 'Fuel'])
			->add('cc', IntegerType::class, ['label' => 'CC'])
			->add('co2', IntegerType::class, ['label' => 'Co2'])
			->add('consume', NumberType::class, ['label' => 'Consumo'])
			->add('shifts', NumberType::class, ['label' => 'Shifts'])
			->add('image', FileType::class, [
                'label' => 'Car Image',
                'mapped' => false,
                'required' => false,
            ])
			
			->add('save', SubmitType::class, ['label' => 'Add Car'])
		    ->getForm();

		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {

			$data = $form->getData();

			$car = new Car;
			
			$car->setBrand($data->getBrand());
			$car->setModel($data->getModel());
			$car->setFuel($data->getFuel());
			$car->setCc($data->getCc());
			$car->setCo2($data->getCo2());
			$car->setConsume($data->getConsume());
			$car->setShifts($data->getShifts());
			
			
			$this->entityManager->persist($car);
			$this->entityManager->flush();

			if(isset($data['image']) === true) {

				$originalFilename = pathinfo($data['image']->getPath(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                $entityFileManager = $this->getDoctrine()->getManager();
				$image = new Image;
				$image->setCar($car->getId());
				$image->setUrl($safeFilename);
				$entityFileManager->persist($image);   
                $entityFileManager->flush();
			}

		    return new Response('Rider added successfuly to the Team');
		}
		
		return $this->render('car/add.html.twig', [
			'title' => 'Add Car',
			'form' => $form,
			'navegation' => $this->setNavegation()
		]);
		
	}
}
