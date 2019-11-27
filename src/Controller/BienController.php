<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BienController extends AbstractController {

    /**
     * @var BienRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(BienRepository $bienRepository, EntityManagerInterface $em)
{
    $this->repository = $bienRepository;
    $this->em = $em;
}

    // Anotation @Route pour retourner le chemin, et définir le nom pour le block path() dans le href
    /**
     * @Route("/biens", name="bien.index")
     * @return Response
     */
    public function index(): Response{

      /*  $bien = new bien();
        $bien->setTitle('Appart A')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription("Petite description")
            ->setSurface(60)
            ->setFloor(44)
            ->setHeat(1)
            ->setCity('Nice')
            ->setAddress('Rue Promenade des Anglais')
            ->setPostalCode('06000');

        // on instanci un objet de ObjectManager
        $em = $this->getDoctrine()->getManager();
        $em->persist($bien);
        // flush() apporte les changements vers la BDD
        $em->flush();*/

      // VIA INJECTION
      /*  $bienRepository = $this->getDoctrine()->getRepository(bien::class);
        dump($bienRepository);*/

       // $bien = $this->repository->findAllVisible();
        return $this->render('bien/index.html.twig', [
            'active_menu' => 'bien'
        ]);
    }

    /**
     * @Route("/bien/{slug}-{id}", name="bien.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Bien $bien
     * @return Response
     */

    public function show(Bien $bien, string $slug): Response{

        if($bien->getSlug() !== $slug){
            return $this->redirectToRoute('bien.show', [
                'id' => $bien->getId(),
                'slug' => $bien->getSlug()
                // status 301 pour une redirection permanente
            ], 301);
        }
        // envoi des propriétés à la vue
        return $this->render('bien/show.html.twig', [
            'propriete' => $bien,
            'active_menu' => 'bien'
        ]);
    }

}