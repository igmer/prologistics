<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlmunicipio
 *
 * @ORM\Table(name="ctlMunicipio", indexes={@ORM\Index(name="IDX_3B59DEF51E7A331A", columns={"idDepartamento"})})
 * @ORM\Entity
 */
class Ctlmunicipio
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
     * @ORM\Column(name="nombre", type="string", length=40, nullable=false)
     */
    private $nombre;

    /**
     * @var \Ctldepartamento
     *
     * @ORM\ManyToOne(targetEntity="Ctldepartamento", inversedBy="departamento  Detalle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDepartamento", referencedColumnName="id")
     * })
     */
    private $iddepartamento;





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
     * @return Ctlmunicipio
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
     * Set iddepartamento
     *
     * @param \Utec\TransporteBundle\Entity\Ctldepartamento $iddepartamento
     *
     * @return Ctlmunicipio
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

    public function __toString()
    {
        return $this -> nombre ? $this -> nombre:'';
    }
}
