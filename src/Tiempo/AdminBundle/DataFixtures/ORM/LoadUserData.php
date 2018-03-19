<?php

namespace Tiempo\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tiempo\AdminBundle\Entity\Usuarios;
use Tiempo\AdminBundle\Entity\Roles;

class LoadUserData implements FixtureInterface, ContainerAwareInterface{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null){
        var_dump('getting container here');
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager){

    	$rolead = new Roles();
        $rolead->setNombre('Administrador');
        $rolead->setRol('ROLE_ADMIN');
        $manager->persist($rolead);

        $roleusr = new Roles();
        $roleusr->setNombre('Usuario');
        $roleusr->setRol('ROLE_USER');
        $manager->persist($roleusr);


        $user = new Usuarios();
        
        $user->setUsername('admin');
        $user->setEmail('vicente.monsalve@outlook.com');
        $user->setSalt(md5(uniqid()));
        
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword('admin4685', $user->getSalt()));

        $user->setIsActive(1);
        $user->setRoles($rolead);
        $manager->persist($user);

        $manager->flush();

    }
}