<?php
namespace TG\ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TG\ClientBundle\Entity\Client;

class LoadClient implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
      'Client 1',
      'Client 2',
      'Client 3',
      'Client 4',
      'Client 5'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $client = new Client();
      $client->setName($name);
      $client->setAdresse("adresse $name");
      $client->setCp("31800");
      $client->setVille("Ville $name");
      $client->setTel("Téléphone $name");
      $client->setFax("Fax $name");
      $client->setEmail("Email $name");
      $client->setContact("Contact $name");

      // On la persiste
      $manager->persist($client);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}