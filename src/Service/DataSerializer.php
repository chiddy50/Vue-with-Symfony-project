<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class DataSerializer
{
    public function serializeData($data, array $group)
    {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(new AnnotationReader())
        );

        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory)];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($data, 'json', $group);

        return $jsonContent;
    }

    public function serializeWithoutGroup($data)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($data, 'json');

        return $jsonContent;
    }
}