<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlgenero
 *
 * @ORM\Table(name="ctlGenero")
 * @ORM\Entity
 */
class Ctlgenero
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
     * @ORM\Column(name="sexo", type="string", length=15, nullable=false)
     */
    private $sexo;



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
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Ctlgenero
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }
    public function __toString()
    {
        return $this -> sexo ? $this -> sexo:'';
    }
}
