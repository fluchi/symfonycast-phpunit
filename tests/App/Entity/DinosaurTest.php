<?php 

namespace Tests\App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Dinosaur;

class DinosaurTest extends TestCase{

	public function testSettingLength(){

		$dinosaur = new Dinosaur();
		$this->assertSame(0, $dinosaur->getLength());

		$dinosaur->setLength(9);
		$this->assertSame(9, $dinosaur->getLength());
	}

	public function testDinosaurIsNotShrunk(){

		$dinosaur = new Dinosaur();
		$dinosaur->setLength(15);

		$this->assertGreaterThan(12, $dinosaur->getLength(), 'Did you put him into a wash machine?');
	}


	public function testReturnsFullSpecificationOfADinosaur(){

		$dino = new Dinosaur();
		$this->assertSame(
			'The unknow non-carnivorous dinosaur is 0 meters long', 
			$dino->getSpecification()
		);

	}

	public function testReturnsFullSpecificationOfATyrannosaurus(){
		$dino = new Dinosaur('Tyrannosaurus', true);
		$dino->setLength(12);

		$this->assertSame(
			'The Tyrannosaurus carnivorous dinosaur is 12 meters long', 
			$dino->getSpecification()
		);

	}

}
?>