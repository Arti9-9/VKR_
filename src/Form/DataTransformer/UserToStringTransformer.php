<?php

namespace App\Form\DataTransformer;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserToStringTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($user): string
    {
        if ($user === null) {
            return '';
        }

        return $user->getId();
    }

    public function reverseTransform($userId): ?User
    {
        if (!$userId) {
            return null;
        }

        $user = $this->entityManager
            ->getRepository(User::class)
            ->find($userId);

        if ($user === null) {
            throw new TransformationFailedException(sprintf(
                'Пользователь с id "%s" не существует!',
                $userId
            ));
        }

        return $user;
    }
}