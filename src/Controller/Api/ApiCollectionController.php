<?php

namespace App\Controller\Api;

use App\Entity\CollectionUser;
use App\Form\Api\CollectionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route("/api/collection", name="api_collection_")
 */
final class ApiCollectionController extends AbstractApiController
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

    /**
     * @Route("/all", name="all", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        $collections = $this->getDoctrine()->getRepository(CollectionUser::class)->findAll();
        $collections = $this->serializer->serialize($collections, JsonEncoder::FORMAT, [
            AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 1,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::GROUPS => ['groups' => 'collection-all']
        ]);

        return new JsonResponse($collections, Response::HTTP_OK, [], true);
    }
}
