<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface PacketaConfigInterface extends ResourceInterface
{
    public function getId(): ?int;

    public function setId(?int $id): void;

    public function getApiKey(): ?String;

    public function setApiKey(?String $apiKey): void;

    public function getSenderLabel(): ?string;

    public function setSenderLabel(?string $senderLabel): void;

    public function getCarrierId(): ?string;

    public function setCarrierId(?string $carrierId): void;

    public function getOptionCountry(): ?string;

    public function setOptionCountry(?string $optionCountry): void;
}
