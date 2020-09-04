<?php

namespace App\Controller\Api;

use App\Form\Api\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/user", name="user_")
 */
final class ApiUserController extends AbstractApiController
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(SerializerInterface $serializer, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($serializer);
        $this->encoder = $encoder;
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $form = $this->createForm(UserType::class)
            ->submit($this->getJson($request));

        if ($form->isValid()) {
            $user = $form->getData();
            $user->setPassword($this->encoder->encodePassword($user, $form->getData()->getPlainPassword()));

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse('Utilisateur créé', Response::HTTP_OK);
        }

        return new JsonResponse($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST, [], true);
    }
}
