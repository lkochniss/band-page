<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(__DIR__ . '/fixtures_dev.yaml')->getObjects();

        $systemUser = new User();
        $systemUser->setUsername('System User');

        foreach ($objectSet as $object) {
            $manager->getRepository(get_class($object))->save($object, $systemUser);
        }
    }

    /**
     * @param ContainerInterface|null $containerInterface ContainerInterface.
     */
    public function setContainer(ContainerInterface $containerInterface = null): void
    {
        $this->container = $containerInterface;
    }
}
