<?php

namespace TG\CalendarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TGCalendarBundle extends Bundle
{
	public function getParent()
    {
        return 'BladeTesterCalendarBundle';
    }
}
