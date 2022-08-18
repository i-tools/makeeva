<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Planet;
use App\Form\Field\CKEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use function Symfony\Component\Translation\t;

class PlanetCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Planet::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('published', 'Статус пуликации'))
            ->add(DatetimeFilter::new('createdAt', 'Дата создания'))
            ->add(DatetimeFilter::new('updatedAt', 'Дата изменения'))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $published = BooleanField::new('published', t('Published', [], 'admin.planets'));
        $createdAt = DateField::new('createdAt', 'Created');
        $updatedAt = DateField::new('updatedAt', 'Updated');
        $title = TextField::new('title', t('Title', [], 'admin.planets'));
        $image = ImageField::new('imageName', t('Image', [], 'admin.planets'))
            ->setUploadDir($this->getParameter('app.planets.images.path'))
            ->setBasePath($this->getParameter('app.planets.images.uri'))
            ->setUploadedFileNamePattern("[slug]-[timestamp].[extension]");
        $slug = SlugField::new('slug', t('Slug', [], 'admin.planets'))
            ->setTargetFieldName('title')
        ;
        $description = CKEditorField::new('description', t('Description', [], 'admin.planets'))
            ->setFormTypeOption('config_name', 'description_config')
        ;
        $content = CKEditorField::new('content', t('Content', [], 'admin.planets'));

        return match ($pageName) {
            Crud::PAGE_EDIT, Crud::PAGE_NEW => [
                FormField::addTab(t('Basic', [], 'admin.planets')),
                $published,
                $title->setColumns(6),
                $image->setColumns(6),
                $slug->setColumns(6),
                $description->setColumns(12),
                $content->setColumns(12),
//                FormField::addTab(t('SEO', [], 'admin.planets')),
            ],
            default => [$title, $published, $createdAt, $updatedAt],
        };
    }
}
