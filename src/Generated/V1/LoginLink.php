<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A login link for a users account
 */
class LoginLink extends WebhookFoundation
{
  /**
   * ID for the identity requesting a login link
   *
   * @var string
   */
  public $identity;

  /**
   * Link for the user to click to login to their account (Single Use)
   *
   * @var string
   */
  public $loginLink;

}
