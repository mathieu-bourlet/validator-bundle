<?php

namespace AssoConnect\ValidatorBundle\Validator\Constraints;

use libphonenumber\PhoneNumberType;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Sylvain Fabre <sylvain.fabre@assoconnect.com>
 */
Class PhoneLandline extends Phone
{

    public $validTypes = [
        PhoneNumberType::FIXED_LINE_OR_MOBILE,
        PhoneNumberType::FIXED_LINE,
    ];

    public $invalidTypes = [
        PhoneNumberType::MOBILE,
        PhoneNumberType::SHARED_COST,
        PhoneNumberType::VOIP,
    ];

    public $invalidTypeMessage = 'This value is not a valid landline phone number.';
}