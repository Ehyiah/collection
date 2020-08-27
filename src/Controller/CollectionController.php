<?php

namespace App\Controller;

use App\Entity\CollectionUser;
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

        return new JsonResponse($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST, [], true);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"PATCH"})
     */
    public function editCollection(CollectionUser $collectionUser, Request $request): JsonResponse
    {
        $form = $this->createForm(CollectionType::class, $collectionUser)
            ->submit($this->getJson($request), false)
        ;

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse('Collection modifiée', Response::HTTP_OK);
        }

        return new JsonResponse($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST, [], true);
    }

    /**
     * @Route("/delete/{id}", name="edit", methods={"DELETE"})
     */
    public function deleteCollection(CollectionUser $collectionUser): JsonResponse
    {
        $this->getDoctrine()->getManager()->remove($collectionUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse('Collection supprimée', Response::HTTP_OK);
    }
}
