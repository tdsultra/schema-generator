<?php

/*
 * This file is part of the API Platform TDS Ultra Schema Generator Fork
 *
 * (c) Toby Skinner <toby.skinner@tdsultra.com>
 *
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator;

use Doctrine\Inflector\InflectorFactory;
use Symfony\Component\String\Inflector\EnglishInflector;
use Symfony\Component\String\Inflector\InflectorInterface;

final class InflectorProxy implements InflectorInterface
{
    const DOCTRINE_INFLECTOR = 'doctrine';
    const SYMFONY_INFLECTOR = 'symfony';

    private $inflector;
    private $inflectorType;

    public function __construct($inflectorType) {

        if($inflectorType != static::DOCTRINE_INFLECTOR && $inflectorType != static::SYMFONY_INFLECTOR) {
            throw new \InvalidArgumentException('Inflector type must be ' . static::DOCTRINE_INFLECTOR . ' or ' . static::SYMFONY_INFLECTOR);
        }

        $this->inflectorType = $inflectorType;

        if($this->inflectorType == static::DOCTRINE_INFLECTOR) {
            $this->inflector = InflectorFactory::create()->build();
        }
        else if($this->inflectorType == static::SYMFONY_INFLECTOR) {
            $this->inflector = new EnglishInflector();
        }
    }

    public function singularize(string $plural): array {
        if($this->inflectorType == static::DOCTRINE_INFLECTOR) {
            return [$this->inflector->singularize($plural)];
        }
        else if($this->inflectorType == static::SYMFONY_INFLECTOR) {
            return $this->inflector->singularize($plural);
        }
    }

    public function pluralize(string $singular): array {
        if($this->inflectorType == static::DOCTRINE_INFLECTOR) {
            return [$this->inflector->pluralize($singular)];
        }
        else if($this->inflectorType == static::SYMFONY_INFLECTOR) {
            return $this->inflector->pluralize($singular);
        }
    }
}
