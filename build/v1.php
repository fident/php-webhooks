<?php

use Packaged\Helpers\Strings;

require dirname(__DIR__) . '/vendor/autoload.php';

$outputDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src'
  . DIRECTORY_SEPARATOR . 'Generated' . DIRECTORY_SEPARATOR . 'V1';
if(!file_exists($outputDir))
{
  mkdir($outputDir, 0777, true);
}
$files = glob(__DIR__ . DIRECTORY_SEPARATOR . 'tmp_webhooks/*.json');
$mutations = ['UPDATE' => [], 'CREATE' => []];
$mutationCount = 0;

function filenameToClass($file)
{
  return ucfirst($file);
}

foreach($files as $file)
{
  $json = json_decode(file_get_contents($file));
  $filename = basename($file, '.json');
  $className = filenameToClass($json->name ?? $filename);

  $src = [];
  $src[] = '<?php';
  $src[] = 'namespace Fident\\Webhooks\\Generated\\V1;';
  $src[] = '';
  $src[] = 'use Fident\\Webhooks\\WebhookFoundation;';
  $src[] = '';
  if(isset($json->description))
  {
    $src[] = '/**';
    $src[] = ' * ' . $json->description;
    $src[] = ' */';
  }
  $src[] = 'class ' . $className . ' extends WebhookFoundation';
  $src[] = '{';

  $setters = [];

  foreach($json->properties as $property => $propertyDefinition)
  {
    if(isset($propertyDefinition->enum))
    {
      foreach($propertyDefinition->enum as $enum)
      {
        $src[] = '  const '
          . strtoupper(str_replace(' ', '_', Strings::splitOnCamelCase($property . '_' . $enum)))
          . ' = "' . addslashes($enum) . '";';
      }
    }

    $docBlock = [];
    if(isset($propertyDefinition->description))
    {
      $docBlock[] = '   * ' . $propertyDefinition->description;
      $docBlock[] = '   *';
    }

    if(isset($propertyDefinition->type))
    {
      if($propertyDefinition->type == "array" && isset($propertyDefinition->items))
      {
        if(isset($propertyDefinition->items->{'$ref'}))
        {
          $ref = $propertyDefinition->items->{'$ref'};
          $class = filenameToClass(basename($ref, '.json'));
          $docBlock[] = '   * @var ' . $class . '[]';
          $setters[$property] = "$class::manyFromSource(\$value)";
        }
        else if(isset($propertyDefinition->items->type))
        {
          $docBlock[] = '   * @var ' . $propertyDefinition->items->type . '[]';
        }
      }
      else
      {
        $docBlock[] = '   * @var ' . $propertyDefinition->type;
      }
    }
    else if(isset($propertyDefinition->{'$ref'}))
    {
      $ref = $propertyDefinition->{'$ref'};
      $class = filenameToClass(basename($ref, '.json'));
      $docBlock[] = '   * @var ' . $class;
      $setters[$property] = "$class::fromSource(\$value)";
    }

    if(!empty($docBlock))
    {
      $src[] = '  /**';
      $src = array_merge($src, $docBlock);
      $src[] = '   */';
    }

    $src[] = '  public $' . $property . ';';
    $src[] = '';
  }

  if(!empty($setters))
  {
    $src[] = '  protected function _set($property, $value)';
    $src[] = '  {';
    foreach($setters as $property => $setter)
    {
      $src[] = '    if($property == \'' . $property . '\')';
      $src[] = '    {';
      $src[] = '      $this->' . $property . ' = ' . $setter . ';';
      $src[] = '      return;';
      $src[] = '    }';
      $src[] = '';
    }
    $src[] = '    parent::_set($property, $value);';
    $src[] = '  }';
  }

  $src[] = '}';
  $src[] = '';

  $outputFile = $outputDir . DIRECTORY_SEPARATOR . $className . '.php';
  $data = implode(PHP_EOL, $src);

  $exists = file_exists($outputFile);
  if(!$exists || file_get_contents($outputFile) != $data)
  {
    file_put_contents($outputFile, $data);
    $mutations[$exists ? 'UPDATE' : 'CREATE'][] = $className;
    $mutationCount++;
  }
}

if($mutationCount > 0)
{
  $file = fopen('v1.changelog.md', 'a+');
  if($file)
  {
    fwrite($file, "####Build Process @ " . date("Y-m-d H:i:s") . PHP_EOL);
    foreach(['CREATE' => 'New Classes', 'UPDATE' => 'Updated Classes'] as $state => $message)
    {

      if(!empty($mutations[$state]))
      {
        fwrite($file, "####$message" . PHP_EOL);
        foreach($mutations[$state] as $class)
        {
          fwrite($file, "- $class" . PHP_EOL);
        }
      }
    }

    fwrite($file, PHP_EOL);
    fclose($file);
  }
}
