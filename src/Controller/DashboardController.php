<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Movie;
use App\Entity\Order;
use App\Form\MovieFormType;
use App\Form\OrderType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DashboardController extends AbstractController
{
    private $em;
    private $movieRepository;

    /**
     * @var string
     */
    protected $baseUrl;
    public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository, RequestStack $requestStack) 
    {
        $this->em = $em;
        $this->movieRepository = $movieRepository;
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $dashboard = $this->movieRepository->findAll();
        $order = new Order();
        $order_form = $this->createForm(OrderType::class, $order, 
        ['attr' => [
            'id' => 'order_form',
            'action' => $this->baseUrl.'/saveOrder'
            ]]);
     
        $user = $this->getUser();
        $roles = $user->getRoles();
        $chekisadmin = $user->isSuperAdmin();
     
        // dump($user, $roles, $chekisadmin);
        // die;
        return $this->renderForm('dashboard/index.html.twig', [
            'dashboard' => $dashboard,
            'order_form' => $order_form
        ]);
    }
    
    #[Route('/saveOrder', name: 'saveOrder')]
    public function saveOrder(Request $request): Response {
        $order = new Order();
      
        $order_form = $this->createForm(OrderType::class, $order);
        $order_form->handleRequest($request);

        if ($order_form->isSubmitted() && $order_form->isValid()) {
            // get all requests orders
            $requests_orders = $request->request->all()["order"];

            dump($requests_orders);
            die;
           // set the data
        }
    }

    #[Route('/dashboard/create', name: 'create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();
            
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newMovie->setUserId($this->getUser()->getId());
                $newMovie->setImagePath('/uploads/' . $newFileName);
            }

            $this->em->persist($newMovie);
            $this->em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/dashboard/edit/{id}', name: 'edit_movie')]
    public function edit($id, Request $request): Response 
    {
        $this->checkLoggedInUser($id);
        $movie = $this->movieRepository->find($id);

        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($movie->getImagePath() !== null) {
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath()
                        )) {
                            $this->GetParameter('kernel.project_dir') . $movie->getImagePath();
                    }
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                    try {
                        $imagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                    $movie->setImagePath('/uploads/' . $newFileName);
                    $this->em->flush();

                    return $this->redirectToRoute('dashboard');
                }
            } else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseYear($form->get('releaseYear')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('dashboard');
            }
        }

        return $this->render('dashboard/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    #[Route('/dashboard/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_movie')]
    public function delete($id): Response
    {
        $this->checkLoggedInUser($id);
        $movie = $this->movieRepository->find($id);
        $this->em->remove($movie);
        $this->em->flush();

        return $this->redirectToRoute('dashboard');
    }

    #[Route('/dashboard/{id}', methods: ['GET'], name: 'show_movie')]
    public function show($id): Response
    {
        $movie = $this->movieRepository->find($id);
        
        return $this->render('dashboard/show.html.twig', [
            'movie' => $movie
        ]);
    }

    private function checkLoggedInUser($movieId) {
        if($this->getUser() == null || $this->getUser()->getId() !== $movieId) {
            return $this->redirectToRoute('dashboard');
        }
    }
}
