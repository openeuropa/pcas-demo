<?php
namespace App\Controller\Page;

use App\Controller\DefaultController;
use OpenEuropa\pcas\Utils\GlobalVariablesGetter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * @todo: Remove this after following issue is resolved.
 * @link https://webgate.ec.europa.eu/CITnet/jira/browse/OPENEUROPA-792
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PageController extends DefaultController
{
    /**
     * @Route("/page/simple", name="page_simple")
     */
    public function pageSimpleAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        // replace this example code with whatever you need
        return $this->render('page/simple.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ] + $this->defaultVars($pCas, $request));
    }

    /**
     * @Route("/page/restricted", name="page_restricted")
     */
    public function pageRestrictedAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        if ($response = $pCas->login()) {
            $httpFoundationFactory = new HttpFoundationFactory();

            return $httpFoundationFactory->createResponse($response);
        }

        // replace this example code with whatever you need
        return $this->render('page/restricted.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ] + $this->defaultVars($pCas, $request));
    }

    /**
     * @Route("/page/forcelogin", name="page_forcelogin")
     */
    public function pageForceLoginAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        if ($response = $pCas->renewLogin()) {
            return (new HttpFoundationFactory())->createResponse($response);
        }

        // replace this example code with whatever you need
        return $this->render('page/forcelogin.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ] + $this->defaultVars($pCas, $request));
    }

    /**
     * @Route("/page/gatewaylogin", name="page_gatewaylogin")
     */
    public function pageGatewayLoginAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        if ($response = $pCas->gatewayAuthentication()) {
            return (new HttpFoundationFactory())->createResponse($response);
        }

        // replace this example code with whatever you need
        return $this->render('page/gatewaylogin.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ] + $this->defaultVars($pCas, $request));
    }

    /**
     * @Route("/page/forcelogout", name="page_forcelogout")
     */
    public function pageForceLogoutAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        $query = [];

        if (GlobalVariablesGetter::has('service')) {
            $query['service'] = GlobalVariablesGetter::get('service');
        }

        if ($pCas->isAuthenticated()) {
            $httpFoundationFactory = new HttpFoundationFactory();

            return $httpFoundationFactory->createResponse($pCas->logout($query));
        }

        // replace this example code with whatever you need
        return $this->render('page/forcelogout.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ] + $this->defaultVars($pCas, $request));
    }
}
