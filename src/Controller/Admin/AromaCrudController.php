<?php

namespace App\Controller\Admin;

use App\Entity\Aroma;
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

class AromaCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aroma::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $published = BooleanField::new('published', t('Published', [], 'admin.aromas'));
        $createdAt = DateField::new('createdAt', 'Created');
        $updatedAt = DateField::new('updatedAt', 'Updated');
        $image = ImageField::new('imageName', t('Image', [], 'admin.aromas'))
            ->setUploadDir($this->getParameter('app.aromas.images.path'))
            ->setBasePath($this->getParameter('app.aromas.images.uri'))
            ->setUploadedFileNamePattern("[slug]-[timestamp].[extension]");
        $planets = AssociationField::new('planet', t('Planet', [], 'admin.aromas'));
        $title = TextField::new('title', t('Title', [], 'admin.aromas'));
        $slug = SlugField::new('slug', t('Slug', [], 'admin.aromas'))
            ->setTargetFieldName('title')
        ;
        $content = CKEditorField::new('content', t('Content', [], 'admin.aromas'));

        return match ($pageName) {
            Crud::PAGE_EDIT, Crud::PAGE_NEW => [
                FormField::addTab(t('Basic', [], 'admin.aromas')),
                $published,
                $title->setColumns(6),
                $planets->setColumns(6),
                $image->setColumns(6),
                $slug->setColumns(6),
                $content->setColumns(12),
                FormField::addTab(t('SEO', [], 'admin.aromas')),
            ],
            default => [$title, $published, $planets, $createdAt, $updatedAt],
        };
    }
}
