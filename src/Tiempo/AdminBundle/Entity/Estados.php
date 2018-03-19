<?php

namespace Tiempo\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estados
 *
 * @ORM\Table(name="estados")
 * @ORM\Entity(repositoryClass="Tiempo\AdminBundle\Repository\EstadosRepository")
 */
class Estados
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
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="Tiempo\AdminBundle\Entity\Productos", mappedBy="estados" , cascade={"remove"})
     * @ORM\OrderBy({"id" = "desc"})  
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Estados
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add producto
     *
     * @param \Tiempo\AdminBundle\Entity\Productos $producto
     *
     * @return Estados
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
