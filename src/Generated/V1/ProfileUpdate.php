<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

/**
 * A notification indicating that the profile for an identity has been updated
 */
class ProfileUpdate extends WebhookFoundation
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
   * The updated first name for the identity
   *
   * @var string
   */
  public $firstName;

  /**
   * The updated last name for the identity
   *
   * @var string
   */
  public $lastName;

}
