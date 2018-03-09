<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CtlVehiculo
 *
 * @ORM\Table(name="ctl_vehiculo", indexes={@ORM\Index(name="IDX_A00AFAD56A540E", columns={"id_estado"}), @ORM\Index(name="IDX_A00AFAD59A31079", columns={"idTipoVehiculo"})})
 * @ORM\Entity
 */
class CtlVehiculo
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
     * @ORM\Column(name="modelo", type="string", length=30, nullable=false)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=40, nullable=false)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=8, nullable=false)
     */
    private $placa;

    /**
     * @var integer
     *
     * @ORM\Column(name="pesoMax", type="integer", nullable=false)
     */
    private $pesomax;

    /**
     * @var \Ctlestadovehiculo
     *
     * @ORM\ManyToOne(targetEntity="Ctlestadovehiculo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id")
     * })
     */
    private $idEstado;

    /**
     * @var \Ctltipovehiculo
     *
     * @ORM\ManyToOne(targetEntity="Ctltipovehiculo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTipoVehiculo", referencedColumnName="id")
     * })
     */
    private $idtipovehiculo;



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
     * Set modelo
     *
     * @param string $modelo
     *
     * @return CtlVehiculo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return CtlVehiculo
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set placa
     *
     * @param string $placa
     *
     * @return CtlVehiculo
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set pesomax
     *
     * @param integer $pesomax
     *
     * @return CtlVehiculo
     */
    public function setPesomax($pesomax)
    {
        $this->pesomax = $pesomax;

        return $this;
    }

    /**
     * Get pesomax
     *
     * @return integer
     */
    public function getPesomax()
    {
        return $this->pesomax;
    }

    /**
     * Set idEstado
     *
     * @param \Utec\TransporteBundle\Entity\Ctlestadovehiculo $idEstado
     *
     * @return CtlVehiculo
     */
    public function setIdEstado(\Utec\TransporteBundle\Entity\Ctlestadovehiculo $idEstado = null)
    {
        $this->idEstado = $idEstado;

        return $this;
    }

    /**
     * Get idEstado
     *
     * @return \Utec\TransporteBundle\Entity\Ctlestadovehiculo
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * Set idtipovehiculo
     *
     * @param \Utec\TransporteBundle\Entity\Ctltipovehiculo $idtipovehiculo
     *
     * @return CtlVehiculo
     */
    public function setIdtipovehiculo(\Utec\TransporteBundle\Entity\Ctltipovehiculo $idtipovehiculo = null)
    {
        $this->idtipovehiculo = $idtipovehiculo;

        return $this;
    }

    /**
     * Get idtipovehiculo
     *
     * @return \Utec\TransporteBundle\Entity\Ctltipovehiculo
     */
    public function getIdtipovehiculo()
    {
        return $this->idtipovehiculo;
    }
}
