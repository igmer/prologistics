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
}
