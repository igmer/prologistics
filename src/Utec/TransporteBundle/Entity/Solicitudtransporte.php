<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitudtransporte
 *
 * @ORM\Table(name="solicitudTransporte", indexes={@ORM\Index(name="IDX_DA3FD363BDEC92B8", columns={"idMotorista"}), @ORM\Index(name="IDX_DA3FD36364A8D091", columns={"idUsuarioReg"}), @ORM\Index(name="IDX_DA3FD3635F624904", columns={"idPrioridad"}), @ORM\Index(name="IDX_DA3FD3639A593C58", columns={"idVehiculo"})})
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
     * @var string
     *
     * @ORM\Column(name="lugarRecoleccion", type="string", length=160, nullable=false)
     */
    private $lugarrecoleccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaHoraRecoleccion", type="datetime", nullable=false)
     */
    private $fechahorarecoleccion;

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
     * @var string
     *
     * @ORM\Column(name="claveRastreo", type="string", length=8, nullable=false)
     */
    private $claverastreo;

    /**
     * @var \Ctlempleado
     *
     * @ORM\ManyToOne(targetEntity="Ctlempleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMotorista", referencedColumnName="id")
     * })
     */
    private $idmotorista;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="FosUserUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuarioReg", referencedColumnName="id")
     * })
     */
    private $idusuarioreg;

    /**
     * @var \Ctlprioridad
     *
     * @ORM\ManyToOne(targetEntity="Ctlprioridad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPrioridad", referencedColumnName="id")
     * })
     */
    private $idprioridad;

    /**
     * @var \CtlVehiculo
     *
     * @ORM\ManyToOne(targetEntity="CtlVehiculo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idVehiculo", referencedColumnName="id")
     * })
     */
    private $idvehiculo;



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
     * Set lugarrecoleccion
     *
     * @param string $lugarrecoleccion
     *
     * @return Solicitudtransporte
     */
    public function setLugarrecoleccion($lugarrecoleccion)
    {
        $this->lugarrecoleccion = $lugarrecoleccion;

        return $this;
    }

    /**
     * Get lugarrecoleccion
     *
     * @return string
     */
    public function getLugarrecoleccion()
    {
        return $this->lugarrecoleccion;
    }

    /**
     * Set fechahorarecoleccion
     *
     * @param \DateTime $fechahorarecoleccion
     *
     * @return Solicitudtransporte
     */
    public function setFechahorarecoleccion($fechahorarecoleccion)
    {
        $this->fechahorarecoleccion = $fechahorarecoleccion;

        return $this;
    }

    /**
     * Get fechahorarecoleccion
     *
     * @return \DateTime
     */
    public function getFechahorarecoleccion()
    {
        return $this->fechahorarecoleccion;
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
     * Set claverastreo
     *
     * @param string $claverastreo
     *
     * @return Solicitudtransporte
     */
    public function setClaverastreo($claverastreo)
    {
        $this->claverastreo = $claverastreo;

        return $this;
    }

    /**
     * Get claverastreo
     *
     * @return string
     */
    public function getClaverastreo()
    {
        return $this->claverastreo;
    }

    /**
     * Set idmotorista
     *
     * @param \Utec\TransporteBundle\Entity\Ctlempleado $idmotorista
     *
     * @return Solicitudtransporte
     */
    public function setIdmotorista(\Utec\TransporteBundle\Entity\Ctlempleado $idmotorista = null)
    {
        $this->idmotorista = $idmotorista;

        return $this;
    }

    /**
     * Get idmotorista
     *
     * @return \Utec\TransporteBundle\Entity\Ctlempleado
     */
    public function getIdmotorista()
    {
        return $this->idmotorista;
    }

    /**
     * Set idusuarioreg
     *
     * @param \Utec\TransporteBundle\Entity\FosUserUser $idusuarioreg
     *
     * @return Solicitudtransporte
     */
    public function setIdusuarioreg(\Utec\TransporteBundle\Entity\FosUserUser $idusuarioreg = null)
    {
        $this->idusuarioreg = $idusuarioreg;

        return $this;
    }

    /**
     * Get idusuarioreg
     *
     * @return \Utec\TransporteBundle\Entity\FosUserUser
     */
    public function getIdusuarioreg()
    {
        return $this->idusuarioreg;
    }

    /**
     * Set idprioridad
     *
     * @param \Utec\TransporteBundle\Entity\Ctlprioridad $idprioridad
     *
     * @return Solicitudtransporte
     */
    public function setIdprioridad(\Utec\TransporteBundle\Entity\Ctlprioridad $idprioridad = null)
    {
        $this->idprioridad = $idprioridad;

        return $this;
    }

    /**
     * Get idprioridad
     *
     * @return \Utec\TransporteBundle\Entity\Ctlprioridad
     */
    public function getIdprioridad()
    {
        return $this->idprioridad;
    }

    /**
     * Set idvehiculo
     *
     * @param \Utec\TransporteBundle\Entity\CtlVehiculo $idvehiculo
     *
     * @return Solicitudtransporte
     */
    public function setIdvehiculo(\Utec\TransporteBundle\Entity\CtlVehiculo $idvehiculo = null)
    {
        $this->idvehiculo = $idvehiculo;

        return $this;
    }

    /**
     * Get idvehiculo
     *
     * @return \Utec\TransporteBundle\Entity\CtlVehiculo
     */
    public function getIdvehiculo()
    {
        return $this->idvehiculo;
    }
}
