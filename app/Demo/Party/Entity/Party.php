<?php

namespace Xylene\Demo\Party\Entity;

use DateTime;

/**
 * Class Party
 *
 * @ORM\Entity
 * @ORM\Table(name="parties")
 */
class Party
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=225)
     */
    private $name;

    /**
     * @var DateTime $addedOn
     *
     * @ORM\Column(name="added_on", type="datetime")
     */
    private $addedOn = null;

    /**
     * @var bool $onBoarded
     *
     * @ORM\Column(name="on_boarded", type="boolean")
     */
    private $onBoarded = false;

    /**
     * @var DateTime $onBoardingDate
     *
     * @ORM\Column(name="onboarding_date", type="datetime")
     */
    private $onBoardingDate = null;

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
