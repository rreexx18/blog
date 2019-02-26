<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
    /**
     * @param Request $request
     * @Route("/register",name="app_register")
     */
    public function register( Request $request, UserPasswordEncoderInterface $passwdEncode ){
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setisActive(false);
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        $error = $form->getErrors();

        if( $form->isSubmitted() && $form->isValid() ){
            $passwd = $passwdEncode->encodePassword( $user, $user->getPlainPassword() );
            $user->setPassword($passwd);
            //Manejo de las entidades
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash( 'success', 'User created' );
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render( 'user/regform.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }
    
    /**
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @Route("/login", name="app_login")
     */
    public function login( Request $request, AuthenticationUtils $authUtils ){
        $error = $authUtils->getLastAuthenticationError();
        // last username
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render( 'user/login.html.twig',[
            'error'=>$error,
            'last_username'=>$lastUsername
        ]);
    }
    
    /**
    * @Route("/logout", name="app_logout")
    */
    public function logout(){
        $this->redirectToRoute('/');
    }
    
}
