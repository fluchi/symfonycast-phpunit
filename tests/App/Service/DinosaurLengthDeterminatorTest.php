<?php 

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\DinosaurLengthDeterminator\DinosaurLengthDeterminator;
use App\Entity\Dinosaur;

class DinosaurLengthDeterminatorTest extends TestCase{

	/**
	 * @dataProvider getSpecLengthTests
	 */
	public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize){

		$determinator = new DinosaurLengthDeterminator();
		$actualSize = $determinator->getLengthFromSpecification($spec);

		$this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
		$this->assertLessThanOrEqual($maxExpectedSize, $actualSize);
	}

	public function getSpecLengthTests(){
		return [
			['large carnivorous dinosaur', Dinosaur::LARGE , Dinosaur::HUGE-1],
			'default response' => ['give me all the cookies', 0, Dinosaur::LARGE-1],
			['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE-1],
			['huge herbivore', Dinosaur::HUGE, 100],
			['huge dinosaur', Dinosaur::HUGE, 100],
			['huge dino', Dinosaur::HUGE, 100],
			['OMG', Dinosaur::HUGE, 100],
			['😱', Dinosaur::HUGE, 100],
		];
	}
}
?>