<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctldepartamento
 *
 * @ORM\Table(name="ctlDepartamento")
 * @ORM\Entity
 */
class Ctldepartamento
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
     * @ORM\Column(name="abreviatura", type="string", length=2, nullable=false)
     */
    private $abreviatura;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=15, nullable=false)
     */
    private $nombre;

    /**
    *
    * @ORM\OneToMany(targetEntity="Ctlmunicipio", mappedBy="iddepartamento", cascade={"all"}, orphanRemoval=true)
    *
    */
   private $departamentoDetalle;



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
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return Ctldepartamento
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Ctldepartamento
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
     * Constructor
     */
    public function __construct()
    {
        $this->departamentoDetalle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add departamentoDetalle
     *
     * @param \Utec\TransporteBundle\Entity\Ctlmunicipio $departamentoDetalle
     *
     * @return Ctldepartamento
     */
    public function addDepartamentoDetalle(\Utec\TransporteBundle\Entity\Ctlmunicipio $departamentoDetalle)
    {
        $this->departamentoDetalle[] = $departamentoDetalle;

        return $this;
    }

    /**
     * Remove departamentoDetalle
     *
     * @param \Utec\TransporteBundle\Entity\Ctlmunicipio $departamentoDetalle
     */
    public function removeDepartamentoDetalle(\Utec\TransporteBundle\Entity\Ctlmunicipio $departamentoDetalle)
    {
        $this->departamentoDetalle->removeElement($departamentoDetalle);
    }

    /**
     * Get departamentoDetalle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartamentoDetalle()
    {
        return $this->departamentoDetalle;
    }

    public function __toString()
    {
        return $this -> nombre ? $this -> nombre:'';
    }
}
