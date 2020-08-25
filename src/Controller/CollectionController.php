<?php

namespace App\Controller;

use App\Form\CollectionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/collection", name="api_collection_")
 */
final class CollectionController extends AbstractApiController
{
    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $form = $this->createForm(CollectionType::class)
            ->submit($this->getJson($request))
        ;

        if ($form->isValid()) {
            $form->getData()->setUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse('Collection créée', Response::HTTP_CREATED);
        }

        return new JsonResponse($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }
}
