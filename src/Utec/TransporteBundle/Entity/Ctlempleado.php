<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlempleado
 *
 * @ORM\Table(name="ctlEmpleado", indexes={@ORM\Index(name="IDX_A2C914EA1E7A331A", columns={"idDepartamento"}), @ORM\Index(name="IDX_A2C914EAFCF8192D", columns={"id_usuario"}), @ORM\Index(name="IDX_A2C914EAC31120A0", columns={"idGenero"}), @ORM\Index(name="IDX_A2C914EAB2FA397B", columns={"idCategoria"})})
 * @ORM\Entity
 */
class Ctlempleado
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
     * @ORM\Column(name="nombre", type="string", length=80, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=80, nullable=false)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=9, nullable=false)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=150, nullable=false)
     */
    private $direccion;

    /**
     * @var \Ctldepartamento
     *
     * @ORM\ManyToOne(targetEntity="Ctldepartamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDepartamento", referencedColumnName="id")
     * })
     */
    private $iddepartamento;

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
     * @var \Ctlgenero
     *
     * @ORM\ManyToOne(targetEntity="Ctlgenero")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idGenero", referencedColumnName="id")
     * })
     */
    private $idgenero;

    /**
     * @var \Ctlcategoriaempleado
     *
     * @ORM\ManyToOne(targetEntity="Ctlcategoriaempleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategoria", referencedColumnName="id")
     * })
     */
    private $idcategoria;



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
     * @return Ctlempleado
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Ctlempleado
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Ctlempleado
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Ctlempleado
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
     * Set iddepartamento
     *
     * @param \Utec\TransporteBundle\Entity\Ctldepartamento $iddepartamento
     *
     * @return Ctlempleado
     */
    public function setIddepartamento(\Utec\TransporteBundle\Entity\Ctldepartamento $iddepartamento = null)
    {
        $this->iddepartamento = $iddepartamento;

        return $this;
    }

    /**
     * Get iddepartamento
     *
     * @return \Utec\TransporteBundle\Entity\Ctldepartamento
     */
    public function getIddepartamento()
    {
        return $this->iddepartamento;
    }

    /**
     * Set idUsuario
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuario
     *
     * @return Ctlempleado
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

    /**
     * Set idgenero
     *
     * @param \Utec\TransporteBundle\Entity\Ctlgenero $idgenero
     *
     * @return Ctlempleado
     */
    public function setIdgenero(\Utec\TransporteBundle\Entity\Ctlgenero $idgenero = null)
    {
        $this->idgenero = $idgenero;

        return $this;
    }

    /**
     * Get idgenero
     *
     * @return \Utec\TransporteBundle\Entity\Ctlgenero
     */
    public function getIdgenero()
    {
        return $this->idgenero;
    }

    /**
     * Set idcategoria
     *
     * @param \Utec\TransporteBundle\Entity\Ctlcategoriaempleado $idcategoria
     *
     * @return Ctlempleado
     */
    public function setIdcategoria(\Utec\TransporteBundle\Entity\Ctlcategoriaempleado $idcategoria = null)
    {
        $this->idcategoria = $idcategoria;

        return $this;
    }

    /**
     * Get idcategoria
     *
     * @return \Utec\TransporteBundle\Entity\Ctlcategoriaempleado
     */
    public function getIdcategoria()
    {
        return $this->idcategoria;
    }
}
