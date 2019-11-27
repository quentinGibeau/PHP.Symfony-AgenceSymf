<?php
    namespace App\Controller;

    use App\Repository\BienRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class HomeController extends AbstractController {

        /**
         * @Route("/", name="home.index")
         * @param BienRepository $bienRepository
         * @return Response
         */
        public function index(BienRepository $bienRepository) : Response{

            $bien = $bienRepository->findLatest();

            // Grâce au méthode de AbstractController nous pouvons récupérer la vue via la méthode render()
            return $this->render('pages/home.html.twig', [
                'propriete' => $bien
            ]);
        }

    }