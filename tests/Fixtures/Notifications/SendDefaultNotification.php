<?php

namespace Homeful\Common\Tests\Fixtures\Notifications;

use Homeful\Common\Traits\HasDomainNotification;
use Homeful\Common\Interfaces\IsDomainNotification;
use Illuminate\Notifications\Notification;

class SendDefaultNotification extends Notification implements IsDomainNotification
{
    use HasDomainNotification;
}
