<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A notification indicating that the password for an identity has been updated
 */
class PasswordUpdate extends WebhookFoundation
{
  /**
   * ID for the identity of this action
   *
   * @var string
   */
  public $identity;

  /**
   * IP address of where the request for this action originated
   *
   * @var string
   */
  public $ipAddress;

  /**
   * User-agent from where the request for this action originated
   *
   * @var string
   */
  public $userAgent;

}
