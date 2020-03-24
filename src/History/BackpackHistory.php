<?php


namespace App\History;


use App\Entity\Backpack;
use App\Manager\HistoryManager;
use Symfony\Component\Security\Core\Security;

class BackpackHistory extends HistoryAbstract
{
    public function __construct(
        HistoryManager $manager,
        Security $securityContext
    ) {
        parent::__construct($manager,$securityContext);
    }

    public function compare(Backpack $backpackOld, Backpack $backpackNew)
    {
        $this->history->setBackpack($backpackNew);
        $diffPresent=false;

        $this->compareField('Nom',$backpackOld->getName(),$backpackNew->getName()) &&$diffPresent=true;
        $this->compareFieldBool('Afficher',$backpackOld->getEnable(),$backpackNew->getEnable()) &&$diffPresent=true;
        $this->compareField('Description',$backpackOld->getContent(),$backpackNew->getContent()) &&$diffPresent=true;
        $this->compareField('Répertoire 1',$backpackOld->getDir1(),$backpackNew->getDir1()) &&$diffPresent=true;
        $this->compareField('Répertoire 2',$backpackOld->getDir2(),$backpackNew->getDir2()) &&$diffPresent=true;
        $this->compareField('Répertoire 3',$backpackOld->getDir3(),$backpackNew->getDir3()) &&$diffPresent=true;
        $this->compareField('Répertoire 4',$backpackOld->getDir4(),$backpackNew->getDir4()) &&$diffPresent=true;
        $this->compareField('Répertoire 5',$backpackOld->getDir5(),$backpackNew->getDir5()) &&$diffPresent=true;
        $this->compareFieldBool('Archive',$backpackOld->getArchiving(),$backpackNew->getArchiving()) &&$diffPresent=true;
        $this->compareFieldOneToOne('Sous-thématique','name',$backpackOld->getUnderRubric(),$backpackNew->getUnderRubric()) &&$diffPresent=true;

        if($diffPresent) {
            $this->save();
        }
    }
}