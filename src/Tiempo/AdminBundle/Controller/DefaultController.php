<?php

namespace Tiempo\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function datosUsuario(Request $request){
        $session = $request->getSession();
        $usuario = $session->get('administrador');
        return $usuario;
    }

    public function indexAction(){
        return $this->render('TiempoAdminBundle:Default:index.html.twig');
    }

    public function dashboardAction(Request $request){

        $datosUsuario  = $this->datosUsuario($request);


        $ruta = $this->generateUrl('tiempo_admin_dashboard');

    	$titulo = 'Dashboard';
    	
        return $this->render('TiempoAdminBundle:Default:dashboard.html.twig', array(
    		'titulo'   => $titulo,
            'small'    => '',
            'username' => $datosUsuario["nombre"],
            'ruta'     => $ruta,
    	));
    }

    public function logoutAction(Request $request){
    	$session = $request->getSession();
      	$this->get('session')->clear();
      	return $this->redirect($this->generateUrl('tiempo_admin_homepage'));
    }
}
