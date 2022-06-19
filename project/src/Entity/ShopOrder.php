<?php

namespace App\Entity;

use App\Repository\ShopOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopOrderRepository::class)]
class ShopOrder
{
    public const STATUS_NEW_ORDER = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $session_id;

    #[ORM\Column(type: 'integer')]
    private $status;

    #[ORM\Column(type: 'string', length: 255)]
    private $user_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $user_email;

    #[ORM\Column(type: 'integer', length: 255)]
    private $user_phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->session_id;
    }

    public function setSessionId(string $session_id): self
    {
        $this->session_id = $session_id;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getUserPhone(): ?int
    {
        return $this->user_phone;
    }

    public function setUserPhone(int $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }
}
