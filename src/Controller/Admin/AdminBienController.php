<?php

    namespace App\Controller\Admin;

    use App\Entity\Bien;
    use App\Form\BienType;
    use App\Repository\BienRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class AdminBienController extends AbstractController{

        /**
         * @var BienRepository
         */
        private $bienRepository;

        /**
         * @var EntityManagerInterface
         */
        private $em;

        public function __construct(BienRepository $bienRepository, EntityManagerInterface $em)
        {
            $this->bienRepository = $bienRepository;
            $this->em = $em;
        }

        /**
         * @Route("/admin", name="admin.bien.index")
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function index(){
           $bien = $this->bienRepository->findAll();

           return $this->render('admin/bien/index.html.twig', compact('bien'));
        }

        /**
         * @Route("/admin/bien/creer", name="admin.bien.new")
         */
        public function new(Request $request){
            $bien = new Bien();
            $form = $this->createForm(BienType::class, $bien);
            $form->handleRequest($request);

            // Pas de grosse vérification mais on regarde SI le formulaire a était "submitted" ET valide
            if($form->isSubmitted() && $form->isValid()){
                $this->em->persist($bien);
                // flush pour lancer les changements vers ma BDD
                $this->em->flush();
                $this->addFlash('sucess', "Création effectuée");

                return $this->redirectToRoute('admin.bien.index');
            }

            return $this->render('admin/bien/new.html.twig', [
                'bien' => $bien,
                'form' => $form->createView()
            ]);
        }

        /**
         * @Route("/admin/bien/{id}", name="admin.bien.edit", methods={"GET|POST"})
         * @param Bien $bien
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function edit(Bien $bien, Request $request){
            $form = $this->createForm(BienType::class, $bien);
            $form->handleRequest($request);

            // Pas de grosse vérification mais on regarde SI le formulaire a était "submitted" ET valide
            if($form->isSubmitted() && $form->isValid()){
                // flush pour lancer les changements vers ma BDD
                $this->em->flush();
                // addFlash() retourne sur la vue une message de Type et une chaine de caractère
                $this->addFlash('sucess', "Modification effectuée");

                return $this->redirectToRoute('admin.bien.index');
            }

            return $this->render('admin/bien/edit.html.twig', [
                'bien' => $bien,
                'form' => $form->createView()
            ]);
        }

        /**
         * @Route("/admin/bien/{id}", name="admin.bien.delete", methods={"DELETE"})
         * @param Bien $bien
         * @return \Symfony\Component\HttpFoundation\RedirectResponse
         */
        public function delete(Bien $bien, Request $request){

          //  if($this->isCsrfTokenValid('delete', $bien->getId(), $request->get('_token'))){
               //   return new Response('Suppression');
                $this->em->remove($bien);
                $this->em->flush();
            $this->addFlash('sucess', "Suppression effectuée");


            //  }
            return $this->redirectToRoute('admin.bien.index');

        }
    }