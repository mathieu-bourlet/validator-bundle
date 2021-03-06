<?php

namespace AssoConnect\ValidatorBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 */
final class Postal extends Constraint
{
    public const INVALID_FORMAT_ERROR = 'ea4eb1eb-3984-4455-9b00-dcbf5221f933';

    public const MISSING_ERROR = '799ee5b5-5cc6-4d85-abd3-8efdfd536f29';

    public const NOT_REQUIRED_ERROR = '4c07fa49-108a-49af-9983-f547ee477351';

    public const UNEXPECTED_COUNTRY_ERROR = 'd3710953-d14c-444f-bc7d-8d1a45d7e413';

    protected static $errorNames = array(
        self::INVALID_FORMAT_ERROR => 'The postal {{ value }} does not have a valid format',
        self::MISSING_ERROR => 'The country requires a postal',
        self::NOT_REQUIRED_ERROR => 'The country does not require a postal',
        self::UNEXPECTED_COUNTRY_ERROR => 'The country {{ value }} is not configured by this bundle',
    );

    public $countryPropertyPath;

    public function getRequiredOptions()
    {
        return [
            'countryPropertyPath',
        ];
    }

    public function getDefaultOption()
    {
        return 'countryPropertyPath';
    }
}
