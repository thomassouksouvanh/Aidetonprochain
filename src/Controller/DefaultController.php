<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            //mettre un findalll de tous les annonces avec paginator
        ]);
    }

    /**
     * @Route("/je-peux-aider-jai-besoin-d-aide", name="choose_categorie")
     */
    public function option()
    {
        return $this->render('default/chooseOption.html.twig', [

        ]);
    }

    /**
     * @Route("/je-peux-aider/categories", name="iHelp_categorie")
     */
    public function iHelp()
    {
        return $this->render('default/iHelpCategorie.html.twig', [

        ]);
    }

    /**
     * @Route("/je-peux-aider/sous-categories/occupation", name="iHelp_occupation")
     */
    public function iHelpOcuppation()
    {
        return $this->render('default/iHelpOccupation.html.twig', [

        ]);
    }


    /**
     * @Route("/j-ai-besoin-d-aide/categories", name="iNeedHelp_categorie")
     */
    public function iNeedHelp()
    {
        return $this->render('default/iNeedCategorie.html.twig', [

        ]);
    }

    /**
     * @Route("/j-ai-besoin-d-aide/categories/occupation", name="iNeedHelp_occupation")
     */
    public function ineedHelpOcuppation()
    {
        return $this->render('default/iNeedHelpOccupation.html.twig', [

        ]);
    }

    /**
     * @return Response
     * @Route("/disclaimer", name="diclaimer")
     */
    public function disclaimer()
    {
        return $this->render('default/disclaimer.html.twig', [

        ]);
    }
}
