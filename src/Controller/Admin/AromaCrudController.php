<?php

namespace App\Controller\Admin;

use App\Entity\Aroma;
use App\Form\Field\CKEditorField;
use App\Form\Filters\PlanetFilter;
use App\Form\GalleryFormType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use function Symfony\Component\Translation\t;

class AromaCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aroma::class;
    }

    public function configureFilters(Filters$filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('published', 'Статус пуликации'))
            ->add(PlanetFilter::new('planet', 'Планета'))
            ->add(DatetimeFilter::new('createdAt', 'Дата создания'))
            ->add(DatetimeFilter::new('updatedAt', 'Дата изменения'))
            ;
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
        $description = CKEditorField::new('description', t('Description', [], 'admin.planets'))
            ->setFormTypeOption('config_name', 'description_config')
        ;
        $content = CKEditorField::new('content', t('Content', [], 'admin.aromas'));

        $gallery = CollectionField::new('gallery', t('Gallery', [], 'admin.stones'))
            ->allowAdd()
            ->allowDelete()
            ->setEntryType(GalleryFormType::class)
            ->setCustomOption('upload_dir', $this->getParameter('app.aromas.images.path'))
//            ->setCustomOption('download_path', $this->getParameter('app.aromas.images.path'))
            ->setEntryIsComplex(false)
            ->setFormTypeOption('by_reference', false)
        ;

        return match ($pageName) {
            Crud::PAGE_EDIT, Crud::PAGE_NEW => [
                FormField::addTab(t('Basic', [], 'admin.aromas')),
                $published,
                $title->setColumns(6),
                $planets->setColumns(6),
                $image->setColumns(6),
                $slug->setColumns(6),
                $description->setColumns(12),
                $content->setColumns(12),
//                FormField::addTab(t('SEO', [], 'admin.aromas')),
                FormField::addTab(t('Gallery', [], 'admin.stones')),
                $gallery->setColumns(12)
            ],
            default => [$title, $published, $planets, $createdAt, $updatedAt],
        };
    }
}
