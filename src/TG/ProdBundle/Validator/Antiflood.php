<?php
namespace TG\ProdBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antiflood extends Constraint
{
  public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci d'attendre un peu.";

  public function validateBy()
  {
  	return 'tg_prod_antiflood';
  }
}