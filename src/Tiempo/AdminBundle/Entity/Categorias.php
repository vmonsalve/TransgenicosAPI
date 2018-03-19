<?php

namespace Tiempo\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorias
 *
 * @ORM\Table(name="categorias")
 * @ORM\Entity(repositoryClass="Tiempo\AdminBundle\Repository\CategoriasRepository")
 */
class Categorias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
     private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Tiempo\AdminBundle\Entity\Productos", mappedBy="categorias" , cascade={"remove"})
     */
    private $productos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Categorias
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add producto
     *
     * @param \Tiempo\AdminBundle\Entity\Productos $producto
     *
     * @return Categorias
     */
    public function addProducto(\Tiempo\AdminBundle\Entity\Productos $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \Tiempo\AdminBundle\Entity\Productos $producto
     */
    public function removeProducto(\Tiempo\AdminBundle\Entity\Productos $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }
}
