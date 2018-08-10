<?php

namespace AppBundle\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Constraints as Assert;

class TeamValidator
{

    public function isValid($request)
    {
        $request = json_decode($request->getContent(), true);

        $validator = Validation::createValidator();

        $constraint = new Collection(array(
            'name'  => new NotBlank(),
            'stripe'  => new NotBlank(),
        ));

        $violations = $validator->validate($request, $constraint);

        $errors = [];
        foreach ($violations as $violation) {
            $field = preg_replace('/\[|\]/', "", $violation->getPropertyPath());
            $error = $violation->getMessage();
            $errors[] = "$field: " . $error;
        }

        if ($errors) {
            throw new InvalidOptionsException(
                "Missing parameter in request. " . implode(" ", $errors),
                []
            );
        }

        return $request;
    }
}
