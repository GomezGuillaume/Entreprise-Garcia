<?php

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function new(Request $request): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // je récupère l'image uploadée
            $MediaCoverFile = $form->get('name')->getData();

            if ($form) {

                // je récupère le nom de l'image
                $originalImageName = pathinfo($form->getClientOriginalName(), PATHINFO_FILENAME);

                // et grâce à son nom original, je gènère un nouveau qui sera unique
                // pour éviter d'avoir des doublons de noms d'image en BDD
                $safeCoverName = $slugger->slug($originalImageName);
                $uniqueCoverName = $safeCoverName . '-' . uniqid() . '.' . $form->guessExtension();

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
                $medium->move(
                    $this->getParameter('peinture'),
                    $uniquePeintureName
                );
            } catch (FileException $e) {
                return new Response($e->getMessage());
            }


            // je sauvegarde dans la colonne bookCover le nom de mon image
            $medium->setNameCover($uniquePeintureName);
        }

            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    public function AdminInsertBook(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        // je créé une nouvelle instance de l'entité Book
        $medium = new Media();

        // je récupère le gabarit de formulaire de
        // l'entité Book, créé avec la commande make:form
        // et je le stocke dans une variable $bookForm
        $bookForm = $this->createForm(BookType::class, $book);

        // on prend les données de la requête (classe Request)
        //et on les "envoie" à notre formulaire
        $bookForm->handleRequest($request);

        // si le formulaire a été envoyé et que les données sont valides
        // par rapport à celles attendues alors je persiste le livre
        if ($bookForm->isSubmitted() && $bookForm->isValid() ) {


            // vu que le champs bookCover de mon formulaire est en mapped false
            // je gère moi même l'enregistrment de la valeur de cet input
            // https://symfony.com/doc/current/controller/upload_file.html

            // je récupère l'image uploadée
            $bookCoverFile = $bookForm->get('bookCover')->getData();

            // s'il y a bien une image uploadée dans le formulaire
            if ($bookCoverFile) {

                // je récupère le nom de l'image
                $originalCoverName = pathinfo($bookCoverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // et grâce à son nom original, je gènère un nouveau qui sera unique
                // pour éviter d'avoir des doublons de noms d'image en BDD
                $safeCoverName = $slugger->slug($originalCoverName);
                $uniqueCoverName = $safeCoverName . '-' . uniqid() . '.' . $bookCoverFile->guessExtension();


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
                    $bookCoverFile->move(
                        $this->getParameter('book_cover_directory'),
                        $uniqueCoverName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }


                // je sauvegarde dans la colonne bookCover le nom de mon image
                $book->setBookCover($uniqueCoverName);
            }

            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'Votre livre a été créé !');

            return $this->redirectToRoute('admin_books');
        }

        // je retourne mon fichier twig, en lui envoyant
        // la vue du formulaire, générée avec la méthode createView()
        return $this->render('admin/admin_book_insert.html.twig', [
            'bookForm' => $bookForm->createView()
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
    public function edit(Request $request, Media $medium): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
