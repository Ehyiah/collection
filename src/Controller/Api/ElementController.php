<?php

namespace App\Controller\Api;

use App\Entity\CollectionUser;
use App\Entity\Element;
use App\Form\Api\ElementType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/element", name="element_")
 */
final class ElementController extends AbstractApiController
{
    /**
     * @Route("/add/{id}", name="add", methods={"POST"})
     */
    public function addElement(CollectionUser $collectionUser, Request $request): JsonResponse
    {
        $form = $this->createForm(ElementType::class)->submit($this->getJson($request), false);

        /** @var Element $data */
        $data = $form->getData();
        if ($form->isValid()) {
            $data->setCollectionUser($collectionUser);

            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse('Element added', Response::HTTP_CREATED);
        }

        return new JsonResponse($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST, [], true);
    }
}
