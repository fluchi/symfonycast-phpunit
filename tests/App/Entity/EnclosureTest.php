<?php 

namespace Tests\App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Enclosure;
use App\Entity\Dinosaur;
use App\Exception\NotABuffetException;
use App\Exception\DinosaursAreRunningRampantException;

class EnclosureTest extends TestCase{

	public function testItHasNoDinosaurByDefault(){

		$enclosure = new Enclosure(true);
		$this->assertEmpty($enclosure->getDinosaurs()); 
	}

	public function testItAddsDinosaurs(){
		
		$enclosure = new Enclosure(true);
		$enclosure->addDinosaur(new Dinosaur());
		$enclosure->addDinosaur(new Dinosaur());

		$this->assertCount(2, $enclosure->getDinosaurs());
	}


	public function testDoNotAllowCarnivorousDinosaursToMixWithHerbivorous(){

		$enclosure = new Enclosure(true);
		$enclosure->addDinosaur(new Dinosaur());

		$this->expectException(NotABuffetException::class);
		$enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
	}

	/**
	 * @expectedException \App\Exception\NotABuffetException
	 */
	public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure(){

		$enclosure = new Enclosure(true);
		$enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
		$enclosure->addDinosaur(new Dinosaur());
	}

	public function testItDoesNotAllowToAddDinosToUnsecureEnclosures(){

		$enclosure = new Enclosure();

		$this->expectException(DinosaursAreRunningRampantException::class);
		$this->expectExceptionMessage('Are you craazy?!?!');

		$enclosure->addDinosaur(new Dinosaur());

	}
}
?>