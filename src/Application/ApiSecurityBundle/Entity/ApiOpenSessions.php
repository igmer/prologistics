<?php

namespace Application\ApiSecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiOpenSessions
 *
 * @ORM\Table(name="api_open_sessions", indexes={@ORM\Index(name="IDX_16D4BFF5FCF8192D", columns={"id_usuario"})})
 * @ORM\Entity(repositoryClass="Application\ApiSecurityBundle\Repository\ApiOpenSessionsRepository")
 */
class ApiOpenSessions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="api_open_sessions_id_seq", allocationSize=1, initialValue=1)
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
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
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
     * @param \Application\Sonata\UserBundle\Entity\User $idUsuario
     * @return ApiOpenSessions
     */
    public function setIdUsuario(\Application\Sonata\UserBundle\Entity\User $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}
