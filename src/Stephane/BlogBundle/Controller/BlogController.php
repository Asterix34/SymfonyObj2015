<?php

namespace Stephane\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Stephane\BlogBundle\Entity\Article;
use Stephane\BlogBundle\Entity\Image;
use Stephane\BlogBundle\Entity\Commentaire;
use Stephane\BlogBundle\Entity\Categorie;
use Stephane\BlogBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/Blog")
 */
class BlogController extends Controller {

    public function indexAction($page) {
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('StephaneBlogBundle:Article');
        //$listeArticles = $repository->findall();
        $listeArticles = $repository->getArticles();
        return $this->render('StephaneBlogBundle:Blog:index.html.twig', array('page' => $page,
                    'listeArticles' => $listeArticles));
    }

    /**
     * @Route("/article/{id}", name="stephane_blog_voir", requirements={"id" = "\d+"})
     * @Template()
     */
    public function voirAction(Article $article) {

        return array('article' => $article); 
    }

    public function ajouterAction() {
        $article = new Article;

        $form = $this->createForm(new ArticleType, $article);

        $request = $this->getRequest();
        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();
            }
        }


//        $formBuilder = $this->createFormBuilder($article);
//        $formBuilder
//        	->add('titre' , 'text')
//        	->add('contenu' , 'textarea')
//        	->add('auteur' , 'text')
//        	->add('datecreation', 'datetime')
//        	->add('publication', 'checkbox');
//        $form = $formBuilder->getForm();
//        $image = new Image;
//        $image->setSrc("tof1.jpg");
//        $image->setAlt("tof1");
//        
//        $commentaire = new Commentaire;
//        $commentaire->setAuteur('Bloby')
//        			->setContenu('la  vida de loca')
//        			->setDate(new \DateTime)
//        			->setArticle($article);
//        
//        $commentaire1 = new Commentaire;
//        $commentaire1->setAuteur('gargamel')
//        			->setContenu('stroumffff !!!')
//        			->setDate(new \DateTime)
//        			->setArticle($article);
//
//        		
//        $categorie = new Categorie;
//        $categorie->setNom('slacker');
//        
//        $categorie1 = new Categorie;
//        $categorie1->setNom('loser');
//       
//        $article->setTitre('lord of underneath')
//        		->setAuteur('leather face')
//        		->setContenu('tronconnnnnnnnnnne!!!')
//        		->setImage($image)
//        		->addCategory($categorie)
//        		->addCategory($categorie1);
//        $em = $this->getDoctrine()->getManager();  // entity manager
//        $em->persist($commentaire);
//        $em->persist($commentaire1);
//        $em->persist($categorie);
//        $em->persist($categorie1);
//        $em->persist($article);
//        $article2 = new Article;
//        $image2 = new Image;
//        $image2->setSrc("tof2.jpg");
//        $image2->setAlt("tof2");
//        $article2->setTitre('BYbye world')
//        		->setAuteur('john X')
//        		->setContenu('serpentoids')
//        		->setImage($image2);
//        $em->persist($article2);
//        $em->flush();
//        return $this->render('StephaneBlogBundle:Blog:ajouter.html.twig'
//        	,array('article' => $article, 'article2' => $article2));
        return $this->render('StephaneBlogBundle:Blog:ajouter.html.twig'
                        , array('form' => $form->createView()));
    }

    public function modifierAction($id) {
//        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('StephaneBlogBundle:Article');
        $article = $repository->find($id);
        $article->setAuteur('modifman');
//        $em->persist($article); // inutile
//        $em->flush();
        //return $this->render('StephaneBlogBundle:Blog:modifier.html.twig', array('article' => $article));
        return $this->redirect($this->generateUrl('stephane_blog_voir', array('id' => $article->getId())));
    }

    public function menuAction() {
//        $articles = array(
//        	array('titre'=>'hello world 1', 'contenu'=>'Lorem ipsum dolor'),
//        	array('titre'=>'hello world 2', 'contenu'=>'Lorem ipsum dolor'),
//        	array('titre'=>'hello world 3', 'contenu'=>'Lorem ipsum dolor')
//        );
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('StephaneBlogBundle:Article');
        $articles = $repository->findBy(array('publication' => 1), array('datecreation' => 'desc'), 3, 0);
        return $this->render('StephaneBlogBundle:Blog:menu.html.twig', array('articles' => $articles));
    }

}
