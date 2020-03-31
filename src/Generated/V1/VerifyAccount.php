<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A link for a user to verify their account
 */
class VerifyAccount extends WebhookFoundation
{
  /**
   * ID for the identity requesting a login link
   *
   * @var string
   */
  public $identity;

  /**
   * Link for the user to click to verify their account (Single Use)
   *
   * @var string
   */
  public $verifyLink;

  /**
   * Users first name
   *
   * @var string
   */
  public $firstName;

  /**
   * Users last name
   *
   * @var string
   */
  public $lastName;

  /**
   * Users email address
   *
   * @var string
   */
  public $emailAddress;

}
