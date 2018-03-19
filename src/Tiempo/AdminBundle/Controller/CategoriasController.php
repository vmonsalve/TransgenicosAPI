<?php

namespace Tiempo\AdminBundle\Controller;

use Tiempo\AdminBundle\Entity\Categorias;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * Categoria controller.
 *
 */
class CategoriasController extends Controller
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
                ->setEntity("TiempoAdminBundle:Categorias", "c")
                ->setFields(
                        array(
                            "Id"            => 'c.id',
                            "Nombre"        => 'c.nombre',
                            "Editar"        => 'c.id',
                            "Eliminar"      => 'c.id',
                            "_identifier_"  => 'c.id'
                        )
                )
                ->setRenderer(
                    function(&$data) use ($controller_instance){
                      foreach ($data as $key => $value){
                        if ($key == 2) {
                          $data[$key] = $controller_instance
                                      ->get('templating')
                                      ->render(
                                          'TiempoAdminBundle:categorias:btneditar.html.twig',
                                          array('value' => $value)
                                      );
                        }
                        if ($key == 3) {
                          $data[$key] = $controller_instance
                                      ->get('templating')
                                      ->render(
                                          'TiempoAdminBundle:categorias:btneliminar.html.twig',
                                          array('value' => $value)
                                      );
                        }
                      }
                    }
                )
                ->setSearch(true)
                ->setOrder("c.id", "desc");
    }

    public function categoriasGridAction(){
        return $this->_datatable()->execute();
    }


    /**
     * Lists all categoria entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('admintrador_categorias_index');
        $this->_datatable();


        return $this->render('TiempoAdminBundle:categorias:index.html.twig', array(
            'username' => $datosUsuario["nombre"],
            'titulo'   => 'Categorias',
            'small'    => 'Principal',
            'ruta'     => $ruta,
        ));
    }

    /**
     * Creates a new categoria entity.
     *
     */
    public function newAction(Request $request)
    {
        $categoria = new Categorias();
        $form = $this->createForm('Tiempo\AdminBundle\Form\CategoriasType', $categoria);
        $form->handleRequest($request);
        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('admintrador_categorias_index');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu Categoria se ah creado con éxito'
            );

            return $this->redirectToRoute('admintrador_categorias_index');
        }


        return $this->render('TiempoAdminBundle:categorias:new.html.twig', array(
            'titulo'    => 'Categorias',
            'small'     => 'Crear',
            'categoria' => $categoria,
            'form'      => $form->createView(),
            'username'  => $datosUsuario["nombre"],
            'ruta'      => $ruta,
        ));
    }


    /**
     * Displays a form to edit an existing categoria entity.
     *
     */
    public function editAction(Request $request, Categorias $categoria)
    {
        $editForm = $this->createForm('Tiempo\AdminBundle\Form\CategoriasType', $categoria);
        $editForm->handleRequest($request);
        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('admintrador_categorias_index');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu Categoria se ah editado con éxito'
            );

            return $this->redirectToRoute('admintrador_categorias_edit', array('id' => $categoria->getId()));
        }


        return $this->render('TiempoAdminBundle:categorias:edit.html.twig', array(
            'username'  => $datosUsuario["nombre"],
            'edit_form' => $editForm->createView(),
            'titulo'    => 'Categorias',
            'small'     => 'Editar',
            'categoria' => $categoria,
            'ruta'      => $ruta,
        ));
    }

    /**
     * Deletes a categoria entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoria = $em->getRepository('TiempoAdminBundle:Categorias')->findOneBy(array('id' => $id));
        $em->remove($categoria);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'mensajeError',
            'Tu Categoria se ah eliminado con éxito'
        );

        return $this->redirectToRoute('admintrador_categorias_index');
    }

}
