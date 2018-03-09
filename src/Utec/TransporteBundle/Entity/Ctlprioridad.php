<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlprioridad
 *
 * @ORM\Table(name="ctlPrioridad")
 * @ORM\Entity
 */
class Ctlprioridad
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
     * @ORM\Column(name="priridad", type="string", length=25, nullable=false)
     */
    private $priridad;



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
     * Set priridad
     *
     * @param string $priridad
     *
     * @return Ctlprioridad
     */
    public function setPriridad($priridad)
    {
        $this->priridad = $priridad;

        return $this;
    }

    /**
     * Get priridad
     *
     * @return string
     */
    public function getPriridad()
    {
        return $this->priridad;
    }
}
