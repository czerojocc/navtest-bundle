<?php
declare(strict_types=1);


namespace Flexibill\NavBundle\Entity;

use App\AppBundle\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Flexibill\NavBundle\Model\TokenExchange as Model;

/**
 * @package Flexibill\NavBundle\Entity
 * @ORM\MappedSuperclass()
 *
 * @deprecated Remove when CompanyNavTokenRequest is removed
 */
abstract class TokenExchange extends Model
{
    const ATTR_ID = 'id';
    const ATTR_TOKEN_VALIDITY_FROM = 'tokenValidityFrom';
    const ATTR_TOKEN_VALIDITY_TO = 'tokenValidityTo';
    const ATTR_ENCODED_EXCHANGE_TOKEN = 'encodedExchangeToken';

    use Timestampable;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * Validity start of the issued exchange token
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $tokenValidityFrom;

    /**
     * Validity end of the issued exchange token
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $tokenValidityTo;

    /**
     * The issued exchange token in AES-128 ECB encoded form
     * @var string
     * @ORM\Column(type="string")
     */
    protected $encodedExchangeToken;

    /**
     * TokenExchange constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }
}