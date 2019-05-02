<?php 

namespace App\Factory;

use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminator\DinosaurLengthDeterminator;
class DinosaurFactory{

	private $lengthDeterminator;

	public function __construct(DinosaurLengthDeterminator $lengthDeterminator){
		$this->lengthDeterminator = $lengthDeterminator;
	}

	public function growVelociraptor(int $length) : Dinosaur{

		return $this->createDinosaur('Velociraptor', true, $length);
	} 

	private function createDinosaur(string $genus, bool $isCarnivorous, int $length) : Dinosaur{

		$dinosaur = new Dinosaur($genus, $isCarnivorous);
		$dinosaur->setLength($length);

		return $dinosaur;
	}

	public function growFromSpecification(string $specification) : Dinosaur{

		// defaults
		$codeName = 'InG-' . random_int(1, 999999);
		// $isCarnivorous = false;
		$length = $this->lengthDeterminator->getLengthFromSpecification($specification);

		// if(strpos($specification, 'carnivorous') !== false){
		// 	$isCarnivorous = true;
		// } else {
		// 	$isCarnivorous = false;
		// }

		$isCarnivorous = (strpos($specification, 'carnivorous') !== false ? true : false);

		$dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);

		return $dinosaur;
	}
}
?>