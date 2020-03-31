<?php
namespace Fident\Webhooks;

use function array_keys;
use function get_object_vars;

abstract class WebhookFoundation
{
  public static function fromSource(object $source)
  {
    $hook = new static();
    foreach(array_keys(get_object_vars($hook)) as $var)
    {
      if(isset($source->{$var}))
      {
        $hook->_set($var, $source->{$var});
      }
    }
    return $hook;
  }

  public static function manyFromSource(array $items): array
  {
    $result = [];
    foreach($items as $item)
    {
      $result[] = static::fromSource($item);
    }
    return $result;
  }

  protected function _set($property, $value)
  {
    $this->{$property} = $value;
  }
}
