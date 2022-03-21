<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Option 1. Make your dashboard redirect to the same page for all users
        return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. Make your dashboard redirect to different pages depending on the user
        if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
             // the name visible to end users
             ->setTitle('ACME Corp.')
             // you can include HTML contents too (e.g. to link to an image)
             ->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')
 
             // the path defined in this method is passed to the Twig asset() function
             ->setFaviconPath('favicon.svg')
 
             // the domain used by default is 'messages'
             ->setTranslationDomain('my-custom-domain')
 
             // there's no need to define the "text direction" explicitly because
             // its default value is inferred dynamically from the user locale
             ->setTextDirection('ltr')
 
             // set this option if you prefer the page content to span the entire
             // browser width, instead of the default design which sets a max width
             ->renderContentMaximized()
 
             // set this option if you prefer the sidebar (which contains the main menu)
             // to be displayed as a narrow column instead of the default expanded design
             ->renderSidebarMinimized()
 
             // by default, all backend URLs include a signature hash. If a user changes any
             // query parameter (to "hack" the backend) the signature won't match and EasyAdmin
             // triggers an error. If this causes any issue in your backend, call this method
             // to disable this feature and remove all URL signature checks
             ->disableUrlSignatures()
 
             // by default, all backend URLs are generated as absolute URLs. If you
             // need to generate relative URLs instead, call this method
             ->generateRelativeUrls()
         ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToUrl('Visit public website', null, '/'),
            MenuItem::linkToUrl('Search in Google', 'fab fa-google', 'https://google.com'),
            MenuItem::linkToRoute('The Label', 'fa ...', 'route_name'),
            MenuItem::linkToRoute('The Label', 'fa ...', 'route_name', ['routeParamName' => 'routeParamValue']),
            MenuItem::linkToDashboard('Home', 'fa fa-home'),
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section(),
            MenuItem::section('Blog'),
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),
            MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class),
            MenuItem::section('Blog'),
            MenuItem::section('Users'),
            MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            // links to the 'index' action of the Category CRUD controller
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class),

            // links to a different CRUD action
            MenuItem::linkToCrud('Add Category', 'fa fa-tags', Category::class)
                ->setAction('new'),

            MenuItem::linkToCrud('Show Main Category', 'fa fa-tags', Category::class)
                ->setAction('detail')
                ->setEntityId(1),

            // if the same Doctrine entity is associated to more than one CRUD controller,
            // use the 'setController()' method to specify which controller to use
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class)
                ->setController(LegacyCategoryCrudController::class),

            // uses custom sorting options for the listing
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class)
                ->setDefaultSort(['createdAt' => 'DESC']),
            MenuItem::linkToLogout('Logout', 'fa fa-exit'),
            MenuItem::linkToExitImpersonation('Stop impersonation', 'fa fa-exit'),
        ];
    }
}
