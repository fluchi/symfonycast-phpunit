<?php 

namespace Tests\App\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\DinosaurFactory;
use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminator\DinosaurLengthDeterminator;
/**
 * 
 */
class DinosaurFactoryTest extends TestCase
{

	/**
	 * @var DinosaurFactory
	 */
	private $factory;

	public function setUp(){

		$mockDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
		$this->factory = new DinosaurFactory($mockDeterminator);
	}

	public function testItGrowsAVelociraptor(){
		$dinosaur = $this->factory->growVelociraptor(5);

		// make sure that returns a dinosaur class
		$this->assertInstanceOf(Dinosaur::class, $dinosaur);
		$this->assertInternalType('string', $dinosaur->getGenus());
		$this->assertSame('Velociraptor', $dinosaur->getGenus());
		$this->assertSame(5, $dinosaur->getLength());
	}

	public function testItGrowsATriceratops(){

		$this->markTestIncomplete('Waiting for a confirmation of someone else');
	}

	public function testItGrowsABabyVelociraptor(){

		if(!class_exists('Nanny')){
			$this->markTestSkipped('There is no one to watch the baby');
		}

		$dinosaur = $this->factory->growVelociraptor(2);
		$this->assertSame(1, $dinosaur->getLength());
	}


	/**
	 * @dataProvider getSpecificationTest
	 */
	public function testItGrowsADinosaurFromASpecification(string $spec, bool $expectedIsCarnivorous){

		$dinosaur = $this->factory->growFromSpecification($spec);

		$this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diet do not match');
	}

	public function getSpecificationTest(){
		return [
			// specification is large and carnivorous
			['large carnivorous dinosaur', true],
			'default response' => ['give me all the cookies', false],
			['large herbivore', false],
			['huge herbivore', false]
		];
	}
}

?>