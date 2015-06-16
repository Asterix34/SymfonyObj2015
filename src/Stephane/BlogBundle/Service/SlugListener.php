<?php

namespace Stephane\BlogBundle\Service;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Stephane\BlogBundle\Entity\Article;

/**
 * Description of SlugGenerator
 *
 * @author benjamin
 */
class SlugListener {

    private $slugger;
    
    public function setSlugger($slugger) {
        $this->slugger = $slugger;
        return $this;
    }

    public function preUpdate(LifecycleEventArgs $args) {
        return $this->prePersist($args);
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        // peut-être voulez-vous seulement agir sur une entité « Article »
        if ($entity instanceof Article) {
            $slug = $this->slugger->getSlug($entity->getTitre());
            $entity->setSlug($slug);
        }
    }

}
