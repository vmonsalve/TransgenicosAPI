<?php

namespace Tiempo\AdminBundle\Controller;

use Tiempo\AdminBundle\Entity\Estados;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Estado controller.
 *
 */
class EstadosController extends Controller
{
    public function datosUsuario(Request $request){
        $session = $request->getSession();
        $usuario = $session->get('administrador');
        return $usuario;
    }

    /**
     * Lists all estado entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $estados = $em->getRepository('TiempoAdminBundle:Estados')->findAll();

        $datosUsuario  = $this->datosUsuario($request);

        $ruta = $this->generateUrl('administrador_estados_index');

        dump($ruta);

        return $this->render('TiempoAdminBundle:estados:index.html.twig', array(
            'estados'  => $estados,
            'username' => $datosUsuario["nombre"],
            'titulo'   => 'Estados',
            'small'    => 'Principal',
            'ruta'     => $ruta,
        ));
    }

    /**
     * Creates a new estado entity.
     *
     */
    public function newAction(Request $request)
    {
        $estado = new Estados();
        $form = $this->createForm('Tiempo\AdminBundle\Form\EstadosType', $estado);
        $form->handleRequest($request);

        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_estados_index');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu estado se ah creado con éxito'
            );

            return $this->redirectToRoute('administrador_estados_index');
        }

        return $this->render('TiempoAdminBundle:estados:new.html.twig', array(
            'estado'   => $estado,
            'form'     => $form->createView(),
            'username' => $datosUsuario["nombre"],
            'titulo'   => 'Estados',
            'small'    => 'Crear',
            'ruta'     => $ruta
        ));
    }


    /**
     * Displays a form to edit an existing estado entity.
     *
     */
    public function editAction(Request $request, Estados $estado)
    {
        $editForm = $this->createForm('Tiempo\AdminBundle\Form\EstadosType', $estado);
        $editForm->handleRequest($request);

        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_estados_index');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu estado se ah editado con éxito'
            );

            return $this->redirectToRoute('administrador_estados_edit', array('id' => $estado->getId()));
        }

        return $this->render('TiempoAdminBundle:estados:edit.html.twig', array(
            'estado'     => $estado,
            'edit_form'  => $editForm->createView(),
            'username'   => $datosUsuario["nombre"],
            'titulo'     => 'Estados',
            'small'      => 'Editar',
            'ruta'       => $ruta,
        ));
    }

    /**
     * Deletes a estado entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $estado = $em->getRepository('TiempoAdminBundle:Estados')->findOneBy(Array('id' => $id ));

        $em->remove($estado);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'mensajeError',
            'Tu estado se ah eliminado con éxito'
        );

        return $this->redirectToRoute('administrador_estados_index');
    }

  
}
