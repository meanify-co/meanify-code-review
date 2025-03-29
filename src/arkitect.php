<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\NotHaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $appSet = ClassSet::fromDir(__DIR__ . '/../../../../app');

    $rules = [];

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\\Http\\Controllers'))
        ->should(new HaveNameMatching('*Controller'))
        ->because('Controllers must end with Controller');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\\Http\\Locators'))
        ->should(new HaveNameMatching('*Locator'))
        ->because('Locators must end with Locator');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\\Services'))
        ->should(new HaveNameMatching('*Service'))
        ->because('Services must end with Service');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\\Jobs'))
        ->should(new HaveNameMatching('*Job'))
        ->because('Jobs must end with Job');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\\Console\\Commands'))
        ->should(new HaveNameMatching('*Command'))
        ->because('Commands must end with Command');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App'))
        ->should(new NotHaveNameMatching('*s'))
        ->because('Class names must not be in the plural');

    $config->add($appSet, ...$rules);
};
