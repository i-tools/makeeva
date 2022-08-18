<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return '';
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Просмотр')
            ->setPageTitle(Crud::PAGE_NEW, 'Создание')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование')
            ->setFormThemes([
                '@EasyAdmin/crud/form_theme.html.twig',
                '@FOSCKEditor/Form/ckeditor_widget.html.twig',
            ])
            ->setSearchFields(['title', 'description', 'content'])
        ;
    }
}