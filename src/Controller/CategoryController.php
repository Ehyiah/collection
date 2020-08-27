<?php

namespace App\Controller;

use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category", name="category_")
 */
final class CategoryController extends AbstractApiController
{
    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $form = $this->createForm(CategoryType::class)->submit($this->getJson($request));

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse('created', Response::HTTP_CREATED);
        }

        return new JsonResponse($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST, [], true);
    }
}
