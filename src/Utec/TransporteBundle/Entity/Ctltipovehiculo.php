<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ctltipovehiculo
 *
 * @ORM\Table(name="ctlTipoVehiculo")
 * @ORM\Entity
 */
class Ctltipovehiculo
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
     * @ORM\Column(name="tipoVehiculo", type="string", length=30, nullable=false)
     */
    private $tipovehiculo;



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
     * Set tipovehiculo
     *
     * @param string $tipovehiculo
     *
     * @return Ctltipovehiculo
     */
    public function setTipovehiculo($tipovehiculo)
    {
        $this->tipovehiculo = $tipovehiculo;

        return $this;
    }

    /**
     * Get tipovehiculo
     *
     * @return string
     */
    public function getTipovehiculo()
    {
        return $this->tipovehiculo;
    }
}
