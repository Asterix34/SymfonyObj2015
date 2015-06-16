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

    public function preUpdate(LifecycleEventArgs $args) {
        return $this->prePersist($args);
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // peut-être voulez-vous seulement agir sur une entité « Product »
        if ($entity instanceof Article) {
            //$slugger = $this->get('slugger');
            $slugger = new Slugger();
            $slug = $slugger->getSlug($entity->getTitre());
            $entity->setSlug($slug);
        }
    }

}
