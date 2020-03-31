<?php
namespace Fident\Webhooks;

use Fident\Webhooks\Generated\V1\LoginLink;
use Fident\Webhooks\Generated\V1\ResetPasswordLink;
use Fident\Webhooks\Generated\V1\VerifyAccount;
use Fident\Webhooks\Generated\V1\VerifySetPasswordLink;
use Fident\Webhooks\Generated\V1\Webhook;
use InvalidArgumentException;
use function is_object;
use function json_decode;
use function sha1;

class WebhookParser
{
  protected $_verificationKey;
  private $_dataChecksum;

  /**
   * WebhookParser constructor.
   *
   * @param string $verificationKey This key is available within your ChargeHive account
   */
  public function __construct(string $verificationKey)
  {
    $this->_verificationKey = $verificationKey;
  }

  /**
   * @param string $verificationKey
   *
   * @return WebhookParser
   */
  public function setVerificationKey(string $verificationKey)
  {
    $this->_verificationKey = $verificationKey;
    return $this;
  }

  public function verifyHeaders(array $headers, $verifyKey = null): bool
  {
    //Payload Checksum
    $checksum = isset($headers['x-fident-checksum']) ? $headers['x-fident-checksum'] : '';

    //Verification of the checksum and the account verification key
    $verification = isset($headers['x-fident-verification']) ? $headers['x-fident-verification'] : '';

    //Verify the checksum + verification key matches the verification has
    return sha1($checksum . ($verifyKey ?? $this->_verificationKey)) === $verification;
  }

  public function verifyWebhook(array $headers): bool
  {
    $checksum = isset($headers['x-fident-checksum']) ? $headers['x-fident-checksum'] : '';
    return $this->_dataChecksum === $checksum;
  }

  public function parse(string $rawPayload): Webhook
  {
    $hook = Webhook::fromSource($this->_decodeJson($rawPayload));
    $this->_dataChecksum = sha1($hook->data);
    switch($hook->type)
    {
      case Webhook::TYPE_LOGIN_LINK:
        $hook->data = LoginLink::fromSource($this->_decodeJson($hook->data));
        break;
      case Webhook::TYPE_RESET_PASSWORD_LINK:
        $hook->data = ResetPasswordLink::fromSource($this->_decodeJson($hook->data));
        break;
      case Webhook::TYPE_VERIFY_SET_PASSWORD_LINK:
        $hook->data = VerifySetPasswordLink::fromSource($this->_decodeJson($hook->data));
        break;
      case Webhook::TYPE_VERIFY_ACCOUNT:
        $hook->data = VerifyAccount::fromSource($this->_decodeJson($hook->data));
        break;
    }

    return $hook;
  }

  private function _decodeJson(string $rawPayload)
  {
    $decoded = json_decode($rawPayload, false, 512, JSON_THROW_ON_ERROR);
    if($decoded === null || !is_object($decoded))
    {
      throw new InvalidArgumentException("Invalid json payload provided");
    }
    return $decoded;
  }
}
