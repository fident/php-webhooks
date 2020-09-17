<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A notification indicating that the email address for an identity has been updated
 */
class EmailUpdate extends WebhookFoundation
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

  /**
   * The updated email address for the identity
   *
   * @var string
   */
  public $emailAddress;

}
