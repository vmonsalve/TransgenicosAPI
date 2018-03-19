<?php

namespace Tiempo\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LoginController extends Controller
{
	public function loginAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();
		$nusuario = $request->get('nusuario');
		$password = $request->get('password');


		$usuario = $em->getRepository('TiempoAdminBundle:Usuarios')->findOneBy(
			array('username' => $nusuario)
		);


		if ($usuario) {

			$encoder 		= $this->container->get('security.encoder_factory')->getEncoder($usuario);
			$passworddb 	= $usuario->getPassword();
			$encoded_pass 	= $encoder->encodePassword($password  , $usuario->getSalt());


			if ($encoder->isPasswordValid($usuario->getPassword(), $password, $usuario->getSalt())) {
				$token = new UsernamePasswordToken(
					$nusuario,
					$usuario->getPassword(),
					'secured_user',
					array($usuario->getRoles()->getRol())
				);

				$session = $request->getSession();
				$session->set(
					'administrador' ,array(
						'nombre' => $usuario->getUsername(),
						'rol' => $usuario->getRoles()->getRol(),
						'id' => $usuario->getId() 
					));

				$this->get('security.token_storage')->setToken($token);
				$request->getSession()->set('_security_secured_admin', serialize($token));
				
				return $this->redirect($this->generateUrl('tiempo_admin_dashboard'));

			}else{
				$this->get('session')->getFlashBag()->add(
                	'login',
                	'Usuario o contraseña incorrectos'
            	);

				return $this->redirect($this->generateUrl('tiempo_admin_homepage'));				
			}
			
		}else{
			$this->get('session')->getFlashBag()->add(
                'login',
                'Usuario no encontrado'
            );
            	
			return $this->redirect($this->generateUrl('tiempo_admin_homepage'));				
			
		}
		
	}
}