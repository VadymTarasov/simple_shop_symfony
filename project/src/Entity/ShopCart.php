<?php

namespace App\Entity;

use App\Repository\ShopCartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopCartRepository::class)]
class ShopCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $session_id;

    #[ORM\ManyToOne(targetEntity: ShopItems::class, inversedBy: 'shopCarts')]
    private $shop_item;

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

    public function getShopItem(): ?ShopItems
    {
        return $this->shop_item;
    }

    public function setShopItem(?ShopItems $shop_item): self
    {
        $this->shop_item = $shop_item;

        return $this;
    }
}
