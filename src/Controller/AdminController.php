<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comentario;
use App\Entity\Tag;
use App\Form\AdminUserType;
use App\Form\AdminUpdUserType;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin(){
        return $this->render( 'admin/index.html.twig' );
    }
    
    /**
     * @Route("/admin/users", name="app_admin_users")
     */
    public function users_view(){
        $users=$this->getDoctrine()->getRepository( User::class )->findAll();
        
        return $this->render( 'admin/users.html.twig', ['users' => $users] );
    }
    
    /**
     * @Route("/admin/users/new", name="app_admin_new_user")
     */
    public function new_user( Request $request, UserPasswordEncoderInterface $passwdEncode ){
        $user = new User();
        $user->setisActive(true);
        
        $form = $this->createForm(AdminUserType::class, $user);
        
        $form->handleRequest($request);
        $error = $form->getErrors();
        
        if( $form->isSubmitted() && $form->isValid() ){
            $passwd = $passwdEncode->encodePassword( $user, $user->getPlainPassword() );
            $user->setPassword($passwd);
            $user->setRoles([$request->request->get('roles')]);
            // Manejo de las entidades
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash( 'success', 'User created' );
            return $this->redirectToRoute('app_admin_users');
        }
        //render the form
        return $this->render( 'admin/regform.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }
    
    /**
     * @Route("/admin/users/delete/{id}", name="app_admin_delete_user")
     */
    public function delete_user( $id ){
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash( 'success', 'User deleted' );
        return $this->redirectToRoute('app_admin_users');
    }
    
    /**
     * @Route("/admin/users/active/{id}", name="app_admin_active_user")
     */
    public function active_user( $id ){
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $entityManager->getRepository(User::class)->find($id);
        if( $user->getisActive() == 1 ){
            $user->setisActive(0);
        }else{
            $user->setisActive(1);
        }
        $entityManager->flush();
        $this->addFlash( 'success', 'User activated' );
        return $this->redirectToRoute('app_admin_users');
    }
    
    /**
     * @Route("/admin/users/update/{id}", name="app_admin_update_user")
     */
    public function update_user( Request $request, UserPasswordEncoderInterface $passwdEncode, $id ){
        
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        
        $form = $this->createForm(AdminUpdUserType::class, $user);
        
        $form->handleRequest($request);
        $error = $form->getErrors();
        
        if( $form->isSubmitted() && $form->isValid() ){
            
            $passwd = $passwdEncode->encodePassword( $user, $user->getPlainPassword() );
            $user->setPassword($passwd);
            
            $user->setRoles([$request->request->get('roles')]);
            $user->setisActive($request->request->get('isActive'));
            
            $entityManager->flush();
            $this->addFlash( 'success', 'User updated' );
            return $this->redirectToRoute('app_admin_users');
        }
        //render the form
        return $this->render( 'admin/updform.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }
    
    /**
     * @Route("/admin/posts", name="app_admin_posts")
     */
    public function posts_view(){
        $posts=$this->getDoctrine()->getRepository( Post::class )->findAll();
        
        return $this->render( 'admin/posts.html.twig', ['posts' => $posts] );
    }
    
    /**
     * @Route("/admin/comments", name="app_admin_comments")
     */
    public function comments_view(){
        $comments=$this->getDoctrine()->getRepository( Comentario::class )->findAll();
        
        return $this->render( 'admin/comments.html.twig', ['comments' => $comments] );
    }
    
    /**
     * @Route("/admin/tags", name="app_admin_tags")
     */
    public function tags_view(){
        $tags=$this->getDoctrine()->getRepository( Tag::class )->findAll();
        
        return $this->render( 'admin/tags.html.twig', ['tags' => $tags] );
    }
    
    
}
