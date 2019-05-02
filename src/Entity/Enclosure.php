<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Dinosaur;
use App\Exception\NotABuffetException;
use App\Exception\DinosaursAreRunningRampantException;
use App\Entity\Security;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosures")
 */
class Enclosure{

	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
	private $dinosaurs;

	/**
	 * @var Collection\Security[]
     * @ORM\OneToMany(targetEntity="App\Entity\Security", mappedBy="enclosure", cascade={"persist"})
	 */
	private $securities;

	public function __construct(bool $withBasicSecurity = false){
		$this->dinosaurs = new ArrayCollection();
		$this->securities = new ArrayCollection();

		if($withBasicSecurity){
			$this->addSecurity(new Security('Fence', true, $this));
		}
	}

	public function addSecurity(Security $security){
		$this->securities[] = $security;
	}

	public function getDinosaurs() : Collection{
		return $this->dinosaurs;
	}

	public function addDinosaur(Dinosaur $dino){

		if(!$this->canAddDinosaur($dino)){
			throw new NotABuffetException();

		}

		if(!$this->isSecurityActive()){
			throw new DinosaursAreRunningRampantException('Are you craazy?!?!');
		}

		$this->dinosaurs[] = $dino;
	}

	public function isSecurityActive(): bool{
		foreach ($this->securities as $security) {
			if($security->getIsActive()){
				return true;
			}
		}
		return false;
	}

	public function getSecurities() : Collection {
		return $this->securities;
	}

	private function canAddDinosaur(Dinosaur $dinosaur) : bool{
		return
			count($this->dinosaurs) === 0 or
			$this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
	}
}
?>
