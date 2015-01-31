[ ![Codeship Status for krystalcode/feature-toggle](https://codeship.io/projects/5d166660-314c-0132-ae62-7e635eaa275b/status)](https://codeship.io/projects/40068)

# FeatureToggle

## About

FeatureToggle is an easy to use, extensible library that aims to provide feature toggle functionality for PHP applications.

## Model

The library model is based on Toggles which are classes that define algorithms used to evaluate whether a feature should be on or off (enabled or disabled). Examples may be a Toggle that reads a configuration file and decides based on a variable value, a Toggle that checks whether the user has a subscription plan, or a Toggle that fetches information from an external API and decides based on that.

## Requirements

Currently depends on the Symfony Yaml component (https://github.com/symfony/yaml).

## How to use

Provided Toggles

### YAML file

The YAML Toggle (ToggleConfigYaml class) loads the configuration variables from a YAML file and decides based on a variable value. It extends the ToggleConfig class which statically stores the configuration vatiables so that they are loaded only once even if feature toggling is used in multiple places in the code.

Assuming the following configuration file contents:

```
awesomefeature/dev: true
awesomefeature/stage: true
awesomefeature/prod: false
```

The following code will enable the feature on the development and stage environments and disable it on the production environment.

```
use KrystalCode\FeatureToggle\Toggle;

if (Toggle::yaml('absolute/path/to/config.yml', 'awesomefeature/'.$yourCurrentEnvironment)) {
    // Code to be executed when the feature is enabled.
}
```

where the variable $yourCurrentEnvironment should have a value of "dev", "stage" or "prod". On runtime, the code will be executed in the development and staging environments but not in the production environment.

The configuration variables may also have other values apart from true or false. Say you would like to enable a feature only when the blue theme is in use:

```
theme: blue
```

The following code will enable the feature when the value of the variable "theme" is "blue".

```
use KrystalCode\FeatureToggle\Toggle;

if (Toggle::yaml('absolute/path/to/config.yml', 'theme', 'blue')) {
    // Code to be executed when the feature is enabled.
}
```

### PHP file

You can load the variables from a PHP configuration file. Using the same example as with YAML, your configuration file contents would be:

```
<?php
return array(
    'awesomefeature/dev' => true,
    'awesomefeature/stage' => true,
    'awesomefeature/prod' => false,
);
```

and your application code would be:

```
use KrystalCode\FeatureToggle\Toggle;

if (Toggle::php('absolute/path/to/config.php', 'awesomefeature/'.$yourCurrentEnvironment)) {
    // Code to be executed when the feature is enabled.
}
```

### INI file

You can load the variables from an INI configuration file (.ini, see http://php.net/manual/en/function.parse-ini-file.php). Using the same example as with YAML, your configuration file contents would be:

```
awesomefeature/dev = true
awesomefeature/stage = true
awesomefeature/prod = false
```

and your application code would be:

```
use KrystalCode\FeatureToggle\Toggle;

if (Toggle::ini('absolute/path/to/config.ini', 'awesomefeature/'.$yourCurrentEnvironment)) {
    // Code to be executed when the feature is enabled.
}
```

### Integrations

#### Yii Framework

You will need to add your configuration in the params.php file (Yii2) or in the main.php file (Yii1) as an array item with index 'featureToggle'. Using the same example as with YAML, your configuration file contents would be:

```
<?php
// Yii2
return [
    'featureToggle' => [
        'awesomefeature/dev' => true,
        'awesomefeature/stage' => true,
        'awesomefeature/prod' => false,
    ],
];

// Yii1
return [
    'params' => [
        'featureToggle' => [
            'awesomefeature/dev' => true,
            'awesomefeature/stage' => true,
            'awesomefeature/prod' => false,
        ],
    ],
];
```

and your application code would be:

```
use KrystalCode\FeatureToggle\Toggle;

// Yii2
if (Toggle::yii2('awesomefeature/'.$yourCurrentEnvironment)) {
    // Code to be executed when the feature is enabled.
}

// Yii1
if (Toggle::yii1('awesomefeature/'.$yourCurrentEnvironment)) {
    // Code to be executed when the feature is enabled.
}
```

## How to extend

Say you would like to enable a feature only for premium users on your website. You can write a custom Toggle as follows:

```
use KrystalCode\FeatureToggle\ToggleInterface;

class TogglePremiumUser implements ToggleInterface
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function on()
    {
        // You can also add your logic here if preferred.
        return $this->user->isPremium();
    }
}
```

## Full syntax

The examples above are using the easy syntax provided by a helper class. The full syntax for the YAML examples would be:

```
use KrystalCode\FeatureToggle\ConfigLoaderYaml;
use KrystalCode\FeatureToggle\ToggleConfig;
use Symfony\Component\Yaml\Parser;

$loader = new ConfigLoaderYaml(new Parser(), '/absolute/path/to/config.yml');
$toggle = new ToggleConfig($loader, 'awesomefeature/'.$yourCurrentEnvironment);
if ($toggle->on()) {
    // Code to be executed when the feature is enabled.
}
```

and

```
use KrystalCode\FeatureToggle\ConfigLoaderYaml;
use KrystalCode\FeatureToggle\ToggleConfig;
use Symfony\Component\Yaml\Parser;

$loader = new ConfigLoaderYaml(new Parser(), '/absolute/path/to/config.yml');
$toggle = new ToggleConfig($loader, 'theme', 'blue');
if ($toggle->on()) {
    // Code to be executed when the feature is enabled.
}
```

For PHP:

```
use KrystalCode\FeatureToggle\ConfigLoaderPhp;
use KrystalCode\FeatureToggle\ToggleConfig;

$loader = new ConfigLoaderPhp('/absolute/path/to/config.php');
$toggle = new ToggleConfig($loader, 'awesomefeature/'.$yourCurrentEnvironment);
if ($toggle->on()) {
    // Code to be executed when the feature is enabled.
}
```

and for INI:

```
use KrystalCode\FeatureToggle\ConfigLoaderIni;
use KrystalCode\FeatureToggle\ToggleConfig;

$loader = new ConfigLoaderIni('/absolute/path/to/config.ini');
$toggle = new ToggleConfig($loader, 'theme', 'blue');
if ($toggle->on()) {
    // Code to be executed when the feature is enabled.
}
```

## How to contribute

Feel free to submit pull requests. If you have ideas for new features or use cases that are not covered, open an issue to discuss.
