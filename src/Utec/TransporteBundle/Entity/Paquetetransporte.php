<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paquetetransporte
 *
 * @ORM\Table(name="paqueteTransporte", indexes={@ORM\Index(name="IDX_61B7A11A6A385796", columns={"idSolicitud"}), @ORM\Index(name="IDX_61B7A11ACC10B87", columns={"idMunicipioDestino"})})
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
     * @var \Solicitudtransporte
     *
     * @ORM\ManyToOne(targetEntity="Solicitudtransporte")
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
}
