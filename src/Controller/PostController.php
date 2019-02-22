<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;

class PostController extends AbstractController
{
    /**
     * @Route("/post/new", name="new_post")
     */
    public function newPost( Request $request )
    {
        $post = new Post();
        
        $form = $this->createForm(PostType::class, $post);
        
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $post = $form->getData();
            
            $usr = $this->get('security.token_storage')->getToken()->getUser();
            // TO DO
            
            $post->setCreatedAt(new \DateTime());
            $post->setAuthor($usr->getUsername());
            $post->setUser($usr);
            $post->setStatus("draft");
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash( 'success', 'Post created' );
            return $this->redirectToRoute('app_homepage');
        }
        
        return $this->render('post/newpost.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
