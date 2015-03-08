<?php

namespace TG\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TGUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
