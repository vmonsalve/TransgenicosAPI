<?php

namespace Tiempo\AdminBundle\Controller;

use Tiempo\AdminBundle\Entity\Productos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Producto controller.
 *
 */
class ProductosController extends Controller
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
                ->setEntity("TiempoAdminBundle:Productos", "p")
                ->setFields(
                        array(
                            "Id"           => 'p.id',
                            "Nombre"       => 'p.nombre',
                            "Cateogoría"   => 'c.nombre',
                            "Transgénico"  => 'e.estado',
                            "Marca"        => 'm.nombre',
                            "Editar"       => 'p.id',
                            "Eliminar"     => 'p.id',
                            "_identifier_" => 'p.id'
                        )
                )
                ->setRenderer(
                    function(&$data) use ($controller_instance){
                      foreach ($data as $key => $value){
                        if ($key == 5) {
                          $data[$key] = $controller_instance
                                      ->get('templating')
                                      ->render(
                                          'TiempoAdminBundle:productos:btneditar.html.twig',
                                          array('value' => $value)
                                      );
                        }
                        if ($key == 6) {
                          $data[$key] = $controller_instance
                                      ->get('templating')
                                      ->render(
                                          'TiempoAdminBundle:productos:btneliminar.html.twig',
                                          array('value' => $value)
                                      );
                        }
                      }
                    }
                )
                ->addJoin('p.categorias', 'c', \Doctrine\ORM\Query\Expr\Join::INNER_JOIN)
                ->addJoin('p.estados', 'e', \Doctrine\ORM\Query\Expr\Join::INNER_JOIN)
                ->addJoin('p.marcas', 'm', \Doctrine\ORM\Query\Expr\Join::INNER_JOIN)
                ->setSearch(true)
                ->setOrder("p.id", "desc");
    }

    public function productosGridAction(){
        return $this->_datatable()->execute();
    }

    /**
     * Lists all producto entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_productos_index');

        $this->_datatable();

        return $this->render('TiempoAdminBundle:productos:index.html.twig', array(
            'username' => $datosUsuario["nombre"],
            'titulo'   => 'Productos',
            'small'    => 'Principal',
            'ruta'     => $ruta,
        ));
    }

    /**
     * Creates a new producto entity.
     *
     */
    public function newAction(Request $request)
    {
        $producto = new Productos();
        $form = $this->createForm('Tiempo\AdminBundle\Form\ProductosType', $producto);
        $form->handleRequest($request);
        $datosUsuario  = $this->datosUsuario($request);
        $ruta = $this->generateUrl('administrador_productos_index');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu Producto se ah creado con éxito'
            );

            return $this->redirectToRoute('administrador_productos_index');
        }

        return $this->render('TiempoAdminBundle:productos:new.html.twig', array(
            'username' => $datosUsuario["nombre"],
            'producto' => $producto,
            'form' => $form->createView(),
            'titulo'   => 'Productos',
            'small'    => 'Crear',
            'ruta'     => $ruta,
        ));
    }

    /**
     * Displays a form to edit an existing producto entity.
     *
     */
    public function editAction(Request $request, Productos $producto)
    {
        $editForm      = $this->createForm('Tiempo\AdminBundle\Form\ProductosType', $producto);
        $editForm->handleRequest($request);
        $datosUsuario  = $this->datosUsuario($request);
        $ruta          = $this->generateUrl('administrador_productos_index');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                'mensajeExito',
                'Tu producto se ah editado con éxito'
            );

            return $this->redirectToRoute('administrador_productos_edit', array('id' => $producto->getId()));
        }

        return $this->render('TiempoAdminBundle:productos:edit.html.twig', array(
            'username' => $datosUsuario["nombre"],
            'producto'  => $producto,
            'edit_form' => $editForm->createView(),
            'titulo'    => 'Productos',
            'small'     => 'Editar',
            'ruta'      => $ruta,
        ));
    }

    /**
     * Deletes a producto entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
  
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('TiempoAdminBundle:Productos')->findOneBy(array('id' => $id));

        $em->remove($producto);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'mensajeError',
            'Tu Producto se ah eliminado con éxito'
        );

        return $this->redirectToRoute('administrador_productos_index');
    }

}
