<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipousuario
 *
 * @ORM\Table(name="TipoUsuario")
 * @ORM\Entity
 */
class Tipousuario
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
     * @ORM\Column(name="tipoUsuario", type="string", length=50, nullable=false)
     */
    private $tipousuario;



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
     * Set tipousuario
     *
     * @param string $tipousuario
     *
     * @return Tipousuario
     */
    public function setTipousuario($tipousuario)
    {
        $this->tipousuario = $tipousuario;

        return $this;
    }

    /**
     * Get tipousuario
     *
     * @return string
     */
    public function getTipousuario()
    {
        return $this->tipousuario;
    }
}
