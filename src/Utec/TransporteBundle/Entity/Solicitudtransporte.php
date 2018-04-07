<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitudtransporte
 *
 * @ORM\Table(name="solicitudTransporte", indexes={@ORM\Index(name="IDX_DA3FD36364A8D091", columns={"idUsuarioReg"}), @ORM\Index(name="IDX_DA3FD363E4A5F0D7", columns={"idCliente"})})
 * @ORM\Entity
 */
class Solicitudtransporte
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
     * @var \DateTime
     *
     * @ORM\Column(name="horaFechaReg", type="datetime", nullable=false)
     */
    private $horafechareg;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activa", type="boolean", nullable=true)
     */
    private $activa;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuarioReg", referencedColumnName="id")
     * })
     */
    private $idusuarioreg;

    /**
     * @var \Ctlcliente
     *
     * @ORM\ManyToOne(targetEntity="Ctlcliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCliente", referencedColumnName="id")
     * })
     */
    private $idcliente;

        /**
    *
    * @ORM\OneToMany(targetEntity="Paquetetransporte", mappedBy="idsolicitud", cascade={"all"}, orphanRemoval=true)
    *
    */
   private $catalogoDetalle;



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
     * Set horafechareg
     *
     * @param \DateTime $horafechareg
     *
     * @return Solicitudtransporte
     */
    public function setHorafechareg($horafechareg)
    {
        $this->horafechareg = $horafechareg;

        return $this;
    }

    /**
     * Get horafechareg
     *
     * @return \DateTime
     */
    public function getHorafechareg()
    {
        return $this->horafechareg;
    }

    /**
     * Set activa
     *
     * @param boolean $activa
     *
     * @return Solicitudtransporte
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;

        return $this;
    }

    /**
     * Get activa
     *
     * @return boolean
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Application\Sonata\UserBundle\Entity\User $idusuarioreg
     *
     * @return Solicitudtransporte
     */
    public function setIdusuarioreg(\Application\Sonata\UserBundle\Entity\User $idusuarioreg = null)
    {
        $this->idusuarioreg = $idusuarioreg;

        return $this;
    }

    /**
     * Get idusuarioreg
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdusuarioreg()
    {
        return $this->idusuarioreg;
    }

    /**
     * Set idcliente
     *
     * @param \Utec\TransporteBundle\Entity\Ctlcliente $idcliente
     *
     * @return Solicitudtransporte
     */
    public function setIdcliente(\Utec\TransporteBundle\Entity\Ctlcliente $idcliente = null)
    {
        $this->idcliente = $idcliente;

        return $this;
    }

    /**
     * Get idcliente
     *
     * @return \Utec\TransporteBundle\Entity\Ctlcliente
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->catalogoDetalle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add catalogoDetalle
     *
     * @param \Utec\TransporteBundle\Entity\Paquetetransporte $catalogoDetalle
     *
     * @return Solicitudtransporte
     */
    public function addCatalogoDetalle(\Utec\TransporteBundle\Entity\Paquetetransporte $catalogoDetalle)
    {
        $this->catalogoDetalle[] = $catalogoDetalle;

        return $this;
    }

    /**
     * Remove catalogoDetalle
     *
     * @param \Utec\TransporteBundle\Entity\Paquetetransporte $catalogoDetalle
     */
    public function removeCatalogoDetalle(\Utec\TransporteBundle\Entity\Paquetetransporte $catalogoDetalle)
    {
        $this->catalogoDetalle->removeElement($catalogoDetalle);
    }

    /**
     * Get catalogoDetalle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCatalogoDetalle()
    {
        return $this->catalogoDetalle;
    }
}
