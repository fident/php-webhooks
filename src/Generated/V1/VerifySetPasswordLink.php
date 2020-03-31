<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A set password link for a users account
 */
class VerifySetPasswordLink extends WebhookFoundation
{
  /**
   * ID for the identity requesting a login link
   *
   * @var string
   */
  public $identity;

  /**
   * Link for the user to click to login to their account, verify their account and set their password (Single Use)
   *
   * @var string
   */
  public $verifyAndSetLink;

}
