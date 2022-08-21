<?php

namespace App\EventListener;

use App\Entity\GalleryEntity;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;

final class GalleriedEventSubscriber implements EventSubscriberInterface
{
    public const INTERFACE_FQNS = 'App\\Interfaces\\GalleriedEntityInterface';
    private ?string $targetEntity = null;

    /**
     * Adds mapping to the galleried and galleries.
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $loadClassMetadataEventArgs): void
    {
        $metaData = $loadClassMetadataEventArgs->getClassMetadata();

        if (!in_array(self::INTERFACE_FQNS, class_implements($metaData->getName()))) {
            return;
        }

        $namingStrategy = $loadClassMetadataEventArgs
            ->getEntityManager()
            ->getConfiguration()
            ->getNamingStrategy()
        ;

        $metaData->mapManyToMany([
            'targetEntity' => GalleryEntity::class,
            'fieldName' => 'gallery',
            'cascade' => ['persist'],
            'joinTable' => [
                'name' => strtolower($namingStrategy->classToTableName($metaData->getName())).'s_gallery',
                'joinColumns' => [
                    [
                        'name' => $namingStrategy->joinKeyColumnName($metaData->getName()),
                        'referencedColumnName' => $namingStrategy->referenceColumnName(),
                        'onDelete' => 'CASCADE',
                        'onUpdate' => 'CASCADE',
                    ],
                ],
                'inverseJoinColumns' => [
                    [
                        'name' => 'gallery_id',
                        'referencedColumnName' => $namingStrategy->referenceColumnName(),
                        'onDelete' => 'CASCADE',
                        'onUpdate' => 'CASCADE',
                    ],
                ],
            ],
        ]);
    }

    public function prePersist(LifecycleEventArgs $lifecycleEventArgs): void
    {
    }

    public function postPersist(LifecycleEventArgs $lifecycleEventArgs): void
    {
    }

    public function getSubscribedEvents(): array
    {
        return [Events::loadClassMetadata, Events::prePersist, Events::postPersist];
    }

    private function mapGalleriedEntity(ClassMetadataInfo $classMetadataInfo): void
    {
        $this->targetEntity = $classMetadataInfo->reflClass->getName();

        $classMetadataInfo->mapOneToMany([
            'targetEntity' => GalleryEntity::class,
            'mappedBy' => 'parent',
            'fieldName' => 'gallery',
            'indexedBy' => 'parent_type',
            'fetch' => ClassMetadataInfo::FETCH_LAZY,
            'cascade' => ['persist', 'merge', 'remove'],
            'orphanRemoval' => true,
        ]);
    }

    private function mapGalleryEntity(ClassMetadataInfo $classMetadataInfo, ObjectManager $objectManager): void
    {
        if (!$classMetadataInfo->hasAssociation('parent')) {
            /** @var ClassMetadataInfo $classMetadata */
            $classMetaData = $objectManager->getClassMetadata($this->targetEntity);
            $singleIdentifierFieldName = $classMetaData->getSingleIdentifierFieldName();

            $classMetadataInfo->mapManyToOne([
                'fieldName' => 'parent',
                'inversedBy' => 'gallery',
                'cascade' => ['persist', 'merge'],
                'fetch' => ClassMetadataInfo::FETCH_LAZY,
                'joinColumns' => [
                    [
                        'name' => 'parent_id',
                        'referencedColumnName' => $singleIdentifierFieldName,
                        'onDelete' => 'CASCADE',
                    ],
                ],
                'targetEntity' => $this->targetEntity,
            ]);
//            dump($classMetadataInfo);
//            die();
//            dump($classMetadataInfo);
//            dump($classMetadataInfo->hasField('parent_type'));
//            dump($classMetadataInfo->hasAssociation('parent_type'));
            if (false === $classMetadataInfo->hasField('parentType') && false === $classMetadataInfo->hasAssociation('parentType')) {
                $classMetadataInfo->mapField([
                    'fieldName' => 'parentType',
                    'type' => 'string',
                    'length' => 255,
                ]);
            }
        }
    }
}
