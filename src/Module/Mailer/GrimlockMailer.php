<?php

namespace Grimlock\Module\Mailer;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Util\GrimlockList;
use Grimlock\Module\Mailer\Bean\MailPerson;
use Grimlock\Module\Mailer\Bean\MailSender;
use Grimlock\Module\Mailer\Bean\MailSettings;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class GrimlockMailer SMTP
 * @package Grimlock
 */
class GrimlockMailer
{

    private PHPMailer $phpMailer;

    /**
     * @param bool $mailAuth
     * @param bool $autoTls
     * @param bool $debug
     * @throws GrimlockException
     */
    public function __construct(bool $mailAuth = true, bool $autoTls = false, bool $debug = false)
    {
        if (empty($_ENV['MAIL_HOST']) || $_ENV['MAIL_HOST'] == '')
        {
            throw new GrimlockException(GrimlockMailer::class,  'Mail Host [MAIL_HOST] not found or empty');
        }
        if (empty($_ENV['MAIL_PORT']) || $_ENV['MAIL_PORT'] == '')
        {
            throw new GrimlockException(GrimlockMailer::class,  'Mail Port [MAIL_PORT] not found or empty');
        }
        if (empty($_ENV['MAIL_USER']) || $_ENV['MAIL_USER'] == '')
        {
            throw new GrimlockException(GrimlockMailer::class,  'Mail User [MAIL_USER] not found or empty');
        }
        if (empty($_ENV['MAIL_PASS']) || $_ENV['MAIL_PASS'] == '')
        {
            throw new GrimlockException(GrimlockMailer::class,  'Mail Pass [MAIL_PASS] not found or empty');
        }
        $this->phpMailer = new PHPMailer();
        $this->phpMailer->CharSet = "utf-8";
        $this->phpMailer->IsSMTP();
        $this->phpMailer->SMTPAuth = $mailAuth;
        if($debug)
            $this->phpMailer->SMTPDebug = 2;
        $this->phpMailer->Host = $_ENV['MAIL_HOST'];
        $this->phpMailer->Port = $_ENV['MAIL_PORT'];
        $this->phpMailer->Username = $_ENV['MAIL_USER'];
        $this->phpMailer->Password = $_ENV['MAIL_PASS'];
        $this->phpMailer->SMTPSecure = 'tls';
        $this->phpMailer->SMTPAutoTLS = $autoTls;
        $this->phpMailer->IsHTML(true);
    }


    /**
     * Generate Mail
     * @throws GrimlockException
     * @throws Exception
     */
    public function generateMail(MailSender $sender, MailPerson $address, $subject, $body, GrimlockList $lAddressCc = null, GrimlockList $lAddressBcc = null, GrimlockList $lAttachments = null): void
    {
        $this->phpMailer->From = $sender->getEmail();
        $this->phpMailer->FromName = $sender->getName();
        $this->phpMailer->AddAddress($address->getEMail(), $address->getName());

        if($lAddressCc != null){
            for ($i = 0; $i < $lAddressCc->getSize(); $i++){
                $ccAddress = $lAddressCc->getItem($i);
                $this->phpMailer->addCC($ccAddress->getEMail(), $ccAddress->getName());
            }
        }
        if($lAddressBcc != null){
            for ($i = 0; $i < $lAddressBcc->getSize(); $i++){
                $bccAddress = $lAddressBcc->getItem($i);
                $this->phpMailer->addBCC($bccAddress->getEMail(), $bccAddress->getName());
            }
        }

        if($lAttachments != null){
            for($i = 0; $i < $lAttachments->getSize(); $i++){
                $bAttachment = $lAttachments->getItem($i);
                $attachment = base64_decode($bAttachment->getBase64());
                $this->phpMailer->addStringAttachment($attachment, $bAttachment->getName(), "base64", $bAttachment->getType());
            }
        }

        $this->phpMailer->Subject = $subject;
        $this->phpMailer->Body = $body;
    }

    /**
     * Generate HTML
     * @throws GrimlockException
     */
    public function generateHtml($html, GrimlockList $lParameters = null): void
    {
        if($lParameters != null){
            for($i = 0; $i < $lParameters->getSize(); $i++){
                $parameter = $lParameters->getItem($i);
                $html = str_replace($parameter->getName(), $parameter->getValue(), $html);
            }
        }

        $this->phpMailer->Body = $html;
    }

    /**
     * @throws Exception
     */
    public function send(): bool
    {
        $res = $this->phpMailer->Send();
        if($res > 0){
            return true;
        }
        else {
            return false;
        }
    }

}