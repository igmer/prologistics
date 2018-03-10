<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlcliente
 *
 * @ORM\Table(name="ctlCliente", indexes={@ORM\Index(name="IDX_559C8DEFFCF8192D", columns={"id_usuario"})})
 * @ORM\Entity
 */
class Ctlcliente
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
     * @ORM\Column(name="nombreRepresentante", type="string", length=50, nullable=false)
     */
    private $nombrerepresentante;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEmpresa", type="string", length=200, nullable=false)
     */
    private $nombreempresa;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=1, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=9, nullable=false)
     */
    private $telefono;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $idUsuario;



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
     * Set nombrerepresentante
     *
     * @param string $nombrerepresentante
     *
     * @return Ctlcliente
     */
    public function setNombrerepresentante($nombrerepresentante)
    {
        $this->nombrerepresentante = $nombrerepresentante;

        return $this;
    }

    /**
     * Get nombrerepresentante
     *
     * @return string
     */
    public function getNombrerepresentante()
    {
        return $this->nombrerepresentante;
    }

    /**
     * Set nombreempresa
     *
     * @param string $nombreempresa
     *
     * @return Ctlcliente
     */
    public function setNombreempresa($nombreempresa)
    {
        $this->nombreempresa = $nombreempresa;

        return $this;
    }

    /**
     * Get nombreempresa
     *
     * @return string
     */
    public function getNombreempresa()
    {
        return $this->nombreempresa;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Ctlcliente
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Ctlcliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set idUsuario
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuario
     *
     * @return Ctlcliente
     */
    public function setIdUsuario(\Application\Sonata\UserBundle\Entity\User $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function __toString()
    {
        return $this -> nombrerepresentante ? $this -> nombrerepresentante:'';
    }
}
