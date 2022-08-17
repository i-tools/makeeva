<?php

namespace App\Controller\Admin;

use App\Entity\Stone;
use App\Form\Field\CKEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Symfony\Component\Translation\t;

class StoneCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stone::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $published = BooleanField::new('published', t('Published', [], 'admin.stones'));
        $createdAt = DateField::new('createdAt', 'Created');
        $updatedAt = DateField::new('updatedAt', 'Updated');
        $image = ImageField::new('imageName', t('Image', [], 'admin.stones'))
            ->setUploadDir($this->getParameter('app.stones.images.path'))
            ->setBasePath($this->getParameter('app.stones.images.uri'))
            ->setUploadedFileNamePattern("[slug]-[timestamp].[extension]");
        $planets = AssociationField::new('planet', t('Planet', [], 'admin.stones'));
        $title = TextField::new('title', t('Title', [], 'admin.stones'));
        $slug = SlugField::new('slug', t('Slug', [], 'admin.stones'))
            ->setTargetFieldName('title')
        ;
        $content = CKEditorField::new('content', t('Content', [], 'admin.stones'));

        return match ($pageName) {
            Crud::PAGE_EDIT, Crud::PAGE_NEW => [
                FormField::addTab(t('Basic', [], 'admin.stones')),
                $published,
                $title->setColumns(6),
                $planets->setColumns(6),
                $image->setColumns(6),
                $slug->setColumns(6),
                $content->setColumns(12),
//                FormField::addTab(t('SEO', [], 'admin.stones')),
            ],
            default => [$title, $published, $planets, $createdAt, $updatedAt],
        };
    }
}
