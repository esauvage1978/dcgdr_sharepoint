<?php


namespace App\History;


use App\Entity\Contact;
use App\Entity\Rubric;
use App\Manager\HistoryManager;
use Symfony\Component\Security\Core\Security;

class RubricHistory extends HistoryAbstract
{
    public function __construct(
        HistoryManager $manager,
        Security $securityContext
    ) {
        parent::__construct($manager,$securityContext);
    }

    public function compare(Rubric $contactOld, Rubric $contactNew)
    {
        $this->history->setRubric($contactNew);
        $diffPresent=false;

        $this->compareFieldOneToOne('Thématique','Name',$contactOld->getThematic(),$contactNew->getThematic()) &&$diffPresent=true;
        $this->compareField('Nom',$contactOld->getName(),$contactNew->getName()) &&$diffPresent=true;
        $this->compareFieldBool('Afficher',$contactOld->getEnable(),$contactNew->getEnable()) &&$diffPresent=true;
        $this->compareField('Description',$contactOld->getContent(),$contactNew->getContent()) &&$diffPresent=true;

        if($diffPresent) {
            $this->save();
        }
    }
}