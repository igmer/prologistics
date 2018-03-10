<?php

namespace Utec\TransporteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiOpenSessions
 *
 * @ORM\Table(name="api_open_sessions", indexes={@ORM\Index(name="IDX_16D4BFF5FCF8192D", columns={"id_usuario"})})
 * @ORM\Entity
 */
class ApiOpenSessions
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
     * @var guid
     *
     * @ORM\Column(name="uuid", type="guid", nullable=false)
     */
    private $uuid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uuid_created_at", type="datetime", nullable=false)
     */
    private $uuidCreatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uuid_last_used", type="datetime", nullable=true)
     */
    private $uuidLastUsed;

    /**
     * @var \FosUserUser
     *
     * @ORM\ManyToOne(targetEntity="FosUserUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $idUsuario;



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
     * Set uuid
     *
     * @param guid $uuid
     *
     * @return ApiOpenSessions
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return guid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set uuidCreatedAt
     *
     * @param \DateTime $uuidCreatedAt
     *
     * @return ApiOpenSessions
     */
    public function setUuidCreatedAt($uuidCreatedAt)
    {
        $this->uuidCreatedAt = $uuidCreatedAt;

        return $this;
    }

    /**
     * Get uuidCreatedAt
     *
     * @return \DateTime
     */
    public function getUuidCreatedAt()
    {
        return $this->uuidCreatedAt;
    }

    /**
     * Set uuidLastUsed
     *
     * @param \DateTime $uuidLastUsed
     *
     * @return ApiOpenSessions
     */
    public function setUuidLastUsed($uuidLastUsed)
    {
        $this->uuidLastUsed = $uuidLastUsed;

        return $this;
    }

    /**
     * Get uuidLastUsed
     *
     * @return \DateTime
     */
    public function getUuidLastUsed()
    {
        return $this->uuidLastUsed;
    }

    /**
     * Set idUsuario
     *
     * @param \Utec\TransporteBundle\Entity\FosUserUser $idUsuario
     *
     * @return ApiOpenSessions
     */
    public function setIdUsuario(\Utec\TransporteBundle\Entity\FosUserUser $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Utec\TransporteBundle\Entity\FosUserUser
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}