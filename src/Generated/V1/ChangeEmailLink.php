<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A link to update the address on the users account
 */
class ChangeEmailLink extends WebhookFoundation
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
   * The accounts updated address and recipient of the change link
   *
   * @var string
   */
  public $emailAddress;

  /**
   * The link that once clicked will confirm the accounts new address
   *
   * @var string
   */
  public $changeEmailLink;

}
