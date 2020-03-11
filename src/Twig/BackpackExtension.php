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
            new TwigFilter('hasNewForRubric', [$this, 'hasNewForRubric']),
            new TwigFilter('hasNewForUnderRubric', [$this, 'hasNewForUnderRubric']),
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
                    && !$backpack->getArchiving()
                ) {
                    $nbr = $nbr + 1;
                }
            }
        }
        return $nbr;
    }

    public function hasNewForRubric($underRubrics = [])
    {
        $nbr = 0;
        foreach ($underRubrics as $underrubric) {
            foreach ($underrubric->getBackpacks() as $backpack) {
                if (
                    $underrubric->getEnable()
                    && $underrubric->getUnderThematic()->getEnable()
                    && $backpack->getEnable()
                    && !$backpack->getArchiving()
                ) {
                    if ($this->getNbrDayBeetwenDates(new \DateTime(), $backpack->getUpdateAt()) < 8) {
                        $nbr = $nbr + 1;
                    }
                }
            }
        }
        return $nbr;
    }

    private function getNbrDayBeetwenDates(\DateTime $date1, \DateTime $date2)
    {

        $nbJoursTimestamp = $date1->getTimestamp() - $date2->getTimestamp();

        return round($nbJoursTimestamp / 86400);
    }

    public function sumBackpackForUnderRubricEnable($backpacks = [])
    {
        $nbr = 0;
        foreach ($backpacks as $backpack) {
            if (
                $backpack->getEnable()
                && !$backpack->getArchiving()
            ) {
                $nbr = $nbr + 1;
            }
        }
        return $nbr;
    }

    public function hasNewForUnderRubric($backpacks = [])
    {
        $nbr = 0;
        foreach ($backpacks as $backpack) {
            if (
                $backpack->getEnable()
                && !$backpack->getArchiving()
            ) {
                if ($this->getNbrDayBeetwenDates(new \DateTime(), $backpack->getUpdateAt()) < 8) {
                    $nbr = $nbr + 1;
                }
            }
        }
        return $nbr;
    }

}
