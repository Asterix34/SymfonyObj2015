<?php

namespace Stephane\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Stephane\BlogBundle\Entity\ArticleRepository")
 */
class Article {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\Length(
     *      min="10", max="255",
     *      minMessage="Le titre doit faire plus de 10 caractères",
     *      maxMessage="Le titre doit faire moins de 255 caractères"
     * )
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank()
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length( max="255",
     *      maxMessage="L'auteur doit faire moins de 255 caractères."
     * )
     */
    private $auteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     * @Assert\DateTime(message="La date n'est pas dans un format valide.")
     */
    private $datecreation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;

    /**
     * @ORM\ManyToMany(targetEntity="Stephane\BlogBundle\Entity\Categorie")
     * Assert\Count(
     *  min=1,
     *  max=3,
     *  minMessage="Il faut au moins 1 catégorie",
     *  maxMessage="Il faut maximum 3 catégories"
     * )
     */
    private $categories;

    public static function loadValidatorMetadata(ClassMetadata $data) {
        $data->addPropertyConstraint('categories', new Assert\Count(array(
            'min' => 1,
            'max' => 3,
            'minMessage' => 'Vous devez spécifier au moins un email',
            'maxMessage' => 'Vous ne pouvez pas spécifier plus de {{ limit }} emails',
        )));
    }

    /**
     * @ORM\OneToMany(targetEntity="Stephane\BlogBundle\Entity\Commentaire", mappedBy="article", cascade={"persist","remove"})
     */
    private $commentaires;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu) {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu() {
        return $this->contenu;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
     */
    public function setAuteur($auteur) {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur() {
        return $this->auteur;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Article
     */
    public function setDatecreation($datecreation) {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime 
     */
    public function getDatecreation() {
        return $this->datecreation;
    }

    public function __construct() {
        $this->datecreation = new \DateTime;
        $this->publication = true;
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set publication
     *
     * @param boolean $publication
     * @return Article
     */
    public function setPublication($publication) {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication() {
        return $this->publication;
    }

    /**
     * @ORM\OneToOne(targetEntity="Stephane\BlogBundle\Entity\Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * Set image
     *
     * @param \Stephane\BlogBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\Stephane\BlogBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Stephane\BlogBundle\Entity\Image 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Add categories
     *
     * @param \Stephane\BlogBundle\Entity\Categorie $categories
     * @return Article
     */
    public function addCategory(\Stephane\BlogBundle\Entity\Categorie $categories) {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Stephane\BlogBundle\Entity\Categorie $categories
     */
    public function removeCategory(\Stephane\BlogBundle\Entity\Categorie $categories) {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Add commentaires
     *
     * @param \Stephane\BlogBundle\Entity\Commentaire $commentaires
     * @return Article
     */
    public function addCommentaire(\Stephane\BlogBundle\Entity\Commentaire $commentaires) {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Stephane\BlogBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Stephane\BlogBundle\Entity\Commentaire $commentaires) {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires() {
        return $this->commentaires;
    }

}
