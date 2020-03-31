<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A reset password link for a user
 */
class ResetPasswordLink extends WebhookFoundation
{
  /**
   * ID for the identity requesting a login link
   *
   * @var string
   */
  public $identity;

  /**
   * Link for the user to click to login to their account, and reset their password (Single Use)
   *
   * @var string
   */
  public $resetLink;

}
