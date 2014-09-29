# FeatureToggle

## About

FeatureToggle is an easy to use, extensible library that aims to provide feature toggle functionality for PHP applications.

## Model

The library model is based on Toggles which are classes that define algorithms used to evaluate whether a feature should be on or off (enabled or disabled). Examples may be a Toggle that reads a configuration file and decides based on a variable value, a Toggle that checks whether the user has a subscription plan, or a Toggle that fetches information from an external API and decides based on that.

## Requirements

Currently depends on the Symfony Yaml component (https://github.com/symfony/yaml).

## How to use

Provided Toggles

### ToggleConfigYaml

ToggleConfigYaml loads the configuration variables from a YAML file and decides based on a variable value. It extends the ToggleConfig class which statically stores the configuration vatiables so that they are loaded only once even if feature toggling is used in multiple places in the code.

Assuming the following configuration file contents:

```
awesomefeature/dev: true
awesomefeature/stage: true
awesomefeature/prod: false
```

The following code will enable the feature on the development and stage environments and disable it on the production environment.

```
use KrystalCode\FeatureToggle\Toggle;

$toggle = Toggle::get('yaml');
if ($toggle('absolute/path/to/config.yml', 'awesomefeature/'.$yourCurrentEnvironment)) {
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

$toggle = Toggle::get('yaml');
if ($toggle('absolute/path/to/config.yml', 'theme', 'blue')) {
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

    public function __construct($user) {
        $this->user = $user;
    }

    public function on() {
        // You can also add your logic here if preferred.
        return $this->user->isPremium();
    }
}
```

## Full syntax

The examples above are using the easy syntax provided by a helper class. The full syntax for these examples would be:

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

## How to contribute

Feel free to submit pull requests. If you have ideas for new features or use cases that are not covered, open an issue to discuss.