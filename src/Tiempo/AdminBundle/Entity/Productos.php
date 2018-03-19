<?php

namespace Tiempo\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Productos
 *
 * @ORM\Table(name="productos")
 * @ORM\Entity(repositoryClass="Tiempo\AdminBundle\Repository\ProductosRepository")
 */
class Productos
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
     * @ORM\ManyToOne(targetEntity="Tiempo\AdminBundle\Entity\Categorias", inversedBy="productos" )
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categorias;

     /**
     * @ORM\ManyToOne(targetEntity="Tiempo\AdminBundle\Entity\Marcas", inversedBy="productos" )
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     */
    private $marcas;

    /**
     * @ORM\ManyToOne(targetEntity="Tiempo\AdminBundle\Entity\Estados", inversedBy="productos" )
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */
    private $estados;
    
    

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
     * @return Productos
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
     * Set categorias
     *
     * @param \Tiempo\AdminBundle\Entity\Categorias $categorias
     *
     * @return Productos
     */
    public function setCategorias(\Tiempo\AdminBundle\Entity\Categorias $categorias = null)
    {
        $this->categorias = $categorias;

        return $this;
    }

    /**
     * Get categorias
     *
     * @return \Tiempo\AdminBundle\Entity\Categorias
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set marcas
     *
     * @param \Tiempo\AdminBundle\Entity\Marcas $marcas
     *
     * @return Productos
     */
    public function setMarcas(\Tiempo\AdminBundle\Entity\Marcas $marcas = null)
    {
        $this->marcas = $marcas;

        return $this;
    }

    /**
     * Get marcas
     *
     * @return \Tiempo\AdminBundle\Entity\Marcas
     */
    public function getMarcas()
    {
        return $this->marcas;
    }

    /**
     * Set estados
     *
     * @param \Tiempo\AdminBundle\Entity\Estados $estados
     *
     * @return Productos
     */
    public function setEstados(\Tiempo\AdminBundle\Entity\Estados $estados = null)
    {
        $this->estados = $estados;

        return $this;
    }

    /**
     * Get estados
     *
     * @return \Tiempo\AdminBundle\Entity\Estados
     */
    public function getEstados()
    {
        return $this->estados;
    }
}
