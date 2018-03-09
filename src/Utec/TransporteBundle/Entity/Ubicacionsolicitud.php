<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ubicacionsolicitud
 *
 * @ORM\Table(name="ubicacionSolicitud", indexes={@ORM\Index(name="IDX_B311634ECCF5C3E5", columns={"id_paquete"})})
 * @ORM\Entity
 */
class Ubicacionsolicitud
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
     * @var float
     *
     * @ORM\Column(name="latitud", type="float", precision=53, scale=0, nullable=false)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="float", precision=53, scale=0, nullable=false)
     */
    private $longitud;

    /**
     * @var \Paquetetransporte
     *
     * @ORM\ManyToOne(targetEntity="Paquetetransporte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_paquete", referencedColumnName="id")
     * })
     */
    private $idPaquete;



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
     * Set latitud
     *
     * @param float $latitud
     *
     * @return Ubicacionsolicitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return float
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     *
     * @return Ubicacionsolicitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud
     *
     * @return float
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set idPaquete
     *
     * @param \Utec\TransporteBundle\Entity\Paquetetransporte $idPaquete
     *
     * @return Ubicacionsolicitud
     */
    public function setIdPaquete(\Utec\TransporteBundle\Entity\Paquetetransporte $idPaquete = null)
    {
        $this->idPaquete = $idPaquete;

        return $this;
    }

    /**
     * Get idPaquete
     *
     * @return \Utec\TransporteBundle\Entity\Paquetetransporte
     */
    public function getIdPaquete()
    {
        return $this->idPaquete;
    }
}
