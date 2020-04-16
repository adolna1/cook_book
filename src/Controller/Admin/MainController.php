<?php


namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller\Admin
 * @Route("admin")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="admin_index")
     * @return
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
}