<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctlrol
 *
 * @ORM\Table(name="ctlRol")
 * @ORM\Entity
 */
class Ctlrol
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
     * @ORM\Column(name="rol", type="string", length=100, nullable=false)
     */
    private $rol;



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
     * Set rol
     *
     * @param string $rol
     *
     * @return Ctlrol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }
}
