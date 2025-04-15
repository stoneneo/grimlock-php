<?php

namespace Grimlock\Tests\Module\Mailer;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Module\Mailer\Bean\MailSettings;
use Grimlock\Module\Mailer\GrimlockMailer;
use PHPUnit\Framework\TestCase;

class GrimlockMailerTest extends TestCase
{

    /**
     * @throws GrimlockException
     */
    public function testGrimlockMailerException()
    {
        $mailSettings = new MailSettings();
        $this->expectException(GrimlockException::class);
        new GrimlockMailer($mailSettings);
    }

}