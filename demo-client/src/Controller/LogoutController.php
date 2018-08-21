<?php
namespace App\Controller;

use OpenEuropa\pcas\Utils\GlobalVariablesGetter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LogoutController extends DefaultController
{
    /**
     * @Route("/logout", name="logout")
     */
    public function indexAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        $query['service'] = $this->generateUrl(
            'homepage',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        if (GlobalVariablesGetter::has('service')) {
            $query['service'] = GlobalVariablesGetter::get('service');
        }

        $redirect = $this->redirectToRoute('homepage');

        if ($response = $pCas->logout($query)) {
            $redirect = (new HttpFoundationFactory())->createResponse($response);
        }

        return $redirect;
    }
}
