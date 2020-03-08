<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BackpackExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sumBackpackForRubricEnable', [$this, 'sumBackpackForRubricEnable']),
            new TwigFilter('sumBackpackForUnderRubricEnable', [$this, 'sumBackpackForUnderRubricEnable']),
        ];
    }

    public function sumBackpackForRubricEnable($underRubrics = [])
    {
        $nbr = 0;
        foreach ($underRubrics as $underrubric) {
            foreach ($underrubric->getBackpacks() as $backpack) {
                if (
                    $underrubric->getEnable()
                    && $underrubric->getUnderThematic()->getEnable()
                    && $backpack->getEnable()
                ) {
                    $nbr = $nbr + 1;
                }
            }
        }
        return $nbr;
    }

    public function sumBackpackForUnderRubricEnable($backpacks = [])
    {
        $nbr = 0;
        foreach ($backpacks as $backpack) {
            if (
            $backpack->getEnable()
            ) {
                $nbr = $nbr + 1;
            }
        }
        return $nbr;
    }
}
