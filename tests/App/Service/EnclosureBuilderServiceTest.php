<?php

namespace Tests\Service;

use App\Factory\DinosaurFactory;
use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Service\EnclosureBuilderService\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderServiceTest extends \PHPUnit\Framework\TestCase{

    public function testItBuildsAndPersistsEnclosure(){
        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->atLeastOnce())
            ->method('flush')
            ;

        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $dinoFactory->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->willReturn(new Dinosaur())
            ->with($this->isType('string'))
            ;

        $builder = new EnclosureBuilderService($em, $dinoFactory);
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }
}
?>
