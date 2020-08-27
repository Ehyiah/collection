<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractApiController extends AbstractController
{
    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function getJson(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }

    protected function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            if ($error instanceof FormError) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }
        }

        foreach ($form->all() as $childForm) {
            $childErrors = $this->getErrorsFromForm($childForm);
            if ([] !== $childErrors) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }

        return $errors;
    }
}
