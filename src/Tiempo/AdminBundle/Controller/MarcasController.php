<?php

namespace Tiempo\AdminBundle\Controller;

use Tiempo\AdminBundle\Entity\Marcas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Marca controller.
 *
 */
class MarcasController extends Controller
{
    public function datosUsuario(Request $request){
        $session = $request->getSession();
        $usuario = $session->get('administrador');
        return $usuario;
    }

    /**
    * set datatable configs
    * @return \Waldo\DatatableBundle\Util\Datatable
    */
    private function _datatable() {
        $controller_instance = $this;
        $em = $this->getDoctrine()->getManager();
        return $this->get('datatable')
                ->setEntity("TiempoAdminBundle:Marcas", "m")
                ->setFields(
                        array(
                            "Id"            => 'm.id',
                            "Nombre"        => 'm.nombre',
                            "Editar"        => 'm.id',
                            "Eliminar"      => 'm.id',
                            "_identifier_"  => 'm.id'
                        )
                )
                ->setRenderer(
                    function(&$data) use ($controller_instance){
                      foreach ($data as $key => $value){
                        if ($key == 2) {
                          $data[$key] = $controller_instance
                                      ->get('templating')
                                      ->render(
                                          'TiempoAdminBundle:marcas:btneditar.html.twig',
                                          array('value' => $value)
                                      );
                        }
                        if ($key == 3) {
                          $data[$key] = $controller_instance
                                      ->get('templating')
                                      ->render(
                                          'TiempoAdminBundle:marcas:btneliminar.html.twig',
                                          array('value' => $value)
                                      );
                        }
                      }
                    }
                )
                ->setSearch(true)
                ->setOrder("m.id", "desc");
    }

    public function marcasGridAction(){
        return $this->_datatable()->execute();
    }


    /**
     * Lists all marca entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_marcas_index');

        $this->_datatable();

        return $this->render('TiempoAdminBundle:marcas:index.html.twig', array(
            'titulo'   => 'Marcas',
            'small'    => 'Editar',
            'username' => $datosUsuario["nombre"],
            'ruta'     => $ruta,
        ));
    }

    /**
     * Creates a new marca entity.
     *
     */
    public function newAction(Request $request)
    {
        $marca = new Marcas();
        $form = $this->createForm('Tiempo\AdminBundle\Form\MarcasType', $marca);
        $form->handleRequest($request);

        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_marcas_index');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($marca);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu Marca se ah creado con éxito'
            );

            return $this->redirectToRoute('administrador_marcas_index');
        }

        return $this->render('TiempoAdminBundle:marcas:new.html.twig', array(
            'username' => $datosUsuario["nombre"],
            'form'     => $form->createView(),
            'titulo'   => 'Marcas',
            'small'    => 'Crear',
            'marca'    => $marca,
            'ruta'     => $ruta,
        ));
    }


    /**
     * Displays a form to edit an existing marca entity.
     *
     */
    public function editAction(Request $request, Marcas $marca)
    {
        $editForm = $this->createForm('Tiempo\AdminBundle\Form\MarcasType', $marca);
        $editForm->handleRequest($request);
        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_marcas_index');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu Marca se ah editado con éxito'
            );

            return $this->redirectToRoute('administrador_marcas_edit', array('id' => $marca->getId()));
        }

        return $this->render('TiempoAdminBundle:marcas:edit.html.twig', array(
            'marca'       => $marca,
            'edit_form'   => $editForm->createView(),
            'titulo'      => 'Marcas',
            'small'       => 'Editar',
            'username'    => $datosUsuario["nombre"],
            'ruta'        => $ruta,
        ));
    }

    /**
     * Deletes a marca entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $marca = $em->getRepository('TiempoAdminBundle:Marcas')->findOneBy(Array('id' => $id));

        $em->remove($marca);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'mensajeError',
            'Tu Marca se ah eliminado con éxito'
        );
        
        return $this->redirectToRoute('administrador_marcas_index');
    }

}
