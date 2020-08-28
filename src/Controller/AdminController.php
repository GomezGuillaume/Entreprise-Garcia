<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route ("/images/insert",name="admin_image_insert")
     */
    public function AdminImageInsert(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger)
    {
        $image = new Image();
        $imageForm = $this->createForm(ConfigType::class,$image);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted() && $imageForm->isValid()){
            $configCoverFile = $imageForm->get('configCover')->getData();

            if($configCoverFile){
                $originalCoverName = pathinfo($configCoverFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeCoverName = $slugger->slug($originalCoverName);
                $uniqueCoverName = $safeCoverName .'-'. uniqid() . '.' . $configCoverFile->guessExtension();

                try{
                    $configCoverFile->move(
                        $this->getParameter('config_cover_directory'),
                        $uniqueCoverName
                    );
                } catch (FileException $e){
                    return new Response($e->getMessage());
                }
                $config->setConfigCover($uniqueCoverName);
            }
            $entityManager->persist($image);
            $entityManager->flush();
            $this->addFlash('success', "L'image a bien été ajouté !");
            return $this->redirectToRoute('admin_image_insert');
        }
        return $this->render('admin/admin_image_insert.html.twig',
            ['imageForm'=>$imageForm->createView()]);
    }


    /**
     * @Route ("/images/delete/{id}",name="admin_image_delete")
     */

    public function AdminImageDelete(
        ImageRepository $imageRepository,
        EntityManagerInterface $entityManager,
        $id){

        //je fais appel a la methode repository de config pour pouvoir selectionner l'id de ma config
        //que je veux supprimer
        $image = $imageRepository->find($id);

        //j'utilise le remove de l'entityManager pour supprimer la config de l'id 1 ici
        $entityManager->remove($image);
        $entityManager->flush();

        return $this->redirectToRoute('admin_image_insert');
    }

}
