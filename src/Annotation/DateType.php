<?php

namespace Mapper\Annotation;

use Mapper\DTO\Mapping\ScalarTypeInterface;
use Mapper\Transformer\DateTransformer;
use function is_string;

/**
 * @Annotation
 */
class DateType implements ScalarTypeInterface
{
    use NullableTrait;

    /**
     * @var string|null
     */
    public $format;

    public function getTransformerName(): string
    {
        return DateTransformer::getName();
    }

    public function getTransformerOptions(): array
    {
        $options = [];

        if ($this->format) {
            if (!is_string($this->format)) {
                throw new \InvalidArgumentException();
            }

            $options[DateTransformer::FORMAT_OPTION_NAME] = $this->format;
        }

        return $options;
    }
}
