<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\Media1Type;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/", name="media_index", methods={"GET"})
     */
    public function index(MediaRepository $mediaRepository): Response
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="media_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $medium = new Media();
        $form = $this->createForm(Media1Type::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // je récupère l'image uploadée
            $MediaCoverFile = $form->get('name')->getData();

            if ($MediaCoverFile) {

                // je récupère le nom de l'image
                $originalImageName = pathinfo($MediaCoverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // et grâce à son nom original, je gènère un nouveau qui sera unique
                // pour éviter d'avoir des doublons de noms d'image en BDD
                $safeName = $slugger->slug($originalImageName);
                $uniquePeintureName = $safeName . '-' . uniqid() . '.' . $MediaCoverFile->guessExtension();

                $entityManager = $this->getDoctrine()->getManager();

                // j'utilise un bloc de try and catch
                // qui agit comme une conditions, mais si le bloc try échoue, ça
                // soulève une erreur, qu'on peut gérer avec le catch
                try {

                    // je prends l'image uploadée
                    // et je la déplace dans un dossier (dans public) + je la renomme avec
                    // le nom unique générée
                    // j'utilise un parametre (défini dans services.yaml) pour savoir
                    // dans quel dossier je la déplace
                    // un parametre = une sorte de variable globale
                    $MediaCoverFile->move(
                        $this->getParameter('peinture'),
                        $uniquePeintureName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }


                // je sauvegarde dans la colonne MediaCover le nom de mon image
                $medium->setName($uniquePeintureName);
            }



            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->redirectToRoute('media_index');

            $this->addFlash('success', "L'image a bien été uploadé");
        }

        return $this->render('media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_show", methods={"GET"})
     */
    public function show(Media $medium): Response
    {
        return $this->render('media/show.html.twig', [
            'medium' => $medium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="media_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Media $medium, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Media1Type::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $MediaCoverFile = $form->get('name')->getData();

            if ($MediaCoverFile) {

                // je récupère le nom de l'image
                $originalImageName = pathinfo($MediaCoverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // et grâce à son nom original, je gènère un nouveau qui sera unique
                // pour éviter d'avoir des doublons de noms d'image en BDD
                $safeName = $slugger->slug($originalImageName);
                $uniquePeintureName = $safeName . '-' . uniqid() . '.' . $MediaCoverFile->guessExtension();

                $entityManager = $this->getDoctrine()->getManager();

                // j'utilise un bloc de try and catch
                // qui agit comme une conditions, mais si le bloc try échoue, ça
                // soulève une erreur, qu'on peut gérer avec le catch
                try {

                    // je prends l'image uploadée
                    // et je la déplace dans un dossier (dans public) + je la renomme avec
                    // le nom unique générée
                    // j'utilise un parametre (défini dans services.yaml) pour savoir
                    // dans quel dossier je la déplace
                    // un parametre = une sorte de variable globale
                    $MediaCoverFile->move(
                        $this->getParameter('peinture'),
                        $uniquePeintureName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }


                // je sauvegarde dans la colonne MediaCover le nom de mon image
                $medium->setName($uniquePeintureName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Media $medium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('media_index');
    }
}
