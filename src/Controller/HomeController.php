<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;


class HomeController extends AbstractController
{
    public function index(Request $request): Response
    {

        

        return $this->render('site/home/home.html.twig', [
            'n' => $this->aboutText()
        ]);
    }

    public function spotify()
    {
        /*
            $session = new Session(
            '804054b8a3c24b9dbf699c19857419d0',
            'f86933907e814e8186916fa7d2803f19',
            'REDIRECT_URI'
            );
        
        $api = new SpotifyWebAPI();
        
        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());
            
            print_r($api->me());
        } else {
            $options = [
                'scope' => [
                    'user-read-email',
                ],
            ];
            
            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
        */
        return $this->redirectToRoute('home');
    }
	
	private function randPhrases() :string
    {
        $phrases = [
            'Welcome',
            'mais qualquer coisa',
            'uma outra frase tonta'
        ];
      #  var_dump($phrases[0] ); die();
        $rand = rand(0, (count($phrases)-1));
    
        return $phrases[$rand];
    }

    private function aboutText() :string
    {
        return "Hello, I'm Pedro Data, and I live in Lisbon. I have a degree in Industrial Design at IADE, and I am web developer with more than 6 years of experience .  
My career as a programmer has always sought new challenges. Even though I am focused on web technologies, I prefer to develop backend in php language, particularly Object Oriented Programming (OOP), never neglecting the technological innovations that the frontend has been presenting .  
Over the years, as a way to keep myself up to date and to improve my skills, I attended and completed several courses in schools like LxSchool (php , MySQL) or Altalógica ( PHP OOP , Java ), and also acquired basic knowledge on C++ and Java as an autodidact . My interest on information technology encourages me to search for new challenges.  ";
    }


    public function about(Request $request): Response
    {

        return $this->render('site/home/about.html.twig', [
            'n' => $this->aboutText()
        ]);
    }

    public function cv(Request $request): Response
    {

        return $this->render('site/home/cv.html.twig', [
            'n' => $this->randPhrases()
        ]);
    }

    public function contact(Request $request): Response
    {

        return $this->render('site/home/contact.html.twig', [
            'n' => $this->randPhrases()
        ]);
    }
}
