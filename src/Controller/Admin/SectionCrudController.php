<?php

namespace App\Controller\Admin;

use App\Entity\Section;
use App\Form\Field\CKEditorField;
use App\Form\GalleryFormType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use function Symfony\Component\Translation\t;

class SectionCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Section::class;
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
        $published = BooleanField::new('published', t('Published', [], 'admin.sections'));
        $createdAt = DateField::new('createdAt', 'Created');
        $updatedAt = DateField::new('updatedAt', 'Updated');
        $title = TextField::new('title', t('Title', [], 'admin.sections'));
        $slug = SlugField::new('slug', t('Slug', [], 'admin.sections'))
            ->setTargetFieldName('title')
        ;
        $description = CKEditorField::new('description', t('Description', [], 'admin.sections'))
            ->setFormTypeOption('config_name', 'description_config')
        ;
        $content = CKEditorField::new('content', t('Content', [], 'admin.sections'));

        return match ($pageName) {
            Crud::PAGE_EDIT, Crud::PAGE_NEW => [
                FormField::addTab(t('Basic', [], 'admin.sections')),
                $published,
                $title->setColumns(6),
                $slug->setColumns(6),
                $description->setColumns(12),
                $content->setColumns(12),
            ],
            default => [$title, $published, $createdAt, $updatedAt],
        };
    }
}
