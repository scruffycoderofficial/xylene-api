<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\App\Party;

use OffCut\RestfulApi\App\Party\Entity\Party;
use OffCut\RestfulApi\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PartyController
 *
 * @package OffCut\RestfulApi\App\Party
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
class PartyController extends AbstractController
{
    /**
     * A list of Parties registered on the System
     */
    public function parties(): JsonResponse
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
}