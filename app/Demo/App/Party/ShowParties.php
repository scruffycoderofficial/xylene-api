<?php

declare(strict_types=1);

namespace Xylene\Demo\App\Party;

use Xylene\Demo\App\Party\Entity\Party;
use Xylene\Action\ActionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ShowParties
 *
 * @package Xylene\Demo\App\Party
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class ShowParties extends ActionHandler
{
    /**
     * A list of Parties registered on the System
     */
    public function show(): JsonResponse|array
    {
        $parties = [];

        $busPartner = new Party('Business Partner');

        /** @var  $busPartner */
        $busPartner->setOnBoardingDate(new \DateTime('now +2 days'));

        $busSponsor = new Party('Business Sponsor');
        $busInvestor = new Party('Business Investor');
        $busDeveloper = new Party('Business Developer');

        array_push($parties, [
            [
                'name' => $busPartner->getName(),
                'engagement_date' => $busPartner->getAddedOn(),
                'onboarded_on' => $busPartner->getOnBoardingDate()
            ],
            [
                'name' => $busInvestor->getName(),
                'engagement_date' => $busInvestor->getAddedOn(),
                'onboarded_on' => $busInvestor->getOnBoardingDate()
            ],
            [
                'name' => $busSponsor->getName(),
                'engagement_date' => $busSponsor->getAddedOn(),
                'onboarded_on' => $busSponsor->getOnBoardingDate()
            ],
            [
                'name' => $busDeveloper->getName(),
                'engagement_date' => $busDeveloper->getAddedOn(),
                'onboarded_on' => $busDeveloper->getOnBoardingDate()
            ],
        ]);

        return new JsonResponse($parties);
    }

    public function registerEvents($vents = []): void
    {
    }
}