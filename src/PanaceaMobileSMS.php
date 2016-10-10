<?php

namespace Superbalist\SimpleSMSPanaceaMobile;

use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use Superbalist\PanaceaMobile\PanaceaMobileAPI;

class PanaceaMobileSMS extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive;

    /**
     * @var PanaceaMobileAPI
     */
    protected $client;

    /**
     * @param PanaceaMobileAPI $client
     */
    public function __construct(PanaceaMobileAPI $client)
    {
        $this->client = $client;
    }

    /**
     * Sends a SMS message.
     *
     * @param OutgoingMessage $message
     */
    public function send(OutgoingMessage $message)
    {
        $from = $message->getFrom();
        $composeMessage = $message->composeMessage();

        foreach ($message->getTo() as $to) {
            $this->client->sendMessage($to, $composeMessage, $from);
        }
    }
}
