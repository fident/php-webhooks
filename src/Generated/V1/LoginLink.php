<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A login link for a users account
 */
class LoginLink extends WebhookFoundation
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
   * Link for the user to click to login to their account (Single Use)
   *
   * @var string
   */
  public $loginLink;

}
