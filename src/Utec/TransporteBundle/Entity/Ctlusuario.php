<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlusuario
 *
 * @ORM\Table(name="ctlUsuario", indexes={@ORM\Index(name="IDX_83E5A6972F1D22B0", columns={"idRol"}), @ORM\Index(name="IDX_83E5A697C10F6722", columns={"idTipoUsuario"})})
 * @ORM\Entity
 */
class Ctlusuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=40, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=200, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=160, nullable=false)
     */
    private $direccion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false)
     */
    private $activo;

    /**
     * @var \Ctlrol
     *
     * @ORM\ManyToOne(targetEntity="Ctlrol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRol", referencedColumnName="id")
     * })
     */
    private $idrol;

    /**
     * @var \Tipousuario
     *
     * @ORM\ManyToOne(targetEntity="Tipousuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoUsuario", referencedColumnName="id")
     * })
     */
    private $idtipousuario;



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
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Ctlusuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Ctlusuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Ctlusuario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Ctlusuario
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set idrol
     *
     * @param \Utec\TransporteBundle\Entity\Ctlrol $idrol
     *
     * @return Ctlusuario
     */
    public function setIdrol(\Utec\TransporteBundle\Entity\Ctlrol $idrol = null)
    {
        $this->idrol = $idrol;

        return $this;
    }

    /**
     * Get idrol
     *
     * @return \Utec\TransporteBundle\Entity\Ctlrol
     */
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set idtipousuario
     *
     * @param \Utec\TransporteBundle\Entity\Tipousuario $idtipousuario
     *
     * @return Ctlusuario
     */
    public function setIdtipousuario(\Utec\TransporteBundle\Entity\Tipousuario $idtipousuario = null)
    {
        $this->idtipousuario = $idtipousuario;

        return $this;
    }

    /**
     * Get idtipousuario
     *
     * @return \Utec\TransporteBundle\Entity\Tipousuario
     */
    public function getIdtipousuario()
    {
        return $this->idtipousuario;
    }
}
