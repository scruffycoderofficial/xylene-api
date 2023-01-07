<?php

namespace Xylene\Demo\App\Party\Entity;

use DateTime;

/**
 * Class Party
 *
 * @package Xylene\Demo\App\Party\Entity
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class Party
{
    /**
     * @var string $name
     */
    protected $name;

    /** @var DateTime $addedOn */
    protected $addedOn = null;

    /**
     * @var bool $onBoarded
     */
    protected $onBoarded = false;

    /**
     * @var DateTime $onBoardingDate
     */
    protected $onBoardingDate = null;

    /**
     * Party constructor.
     * s
     * @param string $name
     * @param bool $onBoarded
     */
    public function __construct(string $name, $onBoarded = false)
    {
        $this->name = $name;

        if (is_null($this->addedOn)) {

            $this->addedOn = new DateTime('now');
        }

        $this->onBoarded = $onBoarded;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Party
     */
    public function setName(string $name): Party
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getAddedOn(): ?DateTime
    {
        return $this->addedOn;
    }

    /**
     * @param DateTime|null $addedOn
     * @return Party
     */
    public function setAddedOn(?DateTime $addedOn): Party
    {
        $this->addedOn = $addedOn;
        return $this;
    }

    public function onBoarded(): bool
    {
        return $this->onBoarded;
    }

    public function setOnBoardingDate(DateTime $onBoardingDate)
    {
        $this->onBoardingDate = $onBoardingDate;
    }

    public function getOnBoardingDate(): ?DateTime
    {
        return $this->onBoardingDate;
    }
}
