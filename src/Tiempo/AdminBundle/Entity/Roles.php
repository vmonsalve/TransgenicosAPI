<?php

namespace Tiempo\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Tiempo\AdminBundle\Repository\RolesRepository")
 */
class Roles
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=255)
     */
    private $rol;


     /**
     * @ORM\OneToMany(targetEntity="Tiempo\AdminBundle\Entity\Usuarios", mappedBy="roles" , cascade={"remove"})
     * @ORM\OrderBy({"id" = "desc"})  
     */

    private $usuarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Roles
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
     * Set rol
     *
     * @param string $rol
     *
     * @return Roles
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Add usuario
     *
     * @param \Tiempo\AdminBundle\Entity\Usuarios $usuario
     *
     * @return Roles
     */
    public function addUsuario(\Tiempo\AdminBundle\Entity\Usuarios $usuario)
    {
        $this->usuarios[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \Tiempo\AdminBundle\Entity\Usuarios $usuario
     */
    public function removeUsuario(\Tiempo\AdminBundle\Entity\Usuarios $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}
