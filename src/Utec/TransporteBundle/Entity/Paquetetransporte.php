<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paquetetransporte
 *
 * @ORM\Table(name="paqueteTransporte", indexes={@ORM\Index(name="IDX_61B7A11A6A385796", columns={"idSolicitud"}), @ORM\Index(name="IDX_61B7A11ACC10B87", columns={"idMunicipioDestino"}), @ORM\Index(name="IDX_61B7A11A4D0C910D", columns={"idMunicipioOrigen"}), @ORM\Index(name="IDX_61B7A11A9A593C58", columns={"idVehiculo"})})
 * @ORM\Entity
 */
class Paquetetransporte
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
     * @ORM\Column(name="direccionDestino", type="string", length=250, nullable=false)
     */
    private $direcciondestino;

    /**
     * @var boolean
     *
     * @ORM\Column(name="entregado", type="boolean", nullable=false)
     */
    private $entregado;

    /**
     * @var float
     *
     * @ORM\Column(name="aPagar", type="float", precision=24, scale=0, nullable=false)
     */
    private $apagar;

    /**
     * @var string
     *
     * @ORM\Column(name="lugarDestino", type="string", length=200, nullable=true)
     */
    private $lugardestino;

    /**
     * @var string
     *
     * @ORM\Column(name="clave_rastreo", type="string", length=20, nullable=true)
     */
    private $claveRastreo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hora_rec", type="datetime", nullable=true)
     */
    private $fechaHoraRec;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_paquete", type="string", length=250, nullable=true)
     */
    private $descripcionPaquete;

    /**
     * @var \Solicitudtransporte
     *
     * @ORM\ManyToOne(targetEntity="Solicitudtransporte",inversedBy="catalogoDetalle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSolicitud", referencedColumnName="id")
     * })
     */
    private $idsolicitud;

    /**
     * @var \Ctlmunicipio
     *
     * @ORM\ManyToOne(targetEntity="Ctlmunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMunicipioDestino", referencedColumnName="id")
     * })
     */
    private $idmunicipiodestino;

    /**
     * @var \Ctlmunicipio
     *
     * @ORM\ManyToOne(targetEntity="Ctlmunicipio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMunicipioOrigen", referencedColumnName="id")
     * })
     */
    private $idmunicipioorigen;

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
     * Set direcciondestino
     *
     * @param string $direcciondestino
     *
     * @return Paquetetransporte
     */
    public function setDirecciondestino($direcciondestino)
    {
        $this->direcciondestino = $direcciondestino;

        return $this;
    }

    /**
     * Get direcciondestino
     *
     * @return string
     */
    public function getDirecciondestino()
    {
        return $this->direcciondestino;
    }

    /**
     * Set entregado
     *
     * @param boolean $entregado
     *
     * @return Paquetetransporte
     */
    public function setEntregado($entregado)
    {
        $this->entregado = $entregado;

        return $this;
    }

    /**
     * Get entregado
     *
     * @return boolean
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set apagar
     *
     * @param float $apagar
     *
     * @return Paquetetransporte
     */
    public function setApagar($apagar)
    {
        $this->apagar = $apagar;

        return $this;
    }

    /**
     * Get apagar
     *
     * @return float
     */
    public function getApagar()
    {
        return $this->apagar;
    }

    /**
     * Set lugardestino
     *
     * @param string $lugardestino
     *
     * @return Paquetetransporte
     */
    public function setLugardestino($lugardestino)
    {
        $this->lugardestino = $lugardestino;

        return $this;
    }

    /**
     * Get lugardestino
     *
     * @return string
     */
    public function getLugardestino()
    {
        return $this->lugardestino;
    }

    /**
     * Set claveRastreo
     *
     * @param string $claveRastreo
     *
     * @return Paquetetransporte
     */
    public function setClaveRastreo($claveRastreo)
    {
        $this->claveRastreo = $claveRastreo;

        return $this;
    }

    /**
     * Get claveRastreo
     *
     * @return string
     */
    public function getClaveRastreo()
    {
        return $this->claveRastreo;
    }

    /**
     * Set fechaHoraRec
     *
     * @param \DateTime $fechaHoraRec
     *
     * @return Paquetetransporte
     */
    public function setFechaHoraRec($fechaHoraRec)
    {
        $this->fechaHoraRec = $fechaHoraRec;

        return $this;
    }

    /**
     * Get fechaHoraRec
     *
     * @return \DateTime
     */
    public function getFechaHoraRec()
    {
        return $this->fechaHoraRec;
    }

    /**
     * Set descripcionPaquete
     *
     * @param string $descripcionPaquete
     *
     * @return Paquetetransporte
     */
    public function setDescripcionPaquete($descripcionPaquete)
    {
        $this->descripcionPaquete = $descripcionPaquete;

        return $this;
    }

    /**
     * Get descripcionPaquete
     *
     * @return string
     */
    public function getDescripcionPaquete()
    {
        return $this->descripcionPaquete;
    }

    /**
     * Set idsolicitud
     *
     * @param \Utec\TransporteBundle\Entity\Solicitudtransporte $idsolicitud
     *
     * @return Paquetetransporte
     */
    public function setIdsolicitud(\Utec\TransporteBundle\Entity\Solicitudtransporte $idsolicitud = null)
    {
        $this->idsolicitud = $idsolicitud;

        return $this;
    }

    /**
     * Get idsolicitud
     *
     * @return \Utec\TransporteBundle\Entity\Solicitudtransporte
     */
    public function getIdsolicitud()
    {
        return $this->idsolicitud;
    }

    /**
     * Set idmunicipiodestino
     *
     * @param \Utec\TransporteBundle\Entity\Ctlmunicipio $idmunicipiodestino
     *
     * @return Paquetetransporte
     */
    public function setIdmunicipiodestino(\Utec\TransporteBundle\Entity\Ctlmunicipio $idmunicipiodestino = null)
    {
        $this->idmunicipiodestino = $idmunicipiodestino;

        return $this;
    }

    /**
     * Get idmunicipiodestino
     *
     * @return \Utec\TransporteBundle\Entity\Ctlmunicipio
     */
    public function getIdmunicipiodestino()
    {
        return $this->idmunicipiodestino;
    }

    /**
     * Set idmunicipioorigen
     *
     * @param \Utec\TransporteBundle\Entity\Ctlmunicipio $idmunicipioorigen
     *
     * @return Paquetetransporte
     */
    public function setIdmunicipioorigen(\Utec\TransporteBundle\Entity\Ctlmunicipio $idmunicipioorigen = null)
    {
        $this->idmunicipioorigen = $idmunicipioorigen;

        return $this;
    }

    /**
     * Get idmunicipioorigen
     *
     * @return \Utec\TransporteBundle\Entity\Ctlmunicipio
     */
    public function getIdmunicipioorigen()
    {
        return $this->idmunicipioorigen;
    }

    /**
     * Set idvehiculo
     *
     * @param \Utec\TransporteBundle\Entity\CtlVehiculo $idvehiculo
     *
     * @return Paquetetransporte
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
    public function __toString()
    {
        return $this -> descripcionPaquete  ? $this -> descripcionPaquete:'';
    }
}
