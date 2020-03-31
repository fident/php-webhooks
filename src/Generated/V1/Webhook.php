<?php
namespace Fident\Webhooks\Generated\V1;

use Fident\Webhooks\WebhookFoundation;

class Webhook extends WebhookFoundation
{
  /**
   * UUID for the notification
   *
   * @var string
   */
  public $uuid;

  const TYPE_LOGIN_LINK = "loginLink";
  const TYPE_RESET_PASSWORD_LINK = "resetPasswordLink";
  const TYPE_VERIFY_SET_PASSWORD_LINK = "verifySetPasswordLink";
  const TYPE_VERIFY_ACCOUNT = "verifyAccount";
  /**
   * Notification type
   *
   * @var string
   */
  public $type;

  /**
   * Data relating to the notification type
   *
   * @var object
   */
  public $data;

  /**
   * sha1 checksum of the payload
   *
   * @var string
   */
  public $checksum;

  /**
   * sha1 of the checksum + verificationKey
   *
   * @var string
   */
  public $verification;

  /**
   * Timestamp of when the webhook was created, measured in seconds since the Unix epoch
   *
   * @var number
   */
  public $created;

  /**
   * The version of webhook notifications used to render this information
   *
   * @var string
   */
  public $webhookVersion;

  /**
   * The ID of the project this webhook originated from
   *
   * @var string
   */
  public $projectId;

}
